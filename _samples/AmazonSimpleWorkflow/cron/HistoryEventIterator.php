<?php
/*
 * Copyright 2012 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'sdk.class.php';

/*
 * When histories become long, you may need to paginate through the events
 * by making multiple service calls.
 */
class HistoryEventIterator implements Iterator {
    protected $swf;
    protected $events;
    protected $event_index;
    protected $next_page_token;
    protected $original_poll_request;

    public function __construct(AmazonSWF $swf_client, $original_request, $original_response) {
        $this->swf = $swf_client;
        $this->events = array();
        $this->event_index = 0;
        $this->next_page_token = null;
        $this->original_poll_request = $original_request;
        
        $this->_process_poll_response($original_response);
    }
    
    protected function _process_poll_response($response) {
        if (isset($response->body->nextPageToken)) {
            $this->next_page_token = (string) $response->body->nextPageToken;
        } else {
            $this->next_page_token = null;
        }

        $next_events = $response->body->events()->getArrayCopy();
        $this->events = array_merge($this->events, $next_events);
    }

    protected function _get_next_event_page() {
        if (isset($this->next_page_token)) {
            $next_page_opts = $this->original_poll_request;
            $next_page_opts['nextPageToken'] = $this->next_page_token;
    
            // Unfortunately, we need to retry this because you can be throttled if you have a lot of
            // pagination happening, and you want your decider to behave relatively predictably in
            // that case. A real application may want some sort of exponential backoff.
            $retry_count = 10;
            $current_retry = 1;
            $delay_between_tries = 2;
            $response = $this->swf->poll_for_decision_task($next_page_opts);
            
            while (!$response->isOK() && $current_retry < $retry_count) {
                sleep($delay_between_tries);
                $response = $this->swf->poll_for_decision_task($next_page_opts);
                ++$current_retry;
            }
    
            if (!$response->isOK()) {
                throw new RuntimeException(json_encode($response->body));
            }
    
            $this->_process_poll_response($response);
        }
    }

    public function rewind() {
        $this->event_index = 0;
    }

    public function current() {
        return $this->events[$this->event_index];
    }

    public function key() {
        return $this->event_index;
    }

    public function next() {
        ++$this->event_index;

        if ($this->event_index >= count($this->events) && isset($this->next_page_token)) {
            $this->_get_next_event_page();
        }
    }

    public function valid() {
        return $this->event_index < count($this->events);
    }
}

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
 * At some point it makes sense to separate polling logic and worker logic, but we've left
 * them together here for simplicity.
 */
class BasicActivityWorker {
    const ACTIVITY_NAME = "myActivityName";
    const ACTIVITY_VERSION = "myActivityVersion";
    const DEBUG = false;

    protected $swf;
    protected $domain;
    protected $task_list;
    
    public function __construct(AmazonSWF $swf_service, $domain, $task_list) {
        $this->domain = $domain;
        $this->task_list = $task_list;
        $this->swf = $swf_service;
    }
    
    public function start() {
        $this->_poll();
    }
    
    protected function _poll() {
        while (true) {
            $response = $this->swf->poll_for_activity_task(array(
                'domain' => $this->domain,
                'taskList' => array(
                    'name' => $this->task_list
                )
            ));
            
            if (self::DEBUG) {
                print_r($response->body);
            }
                       
            if ($response->isOK()) {
                $task_token = (string) $response->body->taskToken;
                
                if (!empty($task_token)) {                    
                    $activity_input = (string) $response->body->input;
                    $activity_output = $this->_execute_task($activity_input);
                    
                    $complete_opt = array(
                        'taskToken' => $task_token,
                        'result' => $activity_output
                    );
                    
                    $complete_response = $this->swf->respond_activity_task_completed($complete_opt);
                    
                    if ($complete_response->isOK()) {
                        echo "RespondActivityTaskCompleted SUCCESS\n";
                    } else {
                        // a real application may want to report this failure and retry
                        echo "RespondActivityTaskCompleted FAIL\n";
                        echo "Response body:\n";
                        print_r($complete_response->body);
                        echo "Request JSON:\n";
                        echo json_encode($complete_opt) . "\n";
                    }
                } else {
                    echo "PollForActivityTask received empty response.\n";
                }
            } else {
                echo 'ERROR: ';
                print_r($response->body);
                
                sleep(2);
            }
        }        
    }
    
    protected function _execute_task($input) {
        $output = "Hello $input!";
        return $output;
    }
}

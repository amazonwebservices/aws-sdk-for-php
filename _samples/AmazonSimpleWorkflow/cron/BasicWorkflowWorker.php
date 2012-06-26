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
require_once 'HistoryEventIterator.php';

/*
 * A decider can be written by modeling the workflow as a state machine. 
 * For complex workflows, this is the easiest model to use.
 *
 * The decider reads the history to figure out which state the workflow is currently in,
 * and makes a decision based on the current state.
 *
 * This implementation of the decider ignores activity failures.
 * You can handle them by adding more states.
 * This decider also only supports having a single activity open at a time.
 */
abstract class BasicWorkflowWorkerStates {
    // A new workflow is in this state
    const START = 0;
    
    // If a timer is open, and not an activity.
    const TIMER_OPEN = 1;
    
    // If an activity is open, and not a timer.
    const ACTIVITY_OPEN = 2;
    
    // If both a timer and an activity are open.
    const TIMER_AND_ACTIVITY_OPEN = 3;

    // Nothing is open.
    const NOTHING_OPEN = 4;
}

/*
 * At some point it makes sense to separate polling logic and worker logic, but we've left
 * them together here for simplicity.
 */
class BasicWorkflowWorker {
    const DEBUG = false;

    const WORKFLOW_NAME = "myWorkflowName";
    const WORKFLOW_VERSION = "myWorkflowVersion";

    const ACTIVITY_NAME_KEY = 'activityName';
    const ACTIVITY_VERSION_KEY = 'activityVersion';
    const ACTIVITY_TASK_LIST_KEY = 'activityTaskList';
    const ACTIVITY_INPUT_KEY = 'activityInput';
    const TIMER_DURATION_KEY = 'timerDuration';
    
    // If you increase this value, you should also
    // increase your workflow execution timeout accordingly so that a 
    // new generation is started before the workflow times out.
    const EVENT_THRESHOLD_BEFORE_NEW_GENERATION = 150;

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
            $opts = array(
                'domain' => $this->domain,
                'taskList' => array(
                    'name' => $this->task_list
                )
            );
            
            $response = $this->swf->poll_for_decision_task($opts);
            
                      
            if ($response->isOK()) {
                $task_token = (string) $response->body->taskToken;
                               
                if (!empty($task_token)) {
                    if (self::DEBUG) {
                        echo "Got history; handing to decider\n";
                    }
                                       
                    $history = $response->body->events();
                    
                    try {
                        $decision_list = self::_decide(new HistoryEventIterator($this->swf, $opts, $response));
                    } catch (Exception $e) {
                        // If failed decisions are recoverable, one could drop the task and allow it to be redriven by the task timeout.
                        echo 'Failing workflow; exception in decider: ', $e->getMessage(), "\n", $e->getTraceAsString(), "\n";
                        $decision_list = array(
                            wrap_decision_opts_as_decision('FailWorkflowExecution', array(
                                'reason' => substr('Exception in decider: ' . $e->getMessage(), 0, 256),
                                'details' => substr($e->getTraceAsString(), 0, 32768)
                            ))
                        );
                    }
                    
                    if (self::DEBUG) {
                        echo 'Responding with decisions: ';
                        print_r($decision_list);
                    }
                    
                    $complete_opt = array(
                        'taskToken' => $task_token,
                        'decisions'=> $decision_list
                    );
                    
                    $complete_response = $this->swf->respond_decision_task_completed($complete_opt);
                    
                    if ($complete_response->isOK()) {
                        echo "RespondDecisionTaskCompleted SUCCESS\n";
                    } else {
                        // a real application may want to report this failure and retry
                        echo "RespondDecisionTaskCompleted FAIL\n";
                        echo "Response body: \n";
                        print_r($complete_response->body);
                        echo "Request JSON: \n";
                        echo json_encode($complete_opt) . "\n";
                    }
                } else {
                    echo "PollForDecisionTask received empty response\n";
                }
            } else {
                echo 'ERROR: ';
                print_r($response->body);
                
                sleep(2);
            }
        }        
    }
    
    /**
     * A decider inspects the history of a workflow and then schedules more tasks based on the current state of 
     * the workflow.
     */
    protected static function _decide($history) {       
        $workflow_state = BasicWorkflowWorkerStates::START;
        
        $timer_opts = null;
        $activity_opts = null;
        $continue_as_new_opts = null;
        $max_event_id = 0;

        foreach ($history as $event) {
            self::_process_event($event, $workflow_state, $timer_opts, $activity_opts, $continue_as_new_opts, $max_event_id);
        }
        
        $timer_decision = wrap_decision_opts_as_decision('StartTimer', $timer_opts);
        $activity_decision = wrap_decision_opts_as_decision('ScheduleActivityTask', $activity_opts);        
        $continue_as_new_decision = wrap_decision_opts_as_decision('ContinueAsNewWorkflowExecution', $continue_as_new_opts);

        if ($workflow_state === BasicWorkflowWorkerStates::START) {
            return array(
                $timer_decision
            );
        } else if ($workflow_state === BasicWorkflowWorkerStates::NOTHING_OPEN) {
            if ($max_event_id >= BasicWorkflowWorker::EVENT_THRESHOLD_BEFORE_NEW_GENERATION) {
                return array(
                    $continue_as_new_decision
                );
            } else {
                return array(
                    $timer_decision,
                    $activity_decision
                );
            }
        } else {
            return array();
        }
    }

    /*
     * By reading events in the history, we can determine which state the workflow is in.
     * And then, based on the current state of the workflow, the decider knows what should happen next.
     */
    protected static function _process_event($event, &$workflow_state, &$timer_opts, &$activity_opts, &$continue_as_new_opts, &$max_event_id) {
        $event_type = (string) $event->eventType;
        $max_event_id = max($max_event_id, intval($event->eventId));
        
        if (BasicWorkflowWorker::DEBUG) {
            echo "event type: $event_type\n";
            print_r($event);
        }
        
        switch ($event_type) {
        case 'TimerStarted':
            if ($workflow_state === BasicWorkflowWorkerStates::NOTHING_OPEN ||
                    $workflow_state === BasicWorkflowWorkerStates::START) { 
                $workflow_state = BasicWorkflowWorkerStates::TIMER_OPEN;
            } else if ($workflow_state === BasicWorkflowWorkerStates::ACTIVITY_OPEN) {
                $workflow_state = BasicWorkflowWorkerStates::TIMER_AND_ACTIVITY_OPEN;
            }
            break;
        case 'TimerFired':
            if ($workflow_state === BasicWorkflowWorkerStates::TIMER_OPEN) { 
                $workflow_state = BasicWorkflowWorkerStates::NOTHING_OPEN;
            } else if ($workflow_state === BasicWorkflowWorkerStates::TIMER_AND_ACTIVITY_OPEN) {
                $workflow_state = BasicWorkflowWorkerStates::ACTIVITY_OPEN;
            }
            break;
        case 'ActivityTaskScheduled':
            if ($workflow_state === BasicWorkflowWorkerStates::NOTHING_OPEN) {
                $workflow_state = BasicWorkflowWorkerStates::ACTIVITY_OPEN;
            } else if ($workflow_state === BasicWorkflowWorkerStates::TIMER_OPEN) {
                $workflow_state = BasicWorkflowWorkerStates::TIMER_AND_ACTIVITY_OPEN;
            }
            break;
        case 'ActivityTaskCanceled':
            // add cancellation handling here
        case 'ActivityTaskFailed':
            // add failure handling here
            // when an activity fails, a real application may want to retry it or report the incident
        case 'ActivityTaskTimedOut':
            // add timeout handling here
            // when an activity times out, a real application may want to retry it or report the incident
        case 'ActivityTaskCompleted':
            if ($workflow_state === BasicWorkflowWorkerStates::ACTIVITY_OPEN) { 
                $workflow_state = BasicWorkflowWorkerStates::NOTHING_OPEN;
            } else if ($workflow_state === BasicWorkflowWorkerStates::TIMER_AND_ACTIVITY_OPEN) {
                $workflow_state = BasicWorkflowWorkerStates::TIMER_OPEN;
            }
            break;
        // This is the only case which doesn't only transition state; 
        // it also gathers the user's workflow input.
        case 'WorkflowExecutionStarted':
            $workflow_state = BasicWorkflowWorkerStates::START;
            
            // gather gather gather
            $event_attributes = $event->workflowExecutionStartedEventAttributes;
            $workflow_input = json_decode($event_attributes->input, true);
            
            if (BasicWorkflowWorker::DEBUG) {
                echo 'Workflow input: ';
                print_r($workflow_input);
            }                    
            
            $activity_opts = BasicWorkflowWorker::create_activity_opts_from_workflow_input($workflow_input);
            $timer_opts = BasicWorkflowWorker::create_timer_opts_from_workflow_input($workflow_input);
            $continue_as_new_opts = BasicWorkflowWorker::create_continue_as_new_opts_from_workflow_start($event_attributes);
            break;
        }
    }
        
    public static function create_activity_opts_from_workflow_input($input) {
        $activity_name = $input[BasicWorkflowWorker::ACTIVITY_NAME_KEY];
        $activity_version = $input[BasicWorkflowWorker::ACTIVITY_VERSION_KEY];
        $activity_task_list = $input[BasicWorkflowWorker::ACTIVITY_TASK_LIST_KEY];
        $activity_input = $input[BasicWorkflowWorker::ACTIVITY_INPUT_KEY];
        
        $activity_opts = array(
            'activityType' => array(
                'name' => $activity_name,
                'version' => $activity_version
            ),
            'activityId' => 'myActivityId-' . time(),
            'input' => $activity_input,
            // This is what specifying a task list at scheduling time looks like.
            // You can also register a type with a default task list and not specify one at scheduling time.
            // The value provided at scheduling time always takes precedence.
            'taskList' => array('name' => $activity_task_list),
            // This is what specifying timeouts at scheduling time looks like.
            // You can also register types with default timeouts and not specify them at scheduling time.
            // The value provided at scheduling time always takes precedence.
            'scheduleToCloseTimeout' => '30',
            'scheduleToStartTimeout' => '10',
            'startToCloseTimeout' => '60',
            'heartbeatTimeout' => 'NONE'
        );
        
        return $activity_opts;
    }
    
    public static function create_timer_opts_from_workflow_input($input) {
        $timer_duration = (string) $input[BasicWorkflowWorker::TIMER_DURATION_KEY];
        $timer_opts = array(
            'startToFireTimeout' => $timer_duration,
            'timerId' => '0'
        );
        
        return $timer_opts;
    }
    
    /*
     * When you continue a workflow execution as a new workflow execution, 
     * the start options don't carry over, so you need to specify them again.
     */
    public static function create_continue_as_new_opts_from_workflow_start($start_attributes) {
        $continue_as_new_opts = array(
            'childPolicy' => (string) $start_attributes->childPolicy,
            'input' => (string) $start_attributes->input,
            'workflowTypeVersion' => (string) $start_attributes->workflowType->version,
            // This is what specifying a task list at scheduling time looks like.
            // You can also register a type with a default task list and not specify one at scheduling time.
            // The value provided at scheduling time always takes precedence.
            'taskList' => array('name' => (string) $start_attributes->taskList->name),
            // This is what specifying timeouts at scheduling time looks like.
            // You can also register types with default timeouts and not specify them at scheduling time.
            // The value provided at scheduling time always takes precedence.
            'executionStartToCloseTimeout' => (string) $start_attributes->executionStartToCloseTimeout,
            'taskStartToCloseTimeout' => (string) $start_attributes->taskStartToCloseTimeout
        );
        
        return $continue_as_new_opts;
    }
}

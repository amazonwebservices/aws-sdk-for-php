<?php
/*
 * Copyright 2010-2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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

/**
 * The Amazon Simple Workflow Service API Reference is intended for programmers who need detailed
 * information about the Amazon SWF actions and data types.
 *  
 * For an broader overview of the Amazon SWF programming model, please go to the <a href=
 * "http://docs.amazonwebservices.com/amazonswf/latest/developerguide/">Amazon SWF Developer
 * Guide</a>.
 *  
 * This section provides an overview of Amazon SWF actions.
 *  
 * <strong>Action Categories</strong>
 *  
 * The Amazon SWF actions can be grouped into the following major categories.
 * 
 * <ul>
 * 	<li>Actions related to Activities</li>
 * 	<li>Actions related to Deciders</li>
 * 	<li>Actions related to Workflow Executions</li>
 * 	<li>Actions related to Administration</li>
 * 	<li>Actions related to Visibility</li>
 * </ul>
 * 
 * <strong>Actions related to Activities</strong>
 *  
 * The following are actions that are performed by activity workers:
 * 
 * <ul>
 * 	<li><a href="API_PollForActivityTask.html" title=
 * 		"PollForActivityTask">PollForActivityTask</a></li>
 * 	<li><a href="API_RespondActivityTaskCompleted.html" title=
 * 		"RespondActivityTaskCompleted">RespondActivityTaskCompleted</a></li>
 * 	<li><a href="API_RespondActivityTaskFailed.html" title=
 * 		"RespondActivityTaskFailed">RespondActivityTaskFailed</a></li>
 * 	<li><a href="API_RespondActivityTaskCanceled.html" title=
 * 		"RespondActivityTaskCanceled">RespondActivityTaskCanceled</a></li>
 * 	<li><a href="API_RecordActivityTaskHeartbeat.html" title=
 * 		"RecordActivityTaskHeartbeat">RecordActivityTaskHeartbeat</a></li>
 * </ul>
 * 
 * Activity workers use the <a href="API_PollForActivityTask.html" title=
 * "PollForActivityTask">PollForActivityTask</a> to get new activity tasks. After a worker
 * receives an activity task from Amazon SWF, it performs the task and responds using <a href=
 * "API_RespondActivityTaskCompleted.html" title=
 * "RespondActivityTaskCompleted">RespondActivityTaskCompleted</a> if successful or <a href=
 * "API_RespondActivityTaskFailed.html" title=
 * "RespondActivityTaskFailed">RespondActivityTaskFailed</a> if unsuccessful.
 *  
 * <strong>Actions related to Deciders</strong>
 *  
 * The following are actions that are performed by deciders:
 * 
 * <ul>
 * 	<li><a href="API_PollForDecisionTask.html" title=
 * 		"PollForDecisionTask">PollForDecisionTask</a></li>
 * 	<li><a href="API_RespondDecisionTaskCompleted.html" title=
 * 		"RespondDecisionTaskCompleted">RespondDecisionTaskCompleted</a></li>
 * </ul>
 * 
 * Deciders use <a href="API_PollForDecisionTask.html" title=
 * "PollForDecisionTask">PollForDecisionTask</a> to get decision tasks. After a decider receives a
 * decision task from Amazon SWF, it examines its workflow execution history and decides what to
 * do next. It calls <a href="API_RespondDecisionTaskCompleted.html" title=
 * "RespondDecisionTaskCompleted">RespondDecisionTaskCompleted</a> to complete the decision task
 * and provide zero or more next decisions.
 *  
 * <strong>Actions related to Workflow Executions</strong>
 *  
 * The following actions operate on a workflow execution:
 * 
 * <ul>
 * 	<li><a href="API_RequestCancelWorkflowExecution.html" title=
 * 		"RequestCancelWorkflowExecution">RequestCancelWorkflowExecution</a></li>
 * 	<li><a href="API_StartWorkflowExecution.html" title=
 * 		"StartWorkflowExecution">StartWorkflowExecution</a></li>
 * 	<li><a href="API_SignalWorkflowExecution.html" title=
 * 		"SignalWorkflowExecution">SignalWorkflowExecution</a></li>
 * 	<li><a href="API_TerminateWorkflowExecution.html" title=
 * 		"TerminateWorkflowExecution">TerminateWorkflowExecution</a></li>
 * </ul>
 * 
 * <strong>Actions related to Administration</strong>
 *  
 * Although you can perform administrative tasks from the Amazon SWF console, you can use the
 * actions in this section to automate functions or build your own administrative tools.
 *  
 * <strong>Activity Management</strong>
 * 
 * <ul>
 * 	<li><a href="API_RegisterActivityType.html" title=
 * 		"RegisterActivityType">RegisterActivityType</a></li>
 * 	<li><a href="API_DeprecateActivityType.html" title=
 * 		"DeprecateActivityType">DeprecateActivityType</a></li>
 * </ul>
 * 
 * <strong>Workflow Management</strong>
 * 
 * <ul>
 * 	<li><a href="API_RegisterWorkflowType.html" title=
 * 		"RegisterWorkflowType">RegisterWorkflowType</a></li>
 * 	<li><a href="API_DeprecateWorkflowType.html" title=
 * 		"DeprecateWorkflowType">DeprecateWorkflowType</a></li>
 * </ul>
 * 
 * <strong>Domain Management</strong>
 * 
 * <ul>
 * 	<li><a href="API_RegisterDomain.html" title="RegisterDomain">RegisterDomain</a></li>
 * 	<li><a href="API_DeprecateDomain.html" title="DeprecateDomain">DeprecateDomain</a></li>
 * </ul>
 * 
 * <strong>Workflow Execution Management</strong>
 * 
 * <ul>
 * 	<li><a href="API_RequestCancelWorkflowExecution.html" title=
 * 		"RequestCancelWorkflowExecution">RequestCancelWorkflowExecution</a></li>
 * 	<li><a href="API_TerminateWorkflowExecution.html" title=
 * 		"TerminateWorkflowExecution">TerminateWorkflowExecution</a></li>
 * </ul>
 * 
 * <strong>Visibility Actions</strong>
 *  
 * Although you can perform visibility actions from the Amazon SWF console, you can use the
 * actions in this section to build your own console or administrative tools.
 *  
 * <strong>Activity Visibility</strong>
 * 
 * <ul>
 * 	<li><a href="API_ListActivityTypes.html" title="ListActivities">ListActivityTypes</a></li>
 * 	<li><a href="API_DescribeActivityType.html" title=
 * 		"DescribeActivityType">DescribeActivity</a></li>
 * </ul>
 * 
 * <strong>Workflow Visibility</strong>
 * 
 * <ul>
 * 	<li><a href="API_ListWorkflowTypes.html" title="ListWorkflowTypes">ListWorkflowTypes</a></li>
 * 	<li><a href="API_DescribeWorkflowType.html" title=
 * 		"DescribeWorkflowType">DescribeWorkflowType</a></li>
 * </ul>
 * 
 * <strong>Workflow Execution Visibility</strong>
 * 
 * <ul>
 * 	<li><a href="API_DescribeWorkflowExecution.html" title=
 * 		"DescribeWorkflowExecution">DescribeWorkflowExecution</a></li>
 * 	<li><a href="API_ListOpenWorkflowExecutions.html" title=
 * 		"ListOpenWorkflowExecutions">ListOpenWorkflowExecutions</a></li>
 * 	<li><a href="API_ListClosedWorkflowExecutions.html" title=
 * 		"ListClosedWorkflowExecutions">ListClosedWorkflowExecutions</a></li>
 * 	<li><a href="API_CountOpenWorkflowExecutions.html" title=
 * 		"CountOpenWorkflowExecutions">CountOpenWorkflowExecutions</a></li>
 * 	<li><a href="API_CountClosedWorkflowExecutions.html" title=
 * 		"CountClosedWorkflowExecutions">CountClosedWorkflowExecutions</a></li>
 * 	<li><a href="API_GetWorkflowExecutionHistory.html" title=
 * 		"GetWorkflowExecutionHistory">GetWorkflowExecutionHistory</a></li>
 * </ul>
 * 
 * <strong>Domain Visibility</strong>
 * 
 * <ul>
 * 	<li><a href="API_ListDomains.html" title="ListDomains">ListDomains</a></li>
 * 	<li><a href="API_DescribeDomain.html" title="DescribeDomain">DescribeDomain</a></li>
 * </ul>
 * 
 * <strong>Task List Visibility</strong>
 * 
 * <ul>
 * 	<li><a href="API_CountPendingActivityTasks.html" title=
 * 		"CountPendingActivityTasks">CountPendingActivityTasks</a></li>
 * 	<li><a href="API_CountPendingDecisionTasks.html" title=
 * 		"CountPendingDecisionTasks">CountPendingDecisionTasks</a></li>
 * </ul>
 *
 * @version 2013.01.14
 * @license See the included NOTICE.md file for complete information.
 * @copyright See the included NOTICE.md file for complete information.
 * @link http://aws.amazon.com/simpleworkflow/ Amazon Simple Workflow
 * @link http://aws.amazon.com/simpleworkflow/documentation/ Amazon Simple Workflow documentation
 */
class AmazonSWF extends CFRuntime
{
	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = 'swf.us-east-1.amazonaws.com';

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_VIRGINIA = self::REGION_US_E1;

	/**
	 * Default service endpoint.
	 */
	const DEFAULT_URL = self::REGION_US_E1;


	/*%******************************************************************************************%*/
	// STATUS CONSTANTS

	/**
	 * Status: Registered
	 */
	const STATUS_REGISTERED = 'REGISTERED';

	/**
	 * Status: Deprecated
	 */
	const STATUS_DEPRECATED = 'DEPRECATED';


	/*%******************************************************************************************%*/
	// POLICY CONSTANTS

	/**
	 * Policy: Terminate
	 */
	const POLICY_TERMINATE = 'TERMINATE';

	/**
	 * Policy: Request Cancel
	 */
	const POLICY_REQUEST_CANCEL = 'REQUEST_CANCEL';

	/**
	 * Policy: Abandon
	 */
	const POLICY_ABANDON = 'ABANDON';


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of <AmazonSWF>.
	 *
	 * @param array $options (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>certificate_authority</code> - <code>boolean</code> - Optional - Determines which Cerificate Authority file to use. A value of boolean <code>false</code> will use the Certificate Authority file available on the system. A value of boolean <code>true</code> will use the Certificate Authority provided by the SDK. Passing a file system path to a Certificate Authority file (chmodded to <code>0755</code>) will use that. Leave this set to <code>false</code> if you're not sure.</li>
	 * 	<li><code>credentials</code> - <code>string</code> - Optional - The name of the credential set to use for authentication.</li>
	 * 	<li><code>default_cache_config</code> - <code>string</code> - Optional - This option allows a preferred storage type to be configured for long-term caching. This can be changed later using the <set_cache_config()> method. Valid values are: <code>apc</code>, <code>xcache</code>, or a file system path such as <code>./cache</code> or <code>/tmp/cache/</code>.</li>
	 * 	<li><code>key</code> - <code>string</code> - Optional - Your AWS key, or a session key. If blank, the default credential set will be used.</li>
	 * 	<li><code>secret</code> - <code>string</code> - Optional - Your AWS secret key, or a session secret key. If blank, the default credential set will be used.</li>
	 * 	<li><code>token</code> - <code>string</code> - Optional - An AWS session token.</li></ul>
	 * @return void
	 */
	public function __construct(array $options = array())
	{
		$this->api_version = '2012-01-25';
		$this->hostname = self::DEFAULT_URL;
		$this->auth_class = 'AuthV3JSON';
		$this->operation_prefix = "x-amz-target:SimpleWorkflowService.";

		return parent::__construct($options);
	}


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * This allows you to explicitly sets the region for the service to use.
	 *
	 * @param string $region (Required) The region to explicitly set. Available options are <REGION_US_E1>.
	 * @return $this A reference to the current instance.
	 */
	public function set_region($region)
	{
		// @codeCoverageIgnoreStart
		$this->set_hostname($region);
		return $this;
		// @codeCoverageIgnoreEnd
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Returns the number of closed workflow executions within the given domain that meet the
	 * specified filtering criteria.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain containing the workflow executions to count.</li>
	 * 	<li><code>startTimeFilter</code> - <code>array</code> - Optional - If specified, only workflow executions that meet the start time criteria of the filter are counted. <p class="note"> <code>startTimeFilter</code> and <code>closeTimeFilter</code> are mutually exclusive. You must specify one of these in a request but not both.</p> <ul>
	 * 		<li><code>oldestDate</code> - <code>string</code> - Required - Specifies the oldest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 		<li><code>latestDate</code> - <code>string</code> - Optional - Specifies the latest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	</ul></li>
	 * 	<li><code>closeTimeFilter</code> - <code>array</code> - Optional - If specified, only workflow executions that meet the close time criteria of the filter are counted. <p class="note"> <code>startTimeFilter</code> and <code>closeTimeFilter</code> are mutually exclusive. You must specify one of these in a request but not both.</p> <ul>
	 * 		<li><code>oldestDate</code> - <code>string</code> - Required - Specifies the oldest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 		<li><code>latestDate</code> - <code>string</code> - Optional - Specifies the latest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	</ul></li>
	 * 	<li><code>executionFilter</code> - <code>array</code> - Optional - If specified, only workflow executions matching the <code>WorkflowId</code> in the filter are counted. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>workflowId</code> - <code>string</code> - Required - The workflowId to pass of match the criteria of this filter.</li>
	 * 	</ul></li>
	 * 	<li><code>typeFilter</code> - <code>array</code> - Optional - If specified, indicates the type of the workflow executions to be counted. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - Name of the workflow type. This field is required.</li>
	 * 		<li><code>version</code> - <code>string</code> - Optional - Version of the workflow type.</li>
	 * 	</ul></li>
	 * 	<li><code>tagFilter</code> - <code>array</code> - Optional - If specified, only executions that have a tag that matches the filter are counted. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>tag</code> - <code>string</code> - Required - Specifies the tag that must be associated with the execution for it to meet the filter criteria. This field is required.</li>
	 * 	</ul></li>
	 * 	<li><code>closeStatusFilter</code> - <code>array</code> - Optional - If specified, only workflow executions that match this close status are counted. This filter has an affect only if <code>executionStatus</code> is specified as <code>CLOSED</code>. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>status</code> - <code>string</code> - Required - The close status that must match the close status of an execution for it to meet the criteria of this filter. This field is required. [Allowed values: <code>COMPLETED</code>, <code>FAILED</code>, <code>CANCELED</code>, <code>TERMINATED</code>, <code>CONTINUED_AS_NEW</code>, <code>TIMED_OUT</code>]</li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function count_closed_workflow_executions($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CountClosedWorkflowExecutions', $opt);
	}

	/**
	 * Returns the number of open workflow executions within the given domain that meet the specified
	 * filtering criteria.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain containing the workflow executions to count.</li>
	 * 	<li><code>startTimeFilter</code> - <code>array</code> - Required - Specifies the start time criteria that workflow executions must meet in order to be counted. <ul>
	 * 		<li><code>oldestDate</code> - <code>string</code> - Required - Specifies the oldest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 		<li><code>latestDate</code> - <code>string</code> - Optional - Specifies the latest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	</ul></li>
	 * 	<li><code>typeFilter</code> - <code>array</code> - Optional - Specifies the type of the workflow executions to be counted. <p class="note"> <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - Name of the workflow type. This field is required.</li>
	 * 		<li><code>version</code> - <code>string</code> - Optional - Version of the workflow type.</li>
	 * 	</ul></li>
	 * 	<li><code>tagFilter</code> - <code>array</code> - Optional - If specified, only executions that have a tag that matches the filter are counted. <p class="note"> <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>tag</code> - <code>string</code> - Required - Specifies the tag that must be associated with the execution for it to meet the filter criteria. This field is required.</li>
	 * 	</ul></li>
	 * 	<li><code>executionFilter</code> - <code>array</code> - Optional - If specified, only workflow executions matching the <code>WorkflowId</code> in the filter are counted. <p class="note"> <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>workflowId</code> - <code>string</code> - Required - The workflowId to pass of match the criteria of this filter.</li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function count_open_workflow_executions($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CountOpenWorkflowExecutions', $opt);
	}

	/**
	 * Returns the estimated number of activity tasks in the specified task list. The count returned
	 * is an approximation and is not guaranteed to be exact. If you specify a task list that no
	 * activity task was ever scheduled in then 0 will be returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain that contains the task list.</li>
	 * 	<li><code>taskList</code> - <code>array</code> - Required - The name of the task list. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function count_pending_activity_tasks($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CountPendingActivityTasks', $opt);
	}

	/**
	 * Returns the estimated number of decision tasks in the specified task list. The count returned
	 * is an approximation and is not guaranteed to be exact. If you specify a task list that no
	 * decision task was ever scheduled in then 0 will be returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain that contains the task list.</li>
	 * 	<li><code>taskList</code> - <code>array</code> - Required - The name of the task list. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function count_pending_decision_tasks($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CountPendingDecisionTasks', $opt);
	}

	/**
	 * Deprecates the specified <em>activity type</em>. After an activity type has been deprecated,
	 * you cannot create new tasks of that activity type. Tasks of this type that were scheduled
	 * before the type was deprecated will continue to run.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which the activity type is registered.</li>
	 * 	<li><code>activityType</code> - <code>array</code> - Required - The activity type to deprecate. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of this activity. <p class="note">The combination of activity type name and version must be unique within a domain.</p></li>
	 * 		<li><code>version</code> - <code>string</code> - Required - The version of this activity. <p class="note">The combination of activity type name and version must be unique with in a domain.</p></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function deprecate_activity_type($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeprecateActivityType', $opt);
	}

	/**
	 * Deprecates the specified domain. After a domain has been deprecated it cannot be used to create
	 * new workflow executions or register new types. However, you can still use visibility actions on
	 * this domain. Deprecating a domain also deprecates all activity and workflow types registered in
	 * the domain. Executions that were started before the domain was deprecated will continue to run.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>name</code> - <code>string</code> - Required - The name of the domain to deprecate.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function deprecate_domain($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeprecateDomain', $opt);
	}

	/**
	 * Deprecates the specified <em>workflow type</em>. After a workflow type has been deprecated, you
	 * cannot create new executions of that type. Executions that were started before the type was
	 * deprecated will continue to run. A deprecated workflow type may still be used when calling
	 * visibility actions.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which the workflow type is registered.</li>
	 * 	<li><code>workflowType</code> - <code>array</code> - Required - The workflow type to deprecate. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 		<li><code>version</code> - <code>string</code> - Required - The version of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function deprecate_workflow_type($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeprecateWorkflowType', $opt);
	}

	/**
	 * Returns information about the specified activity type. This includes configuration settings
	 * provided at registration time as well as other general information about the type.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which the activity type is registered.</li>
	 * 	<li><code>activityType</code> - <code>array</code> - Required - The activity type to describe. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of this activity. <p class="note">The combination of activity type name and version must be unique within a domain.</p></li>
	 * 		<li><code>version</code> - <code>string</code> - Required - The version of this activity. <p class="note">The combination of activity type name and version must be unique with in a domain.</p></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_activity_type($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeActivityType', $opt);
	}

	/**
	 * Returns information about the specified domain including description and status.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>name</code> - <code>string</code> - Required - The name of the domain to describe.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_domain($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeDomain', $opt);
	}

	/**
	 * Returns information about the specified workflow execution including its type and some
	 * statistics.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain containing the workflow execution.</li>
	 * 	<li><code>execution</code> - <code>array</code> - Required - The workflow execution to describe. <ul>
	 * 		<li><code>workflowId</code> - <code>string</code> - Required - The user defined identifier associated with the workflow execution.</li>
	 * 		<li><code>runId</code> - <code>string</code> - Required - A system generated unique identifier for the workflow execution.</li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_workflow_execution($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeWorkflowExecution', $opt);
	}

	/**
	 * Returns information about the specified <em>workflow type</em>. This includes configuration
	 * settings specified when the type was registered and other information such as creation date,
	 * current status, etc.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which this workflow type is registered.</li>
	 * 	<li><code>workflowType</code> - <code>array</code> - Required - The workflow type to describe. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 		<li><code>version</code> - <code>string</code> - Required - The version of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_workflow_type($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeWorkflowType', $opt);
	}

	/**
	 * Returns the history of the specified workflow execution. The results may be split into multiple
	 * pages. To retrieve subsequent pages, make the call again using the <code>nextPageToken</code>
	 * returned by the initial call.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain containing the workflow execution.</li>
	 * 	<li><code>execution</code> - <code>array</code> - Required - Specifies the workflow execution for which to return the history. <ul>
	 * 		<li><code>workflowId</code> - <code>string</code> - Required - The user defined identifier associated with the workflow execution.</li>
	 * 		<li><code>runId</code> - <code>string</code> - Required - A system generated unique identifier for the workflow execution.</li>
	 * 	</ul></li>
	 * 	<li><code>nextPageToken</code> - <code>string</code> - Optional - If a <code>NextPageToken</code> is returned, the result has more than one pages. To get the next page, repeat the call and specify the nextPageToken with all other arguments unchanged.</li>
	 * 	<li><code>maximumPageSize</code> - <code>integer</code> - Optional - Specifies the maximum number of history events returned in one page. The next page in the result is identified by the <code>NextPageToken</code> returned. By default 100 history events are returned in a page but the caller can override this value to a page size <em>smaller</em> than the default. You cannot specify a page size larger than 100.</li>
	 * 	<li><code>reverseOrder</code> - <code>boolean</code> - Optional - When set to <code>true</code>, returns the events in reverse order. By default the results are returned in ascending order of the <code>eventTimeStamp</code> of the events.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_workflow_execution_history($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('GetWorkflowExecutionHistory', $opt);
	}

	/**
	 * Returns information about all activities registered in the specified domain that match the
	 * specified name and registration status. The result includes information like creation date,
	 * current status of the activity, etc. The results may be split into multiple pages. To retrieve
	 * subsequent pages, make the call again using the <code>nextPageToken</code> returned by the
	 * initial call.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which the activity types have been registered.</li>
	 * 	<li><code>name</code> - <code>string</code> - Optional - If specified, only lists the activity types that have this name.</li>
	 * 	<li><code>registrationStatus</code> - <code>string</code> - Required - Specifies the registration status of the activity types to list. [Allowed values: <code>REGISTERED</code>, <code>DEPRECATED</code>]</li>
	 * 	<li><code>nextPageToken</code> - <code>string</code> - Optional - If on a previous call to this method a <code>NextResultToken</code> was returned, the results have more than one page. To get the next page of results, repeat the call with the <code>nextPageToken</code> and keep all other arguments unchanged.</li>
	 * 	<li><code>maximumPageSize</code> - <code>integer</code> - Optional - The maximum number of results returned in each page. The default is 100, but the caller can override this value to a page size <em>smaller</em> than the default. You cannot specify a page size greater than 100.</li>
	 * 	<li><code>reverseOrder</code> - <code>boolean</code> - Optional - When set to <code>true</code>, returns the results in reverse order. By default the results are returned in ascending alphabetical order of the <code>name</code> of the activity types.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_activity_types($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListActivityTypes', $opt);
	}

	/**
	 * Returns a list of closed workflow executions in the specified domain that meet the filtering
	 * criteria. The results may be split into multiple pages. To retrieve subsequent pages, make the
	 * call again using the nextPageToken returned by the initial call.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain that contains the workflow executions to list.</li>
	 * 	<li><code>startTimeFilter</code> - <code>array</code> - Optional - If specified, the workflow executions are included in the returned results based on whether their start times are within the range specified by this filter. Also, if this parameter is specified, the returned results are ordered by their start times. <p class="note"> <code>startTimeFilter</code> and <code>closeTimeFilter</code> are mutually exclusive. You must specify one of these in a request but not both.</p> <ul>
	 * 		<li><code>oldestDate</code> - <code>string</code> - Required - Specifies the oldest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 		<li><code>latestDate</code> - <code>string</code> - Optional - Specifies the latest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	</ul></li>
	 * 	<li><code>closeTimeFilter</code> - <code>array</code> - Optional - If specified, the workflow executions are included in the returned results based on whether their close times are within the range specified by this filter. Also, if this parameter is specified, the returned results are ordered by their close times. <p class="note"> <code>startTimeFilter</code> and <code>closeTimeFilter</code> are mutually exclusive. You must specify one of these in a request but not both.</p> <ul>
	 * 		<li><code>oldestDate</code> - <code>string</code> - Required - Specifies the oldest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 		<li><code>latestDate</code> - <code>string</code> - Optional - Specifies the latest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	</ul></li>
	 * 	<li><code>executionFilter</code> - <code>array</code> - Optional - If specified, only workflow executions matching the workflow id specified in the filter are returned. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>workflowId</code> - <code>string</code> - Required - The workflowId to pass of match the criteria of this filter.</li>
	 * 	</ul></li>
	 * 	<li><code>closeStatusFilter</code> - <code>array</code> - Optional - If specified, only workflow executions that match this <em>close status</em> are listed. For example, if TERMINATED is specified, then only TERMINATED workflow executions are listed. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>status</code> - <code>string</code> - Required - The close status that must match the close status of an execution for it to meet the criteria of this filter. This field is required. [Allowed values: <code>COMPLETED</code>, <code>FAILED</code>, <code>CANCELED</code>, <code>TERMINATED</code>, <code>CONTINUED_AS_NEW</code>, <code>TIMED_OUT</code>]</li>
	 * 	</ul></li>
	 * 	<li><code>typeFilter</code> - <code>array</code> - Optional - If specified, only executions of the type specified in the filter are returned. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - Name of the workflow type. This field is required.</li>
	 * 		<li><code>version</code> - <code>string</code> - Optional - Version of the workflow type.</li>
	 * 	</ul></li>
	 * 	<li><code>tagFilter</code> - <code>array</code> - Optional - If specified, only executions that have the matching tag are listed. <p class="note"> <code>closeStatusFilter</code>, <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>tag</code> - <code>string</code> - Required - Specifies the tag that must be associated with the execution for it to meet the filter criteria. This field is required.</li>
	 * 	</ul></li>
	 * 	<li><code>nextPageToken</code> - <code>string</code> - Optional - If on a previous call to this method a <code>NextPageToken</code> was returned, the results are being paginated. To get the next page of results, repeat the call with the returned token and all other arguments unchanged.</li>
	 * 	<li><code>maximumPageSize</code> - <code>integer</code> - Optional - The maximum number of results returned in each page. The default is 100, but the caller can override this value to a page size <em>smaller</em> than the default. You cannot specify a page size greater than 100.</li>
	 * 	<li><code>reverseOrder</code> - <code>boolean</code> - Optional - When set to <code>true</code>, returns the results in reverse order. By default the results are returned in descending order of the start or the close time of the executions.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_closed_workflow_executions($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListClosedWorkflowExecutions', $opt);
	}

	/**
	 * Returns the list of domains registered in the account. The results may be split into multiple
	 * pages. To retrieve subsequent pages, make the call again using the nextPageToken returned by
	 * the initial call.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>nextPageToken</code> - <code>string</code> - Optional - If on a previous call to this method a <code>NextPageToken</code> was returned, the result has more than one page. To get the next page of results, repeat the call with the returned token and all other arguments unchanged.</li>
	 * 	<li><code>registrationStatus</code> - <code>string</code> - Required - Specifies the registration status of the domains to list. [Allowed values: <code>REGISTERED</code>, <code>DEPRECATED</code>]</li>
	 * 	<li><code>maximumPageSize</code> - <code>integer</code> - Optional - The maximum number of results returned in each page. The default is 100, but the caller can override this value to a page size <em>smaller</em> than the default. You cannot specify a page size greater than 100.</li>
	 * 	<li><code>reverseOrder</code> - <code>boolean</code> - Optional - When set to <code>true</code>, returns the results in reverse order. By default the results are returned in ascending alphabetical order of the <code>name</code> of the domains.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_domains($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListDomains', $opt);
	}

	/**
	 * Returns a list of open workflow executions in the specified domain that meet the filtering
	 * criteria. The results may be split into multiple pages. To retrieve subsequent pages, make the
	 * call again using the nextPageToken returned by the initial call.
	 * 
	 * <p class="note">
	 * This operation is eventually consistent. The results are best effort and may not exactly
	 * reflect recent updates and changes.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain that contains the workflow executions to list.</li>
	 * 	<li><code>startTimeFilter</code> - <code>array</code> - Required - Workflow executions are included in the returned results based on whether their start times are within the range specified by this filter. <ul>
	 * 		<li><code>oldestDate</code> - <code>string</code> - Required - Specifies the oldest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 		<li><code>latestDate</code> - <code>string</code> - Optional - Specifies the latest start or close date and time to return. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	</ul></li>
	 * 	<li><code>typeFilter</code> - <code>array</code> - Optional - If specified, only executions of the type specified in the filter are returned. <p class="note"> <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - Name of the workflow type. This field is required.</li>
	 * 		<li><code>version</code> - <code>string</code> - Optional - Version of the workflow type.</li>
	 * 	</ul></li>
	 * 	<li><code>tagFilter</code> - <code>array</code> - Optional - If specified, only executions that have the matching tag are listed. <p class="note"> <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>tag</code> - <code>string</code> - Required - Specifies the tag that must be associated with the execution for it to meet the filter criteria. This field is required.</li>
	 * 	</ul></li>
	 * 	<li><code>nextPageToken</code> - <code>string</code> - Optional - If on a previous call to this method a <code>NextPageToken</code> was returned, the results are being paginated. To get the next page of results, repeat the call with the returned token and all other arguments unchanged.</li>
	 * 	<li><code>maximumPageSize</code> - <code>integer</code> - Optional - The maximum number of results returned in each page. The default is 100, but the caller can override this value to a page size <em>smaller</em> than the default. You cannot specify a page size greater than 100.</li>
	 * 	<li><code>reverseOrder</code> - <code>boolean</code> - Optional - When set to <code>true</code>, returns the results in reverse order. By default the results are returned in descending order of the start time of the executions.</li>
	 * 	<li><code>executionFilter</code> - <code>array</code> - Optional - If specified, only workflow executions matching the workflow id specified in the filter are returned. <p class="note"> <code>executionFilter</code>, <code>typeFilter</code> and <code>tagFilter</code> are mutually exclusive. You can specify at most one of these in a request.</p> <ul>
	 * 		<li><code>workflowId</code> - <code>string</code> - Required - The workflowId to pass of match the criteria of this filter.</li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_open_workflow_executions($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListOpenWorkflowExecutions', $opt);
	}

	/**
	 * Returns information about workflow types in the specified domain. The results may be split into
	 * multiple pages that can be retrieved by making the call repeatedly.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which the workflow types have been registered.</li>
	 * 	<li><code>name</code> - <code>string</code> - Optional - If specified, lists the workflow type with this name.</li>
	 * 	<li><code>registrationStatus</code> - <code>string</code> - Required - Specifies the registration status of the workflow types to list. [Allowed values: <code>REGISTERED</code>, <code>DEPRECATED</code>]</li>
	 * 	<li><code>nextPageToken</code> - <code>string</code> - Optional - If on a previous call to this method a <code>NextPageToken</code> was returned, the results are being paginated. To get the next page of results, repeat the call with the returned token and all other arguments unchanged.</li>
	 * 	<li><code>maximumPageSize</code> - <code>integer</code> - Optional - The maximum number of results returned in each page. The default is 100, but the caller can override this value to a page size <em>smaller</em> than the default. You cannot specify a page size greater than 100.</li>
	 * 	<li><code>reverseOrder</code> - <code>boolean</code> - Optional - When set to <code>true</code>, returns the results in reverse order. By default the results are returned in ascending alphabetical order of the <code>name</code> of the workflow types.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_workflow_types($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListWorkflowTypes', $opt);
	}

	/**
	 * Used by workers to get an <code>ActivityTask</code> from the specified activity
	 * <code>taskList</code>. This initiates a long poll, where the service holds the HTTP connection
	 * open and responds as soon as a task becomes available. The maximum time the service holds on to
	 * the request before responding is 60 seconds. If no task is available within 60 seconds, the
	 * poll will return an empty result. An empty result, in this context, means that an ActivityTask
	 * is returned, but that the value of taskToken is an empty string. If a task is returned, the
	 * worker should use its type to identify and process it correctly.
	 * 
	 * <p class="important">
	 * Workers should set their client side socket timeout to at least 70 seconds (10 seconds higher
	 * than the maximum time service may hold the poll request).
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain that contains the task lists being polled.</li>
	 * 	<li><code>taskList</code> - <code>array</code> - Required - Specifies the task list to poll for activity tasks. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn". <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 	</ul></li>
	 * 	<li><code>identity</code> - <code>string</code> - Optional - Identity of the worker making the request, which is recorded in the <code>ActivityTaskStarted</code> event in the workflow history. This enables diagnostic tracing when problems arise. The form of this identity is user defined.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function poll_for_activity_task($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('PollForActivityTask', $opt);
	}

	/**
	 * Used by deciders to get a <code>DecisionTask</code> from the specified decision
	 * <code>taskList</code>. A decision task may be returned for any open workflow execution that is
	 * using the specified task list. The task includes a paginated view of the history of the
	 * workflow execution. The decider should use the workflow type and the history to determine how
	 * to properly handle the task.
	 *  
	 * This action initiates a long poll, where the service holds the HTTP connection open and
	 * responds as soon a task becomes available. If no decision task is available in the specified
	 * task list before the timeout of 60 seconds expires, an empty result is returned. An empty
	 * result, in this context, means that a DecisionTask is returned, but that the value of taskToken
	 * is an empty string.
	 * 
	 * <p class="important">
	 * Deciders should set their client side socket timeout to at least 70 seconds (10 seconds higher
	 * than the timeout).
	 * </p>
	 * <p class="important">
	 * Because the number of workflow history events for a single workflow execution might be very
	 * large, the result returned might be split up across a number of pages. To retrieve subsequent
	 * pages, make additional calls to <code>PollForDecisionTask</code> using the
	 * <code>nextPageToken</code> returned by the initial call. Note that you do <strong>not</strong>
	 * call <code>GetWorkflowExecutionHistory</code> with this <code>nextPageToken</code>. Instead,
	 * call <code>PollForDecisionTask</code> again.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain containing the task lists to poll.</li>
	 * 	<li><code>taskList</code> - <code>array</code> - Required - Specifies the task list to poll for decision tasks. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn". <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 	</ul></li>
	 * 	<li><code>identity</code> - <code>string</code> - Optional - Identity of the decider making the request, which is recorded in the DecisionTaskStarted event in the workflow history. This enables diagnostic tracing when problems arise. The form of this identity is user defined.</li>
	 * 	<li><code>nextPageToken</code> - <code>string</code> - Optional - If on a previous call to this method a <code>NextPageToken</code> was returned, the results are being paginated. To get the next page of results, repeat the call with the returned token and all other arguments unchanged. <p class="note">The <code>nextPageToken</code> returned by this action cannot be used with <code>GetWorkflowExecutionHistory</code> to get the next page. You must call <code>PollForDecisionTask</code> again (with the <code>nextPageToken</code>) to retrieve the next page of history records. Calling <code>PollForDecisionTask</code> with a <code>nextPageToken</code> will not return a new decision task.</p> .</li>
	 * 	<li><code>maximumPageSize</code> - <code>integer</code> - Optional - The maximum number of history events returned in each page. The default is 100, but the caller can override this value to a page size <em>smaller</em> than the default. You cannot specify a page size greater than 100.</li>
	 * 	<li><code>reverseOrder</code> - <code>boolean</code> - Optional - When set to <code>true</code>, returns the events in reverse order. By default the results are returned in ascending order of the <code>eventTimestamp</code> of the events.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function poll_for_decision_task($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('PollForDecisionTask', $opt);
	}

	/**
	 * Used by activity workers to report to the service that the <code>ActivityTask</code>
	 * represented by the specified <code>taskToken</code> is still making progress. The worker can
	 * also (optionally) specify details of the progress, for example percent complete, using the
	 * <code>details</code> parameter. This action can also be used by the worker as a mechanism to
	 * check if cancellation is being requested for the activity task. If a cancellation is being
	 * attempted for the specified task, then the boolean <code>cancelRequested</code> flag returned
	 * by the service is set to <code>true</code>.
	 *  
	 * This action resets the <code>taskHeartbeatTimeout</code> clock. The
	 * <code>taskHeartbeatTimeout</code> is specified in <code>RegisterActivityType</code>.
	 *  
	 * This action does not in itself create an event in the workflow execution history. However, if
	 * the task times out, the workflow execution history will contain a
	 * <code>ActivityTaskTimedOut</code> event that contains the information from the last heartbeat
	 * generated by the activity worker.
	 * 
	 * <p class="note">
	 * The <code>taskStartToCloseTimeout</code> of an activity type is the maximum duration of an
	 * activity task, regardless of the number of <code>RecordActivityTaskHeartbeat</code> requests
	 * received. The <code>taskStartToCloseTimeout</code> is also specified in
	 * <code>RegisterActivityType</code>.
	 * </p>
	 * <p class="note">
	 * This operation is only useful for long-lived activities to report liveliness of the task and to
	 * determine if a cancellation is being attempted.
	 * </p>
	 * <p class="important">
	 * If the <code>cancelRequested</code> flag returns <code>true</code>, a cancellation is being
	 * attempted. If the worker can cancel the activity, it should respond with
	 * <code>RespondActivityTaskCanceled</code>. Otherwise, it should ignore the cancellation request.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>taskToken</code> - <code>string</code> - Required - The <code>taskToken</code> of the <code>ActivityTask</code>. <p class="important">The <code>taskToken</code> is generated by the service and should be treated as an opaque value. If the task is passed to another process, its <code>taskToken</code> must also be passed. This enables it to provide its progress and respond with results.</p></li>
	 * 	<li><code>details</code> - <code>string</code> - Optional - If specified, contains details about the progress of the task.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function record_activity_task_heartbeat($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RecordActivityTaskHeartbeat', $opt);
	}

	/**
	 * Registers a new <em>activity type</em> along with its configuration settings in the specified
	 * domain.
	 * 
	 * <p class="important">
	 * A <code>TypeAlreadyExists</code> fault is returned if the type already exists in the domain.
	 * You cannot change any configuration settings of the type after its registration, and it must be
	 * registered as a new version.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which this activity is to be registered.</li>
	 * 	<li><code>name</code> - <code>string</code> - Required - The name of the activity type within the domain. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 	<li><code>version</code> - <code>string</code> - Required - The version of the activity type. <p class="note">The activity type consists of the name and version, the combination of which must be unique within the domain.</p> The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 	<li><code>description</code> - <code>string</code> - Optional - A textual description of the activity type.</li>
	 * 	<li><code>defaultTaskStartToCloseTimeout</code> - <code>string</code> - Optional - If set, specifies the default maximum duration that a worker can take to process tasks of this activity type. This default can be overridden when scheduling an activity task using the <code>ScheduleActivityTask</code> <code>Decision</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration.</li>
	 * 	<li><code>defaultTaskHeartbeatTimeout</code> - <code>string</code> - Optional - If set, specifies the default maximum time before which a worker processing a task of this type must report progress by calling <code>RecordActivityTaskHeartbeat</code>. If the timeout is exceeded, the activity task is automatically timed out. This default can be overridden when scheduling an activity task using the <code>ScheduleActivityTask</code> <code>Decision</code>. If the activity worker subsequently attempts to record a heartbeat or returns a result, the activity worker receives an <code>UnknownResource</code> fault. In this case, Amazon SWF no longer considers the activity task to be valid; the activity worker should clean up the activity task. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration.</li>
	 * 	<li><code>defaultTaskList</code> - <code>array</code> - Optional - If set, specifies the default task list to use for scheduling tasks of this activity type. This default task list is used if a task list is not provided when a task is scheduled through the <code>ScheduleActivityTask</code> <code>Decision</code>. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 	</ul></li>
	 * 	<li><code>defaultTaskScheduleToStartTimeout</code> - <code>string</code> - Optional - If set, specifies the default maximum duration that a task of this activity type can wait before being assigned to a worker. This default can be overridden when scheduling an activity task using the <code>ScheduleActivityTask</code> <code>Decision</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration.</li>
	 * 	<li><code>defaultTaskScheduleToCloseTimeout</code> - <code>string</code> - Optional - If set, specifies the default maximum duration for a task of this activity type. This default can be overridden when scheduling an activity task using the <code>ScheduleActivityTask</code> <code>Decision</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function register_activity_type($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RegisterActivityType', $opt);
	}

	/**
	 * Registers a new domain.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>name</code> - <code>string</code> - Required - Name of the domain to register. The name must be unique. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 	<li><code>description</code> - <code>string</code> - Optional - Textual description of the domain.</li>
	 * 	<li><code>workflowExecutionRetentionPeriodInDays</code> - <code>string</code> - Required - Specifies the duration-- <strong><em>in days</em></strong> --for which the record (including the history) of workflow executions in this domain should be kept by the service. After the retention period, the workflow execution will not be available in the results of visibility calls. If a duration of <code>NONE</code> is specified, the records for workflow executions in this domain are not retained at all. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function register_domain($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RegisterDomain', $opt);
	}

	/**
	 * Registers a new <em>workflow type</em> and its configuration settings in the specified domain.
	 * 
	 * <p class="important">
	 * If the type already exists, then a <code>TypeAlreadyExists</code> fault is returned. You cannot
	 * change the configuration settings of a workflow type once it is registered and it must be
	 * registered as a new version.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which to register the workflow type.</li>
	 * 	<li><code>name</code> - <code>string</code> - Required - The name of the workflow type. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 	<li><code>version</code> - <code>string</code> - Required - The version of the workflow type. <p class="note">The workflow type consists of the name and version, the combination of which must be unique within the domain. To get a list of all currently registered workflow types, use the <code>ListWorkflowTypes</code> action.</p> The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 	<li><code>description</code> - <code>string</code> - Optional - Textual description of the workflow type.</li>
	 * 	<li><code>defaultTaskStartToCloseTimeout</code> - <code>string</code> - Optional - If set, specifies the default maximum duration of decision tasks for this workflow type. This default can be overridden when starting a workflow execution using the <code>StartWorkflowExecution</code> action or the <code>StartChildWorkflowExecution</code> <code>Decision</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration.</li>
	 * 	<li><code>defaultExecutionStartToCloseTimeout</code> - <code>string</code> - Optional - If set, specifies the default maximum duration for executions of this workflow type. You can override this default when starting an execution through the <code>StartWorkflowExecution</code> Action or <code>StartChildWorkflowExecution</code> <code>Decision</code>. The duration is specified in seconds. The valid values are integers greater than or equal to 0. Unlike some of the other timeout parameters in Amazon SWF, you cannot specify a value of "NONE" for <code>defaultExecutionStartToCloseTimeout</code>; there is a one-year max limit on the time that a workflow execution can run. Exceeding this limit will always cause the workflow execution to time out.</li>
	 * 	<li><code>defaultTaskList</code> - <code>array</code> - Optional - If set, specifies the default task list to use for scheduling decision tasks for executions of this workflow type. This default is used only if a task list is not provided when starting the execution through the <code>StartWorkflowExecution</code> Action or <code>StartChildWorkflowExecution</code> <code>Decision</code>. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 	</ul></li>
	 * 	<li><code>defaultChildPolicy</code> - <code>string</code> - Optional - If set, specifies the default policy to use for the child workflow executions when a workflow execution of this type is terminated, by calling the <code>TerminateWorkflowExecution</code> action explicitly or due to an expired timeout. This default can be overridden when starting a workflow execution using the <code>StartWorkflowExecution</code> action or the <code>StartChildWorkflowExecution</code> <code>Decision</code>. The supported child policies are:<ul><li> <strong>TERMINATE:</strong> the child executions will be terminated.</li><li> <strong>REQUEST_CANCEL:</strong> a request to cancel will be attempted for each child execution by recording a <code>WorkflowExecutionCancelRequested</code> event in its history. It is up to the decider to take appropriate actions when it receives an execution history with this event.</li><li> <strong>ABANDON:</strong> no action will be taken. The child executions will continue to run.</li></ul> [Allowed values: <code>TERMINATE</code>, <code>REQUEST_CANCEL</code>, <code>ABANDON</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function register_workflow_type($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RegisterWorkflowType', $opt);
	}

	/**
	 * Records a <code>WorkflowExecutionCancelRequested</code> event in the currently running workflow
	 * execution identified by the given domain, workflowId, and runId. This logically requests the
	 * cancellation of the workflow execution as a whole. It is up to the decider to take appropriate
	 * actions when it receives an execution history with this event.
	 * 
	 * <p class="note">
	 * If the runId is not specified, the <code>WorkflowExecutionCancelRequested</code> event is
	 * recorded in the history of the current open workflow execution with the specified workflowId in
	 * the domain.
	 * </p>
	 * <p class="note">
	 * Because this action allows the workflow to properly clean up and gracefully close, it should be
	 * used instead of <code>TerminateWorkflowExecution</code> when possible.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain containing the workflow execution to cancel.</li>
	 * 	<li><code>workflowId</code> - <code>string</code> - Required - The workflowId of the workflow execution to cancel.</li>
	 * 	<li><code>runId</code> - <code>string</code> - Optional - The runId of the workflow execution to cancel.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function request_cancel_workflow_execution($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RequestCancelWorkflowExecution', $opt);
	}

	/**
	 * Used by workers to tell the service that the <code>ActivityTask</code> identified by the
	 * <code>taskToken</code> was successfully canceled. Additional <code>details</code> can be
	 * optionally provided using the <code>details</code> argument.
	 *  
	 * These <code>details</code> (if provided) appear in the <code>ActivityTaskCanceled</code> event
	 * added to the workflow history.
	 * 
	 * <p class="important">
	 * Only use this operation if the <code>canceled</code> flag of a
	 * <code>RecordActivityTaskHeartbeat</code> request returns <code>true</code> and if the activity
	 * can be safely undone or abandoned.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>taskToken</code> - <code>string</code> - Required - The <code>taskToken</code> of the <code>ActivityTask</code>. <p class="important">The <code>taskToken</code> is generated by the service and should be treated as an opaque value. If the task is passed to another process, its <code>taskToken</code> must also be passed. This enables it to provide its progress and respond with results.</p></li>
	 * 	<li><code>details</code> - <code>string</code> - Optional - Optional information about the cancellation.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function respond_activity_task_canceled($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RespondActivityTaskCanceled', $opt);
	}

	/**
	 * Used by workers to tell the service that the <code>ActivityTask</code> identified by the
	 * <code>taskToken</code> completed successfully with a <code>result</code> (if provided).
	 *  
	 * The <code>result</code> appears in the <code>ActivityTaskCompleted</code> event in the workflow
	 * history.
	 * 
	 * <p class="important">
	 * If the requested task does not complete successfully, use
	 * <code>RespondActivityTaskFailed</code> instead. If the worker finds that the task is canceled
	 * through the <code>canceled</code> flag returned by <code>RecordActivityTaskHeartbeat</code>, it
	 * should cancel the task, clean up and then call <code>RespondActivityTaskCanceled</code>.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>taskToken</code> - <code>string</code> - Required - The <code>taskToken</code> of the <code>ActivityTask</code>. <p class="important">The <code>taskToken</code> is generated by the service and should be treated as an opaque value. If the task is passed to another process, its <code>taskToken</code> must also be passed. This enables it to provide its progress and respond with results.</p></li>
	 * 	<li><code>result</code> - <code>string</code> - Optional - The result of the activity task. It is a free form string that is implementation specific.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function respond_activity_task_completed($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RespondActivityTaskCompleted', $opt);
	}

	/**
	 * Used by workers to tell the service that the <code>ActivityTask</code> identified by the
	 * <code>taskToken</code> has failed with <code>reason</code> (if specified).
	 *  
	 * The <code>reason</code> and <code>details</code> appear in the <code>ActivityTaskFailed</code>
	 * event added to the workflow history.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>taskToken</code> - <code>string</code> - Required - The <code>taskToken</code> of the <code>ActivityTask</code>. <p class="important">The <code>taskToken</code> is generated by the service and should be treated as an opaque value. If the task is passed to another process, its <code>taskToken</code> must also be passed. This enables it to provide its progress and respond with results.</p></li>
	 * 	<li><code>reason</code> - <code>string</code> - Optional - Description of the error that may assist in diagnostics.</li>
	 * 	<li><code>details</code> - <code>string</code> - Optional - Optional detailed information about the failure.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function respond_activity_task_failed($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('RespondActivityTaskFailed', $opt);
	}

	/**
	 * Used by deciders to tell the service that the <code>DecisionTask</code> identified by the
	 * <code>taskToken</code> has successfully completed. The <code>decisions</code> argument
	 * specifies the list of decisions made while processing the task.
	 *  
	 * A <code>DecisionTaskCompleted</code> event is added to the workflow history. The
	 * <code>executionContext</code> specified is attached to the event in the workflow execution
	 * history.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>taskToken</code> - <code>string</code> - Required - The <code>taskToken</code> from the <code>DecisionTask</code>. <p class="important">The <code>taskToken</code> is generated by the service and should be treated as an opaque value. If the task is passed to another process, its <code>taskToken</code> must also be passed. This enables it to provide its progress and respond with results.</p></li>
	 * 	<li><code>decisions</code> - <code>array</code> - Optional - The list of decisions (possibly empty) made by the decider while processing this decision task. See the docs for the <code>Decision</code> structure for details. <ul>
	 * 		<li><code>x</code> - <code>array</code> - Optional - This represents a simple array index. <ul>
	 * 			<li><code>decisionType</code> - <code>string</code> - Required - Specifies the type of the decision. [Allowed values: <code>ScheduleActivityTask</code>, <code>RequestCancelActivityTask</code>, <code>CompleteWorkflowExecution</code>, <code>FailWorkflowExecution</code>, <code>CancelWorkflowExecution</code>, <code>ContinueAsNewWorkflowExecution</code>, <code>RecordMarker</code>, <code>StartTimer</code>, <code>CancelTimer</code>, <code>SignalExternalWorkflowExecution</code>, <code>RequestCancelExternalWorkflowExecution</code>, <code>StartChildWorkflowExecution</code>]</li>
	 * 			<li><code>scheduleActivityTaskDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>ScheduleActivityTask</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>activityType</code> - <code>array</code> - Required - The type of the activity task to schedule. This field is required. <ul>
	 * 					<li><code>name</code> - <code>string</code> - Required - The name of this activity. <p class="note">The combination of activity type name and version must be unique within a domain.</p></li>
	 * 					<li><code>version</code> - <code>string</code> - Required - The version of this activity. <p class="note">The combination of activity type name and version must be unique with in a domain.</p></li>
	 * 				</ul></li>
	 * 				<li><code>activityId</code> - <code>string</code> - Required - The <code>activityId</code> of the activity task. This field is required. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 				<li><code>control</code> - <code>string</code> - Optional - Optional data attached to the event that can be used by the decider in subsequent workflow tasks. This data is not sent to the activity.</li>
	 * 				<li><code>input</code> - <code>string</code> - Optional - The input provided to the activity task.</li>
	 * 				<li><code>scheduleToCloseTimeout</code> - <code>string</code> - Optional - The maximum duration for this activity task. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">A schedule-to-close timeout for this activity task must be specified either as a default for the activity type or through this field. If neither this field is set nor a default schedule-to-close timeout was specified at registration time then a fault will be returned.</p></li>
	 * 				<li><code>taskList</code> - <code>array</code> - Optional - If set, specifies the name of the task list in which to schedule the activity task. If not specified, the <code>defaultTaskList</code> registered with the activity type will be used. <p class="note">A task list for this activity task must be specified either as a default for the activity type or through this field. If neither this field is set nor a default task list was specified at registration time then a fault will be returned.</p> The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn". <ul>
	 * 					<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 				</ul></li>
	 * 				<li><code>scheduleToStartTimeout</code> - <code>string</code> - Optional - If set, specifies the maximum duration the activity task can wait to be assigned to a worker. This overrides the default schedule-to-start timeout specified when registering the activity type using <code>RegisterActivityType</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">A schedule-to-start timeout for this activity task must be specified either as a default for the activity type or through this field. If neither this field is set nor a default schedule-to-start timeout was specified at registration time then a fault will be returned.</p></li>
	 * 				<li><code>startToCloseTimeout</code> - <code>string</code> - Optional - If set, specifies the maximum duration a worker may take to process this activity task. This overrides the default start-to-close timeout specified when registering the activity type using <code>RegisterActivityType</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">A start-to-close timeout for this activity task must be specified either as a default for the activity type or through this field. If neither this field is set nor a default start-to-close timeout was specified at registration time then a fault will be returned.</p></li>
	 * 				<li><code>heartbeatTimeout</code> - <code>string</code> - Optional - If set, specifies the maximum time before which a worker processing a task of this type must report progress by calling <code>RecordActivityTaskHeartbeat</code>. If the timeout is exceeded, the activity task is automatically timed out. If the worker subsequently attempts to record a heartbeat or returns a result, it will be ignored. This overrides the default heartbeat timeout specified when registering the activity type using <code>RegisterActivityType</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration.</li>
	 * 			</ul></li>
	 * 			<li><code>requestCancelActivityTaskDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>RequestCancelActivityTask</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>activityId</code> - <code>string</code> - Required - The <code>activityId</code> of the activity task to be canceled.</li>
	 * 			</ul></li>
	 * 			<li><code>completeWorkflowExecutionDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>CompleteWorkflowExecution</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>result</code> - <code>string</code> - Optional - The result of the workflow execution. The form of the result is implementation defined.</li>
	 * 			</ul></li>
	 * 			<li><code>failWorkflowExecutionDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>FailWorkflowExecution</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>reason</code> - <code>string</code> - Optional - A descriptive reason for the failure that may help in diagnostics.</li>
	 * 				<li><code>details</code> - <code>string</code> - Optional - Optional details of the failure.</li>
	 * 			</ul></li>
	 * 			<li><code>cancelWorkflowExecutionDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>CancelWorkflowExecution</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>details</code> - <code>string</code> - Optional - Optional details of the cancellation.</li>
	 * 			</ul></li>
	 * 			<li><code>continueAsNewWorkflowExecutionDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>ContinueAsNewWorkflowExecution</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>input</code> - <code>string</code> - Optional - The input provided to the new workflow execution.</li>
	 * 				<li><code>executionStartToCloseTimeout</code> - <code>string</code> - Optional - If set, specifies the total duration for this workflow execution. This overrides the <code>defaultExecutionStartToCloseTimeout</code> specified when registering the workflow type. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">An execution start-to-close timeout for this workflow execution must be specified either as a default for the workflow type or through this field. If neither this field is set nor a default execution start-to-close timeout was specified at registration time then a fault will be returned.</p></li>
	 * 				<li><code>taskList</code> - <code>array</code> - Optional - Represents a task list. <ul>
	 * 					<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 				</ul></li>
	 * 				<li><code>taskStartToCloseTimeout</code> - <code>string</code> - Optional - Specifies the maximum duration of decision tasks for the new workflow execution. This parameter overrides the <code>defaultTaskStartToCloseTimout</code> specified when registering the workflow type using <code>RegisterWorkflowType</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">A task start-to-close timeout for the new workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default task start-to-close timeout was specified at registration time then a fault will be returned.</p></li>
	 * 				<li><code>childPolicy</code> - <code>string</code> - Optional - If set, specifies the policy to use for the child workflow executions of the new execution if it is terminated by calling the <code>TerminateWorkflowExecution</code> action explicitly or due to an expired timeout. This policy overrides the default child policy specified when registering the workflow type using <code>RegisterWorkflowType</code>. The supported child policies are:<ul><li> <strong>TERMINATE:</strong> the child executions will be terminated.</li><li> <strong>REQUEST_CANCEL:</strong> a request to cancel will be attempted for each child execution by recording a <code>WorkflowExecutionCancelRequested</code> event in its history. It is up to the decider to take appropriate actions when it receives an execution history with this event.</li><li> <strong>ABANDON:</strong> no action will be taken. The child executions will continue to run.</li></ul> <p class="note">A child policy for the new workflow execution must be specified either as a default registered for its workflow type or through this field. If neither this field is set nor a default child policy was specified at registration time then a fault will be returned.</p> [Allowed values: <code>TERMINATE</code>, <code>REQUEST_CANCEL</code>, <code>ABANDON</code>]</li>
	 * 				<li><code>tagList</code> - <code>string|array</code> - Optional - The list of tags to associate with the new workflow execution. A maximum of 5 tags can be specified. You can list workflow executions with a specific tag by calling <code>ListOpenWorkflowExecutions</code> or <code>ListClosedWorkflowExecutions</code> and specifying a <code>TagFilter</code>. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 				<li><code>workflowTypeVersion</code> - <code>string</code> - Optional - </li>
	 * 			</ul></li>
	 * 			<li><code>recordMarkerDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>RecordMarker</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>markerName</code> - <code>string</code> - Required - The name of the marker. This filed is required.</li>
	 * 				<li><code>details</code> - <code>string</code> - Optional - Optional details of the marker.</li>
	 * 			</ul></li>
	 * 			<li><code>startTimerDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>StartTimer</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>timerId</code> - <code>string</code> - Required - The unique Id of the timer. This field is required. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 				<li><code>control</code> - <code>string</code> - Optional - Optional data attached to the event that can be used by the decider in subsequent workflow tasks.</li>
	 * 				<li><code>startToFireTimeout</code> - <code>string</code> - Required - The duration to wait before firing the timer. This field is required. The duration is specified in seconds. The valid values are integers greater than or equal to 0.</li>
	 * 			</ul></li>
	 * 			<li><code>cancelTimerDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>CancelTimer</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>timerId</code> - <code>string</code> - Required - The unique Id of the timer to cancel. This field is required.</li>
	 * 			</ul></li>
	 * 			<li><code>signalExternalWorkflowExecutionDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>SignalExternalWorkflowExecution</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>workflowId</code> - <code>string</code> - Required - The <code>workflowId</code> of the workflow execution to be signaled. This field is required.</li>
	 * 				<li><code>runId</code> - <code>string</code> - Optional - The <code>runId</code> of the workflow execution to be signaled.</li>
	 * 				<li><code>signalName</code> - <code>string</code> - Required - The name of the signal.The target workflow execution will use the signal name and input to process the signal. This field is required.</li>
	 * 				<li><code>input</code> - <code>string</code> - Optional - Optional input to be provided with the signal.The target workflow execution will use the signal name and input to process the signal.</li>
	 * 				<li><code>control</code> - <code>string</code> - Optional - Optional data attached to the event that can be used by the decider in subsequent decision tasks.</li>
	 * 			</ul></li>
	 * 			<li><code>requestCancelExternalWorkflowExecutionDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>RequestCancelExternalWorkflowExecution</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>workflowId</code> - <code>string</code> - Required - The <code>workflowId</code> of the external workflow execution to cancel. This field is required.</li>
	 * 				<li><code>runId</code> - <code>string</code> - Optional - The <code>runId</code> of the external workflow execution to cancel.</li>
	 * 				<li><code>control</code> - <code>string</code> - Optional - Optional data attached to the event that can be used by the decider in subsequent workflow tasks.</li>
	 * 			</ul></li>
	 * 			<li><code>startChildWorkflowExecutionDecisionAttributes</code> - <code>array</code> - Optional - Provides details of the <code>StartChildWorkflowExecution</code> decision. It is not set for other decision types. <ul>
	 * 				<li><code>workflowType</code> - <code>array</code> - Required - The type of the workflow execution to be started. This field is required. <ul>
	 * 					<li><code>name</code> - <code>string</code> - Required - The name of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 					<li><code>version</code> - <code>string</code> - Required - The version of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 				</ul></li>
	 * 				<li><code>workflowId</code> - <code>string</code> - Required - The <code>workflowId</code> of the workflow execution. This field is required. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 				<li><code>control</code> - <code>string</code> - Optional - Optional data attached to the event that can be used by the decider in subsequent workflow tasks. This data is not sent to the child workflow execution.</li>
	 * 				<li><code>input</code> - <code>string</code> - Optional - The input to be provided to the workflow execution.</li>
	 * 				<li><code>executionStartToCloseTimeout</code> - <code>string</code> - Optional - The total duration for this workflow execution. This overrides the defaultExecutionStartToCloseTimeout specified when registering the workflow type. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">An execution start-to-close timeout for this workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default execution start-to-close timeout was specified at registration time then a fault will be returned.</p></li>
	 * 				<li><code>taskList</code> - <code>array</code> - Optional - The name of the task list to be used for decision tasks of the child workflow execution. <p class="note">A task list for this workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default task list was specified at registration time then a fault will be returned.</p> The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn". <ul>
	 * 					<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 				</ul></li>
	 * 				<li><code>taskStartToCloseTimeout</code> - <code>string</code> - Optional - Specifies the maximum duration of decision tasks for this workflow execution. This parameter overrides the <code>defaultTaskStartToCloseTimout</code> specified when registering the workflow type using <code>RegisterWorkflowType</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">A task start-to-close timeout for this workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default task start-to-close timeout was specified at registration time then a fault will be returned.</p></li>
	 * 				<li><code>childPolicy</code> - <code>string</code> - Optional - If set, specifies the policy to use for the child workflow executions if the workflow execution being started is terminated by calling the <code>TerminateWorkflowExecution</code> action explicitly or due to an expired timeout. This policy overrides the default child policy specified when registering the workflow type using <code>RegisterWorkflowType</code>. The supported child policies are:<ul><li> <strong>TERMINATE:</strong> the child executions will be terminated.</li><li> <strong>REQUEST_CANCEL:</strong> a request to cancel will be attempted for each child execution by recording a <code>WorkflowExecutionCancelRequested</code> event in its history. It is up to the decider to take appropriate actions when it receives an execution history with this event.</li><li> <strong>ABANDON:</strong> no action will be taken. The child executions will continue to run.</li></ul> <p class="note">A child policy for the workflow execution being started must be specified either as a default registered for its workflow type or through this field. If neither this field is set nor a default child policy was specified at registration time then a fault will be returned.</p> [Allowed values: <code>TERMINATE</code>, <code>REQUEST_CANCEL</code>, <code>ABANDON</code>]</li>
	 * 				<li><code>tagList</code> - <code>string|array</code> - Optional - The list of tags to associate with the child workflow execution. A maximum of 5 tags can be specified. You can list workflow executions with a specific tag by calling <code>ListOpenWorkflowExecutions</code> or <code>ListClosedWorkflowExecutions</code> and specifying a <code>TagFilter</code>. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 			</ul></li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>executionContext</code> - <code>string</code> - Optional - User defined context to add to workflow execution.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function respond_decision_task_completed($opt = null)
	{
		if (!$opt) $opt = array();
		
		// List (non-map)
		if (isset($opt['decisions']))
		{
			$opt['decisions'] = (is_array($opt['decisions']) ? $opt['decisions'] : array($opt['decisions']));
		}

		return $this->authenticate('RespondDecisionTaskCompleted', $opt);
	}

	/**
	 * Records a <code>WorkflowExecutionSignaled</code> event in the workflow execution history and
	 * creates a decision task for the workflow execution identified by the given domain, workflowId
	 * and runId. The event is recorded with the specified user defined signalName and input (if
	 * provided).
	 * 
	 * <p class="note">
	 * If a runId is not specified, then the <code>WorkflowExecutionSignaled</code> event is recorded
	 * in the history of the current open workflow with the matching workflowId in the domain.
	 * </p>
	 * <p class="note">
	 * If the specified workflow execution is not open, this method fails with
	 * <code>UnknownResource</code>.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain containing the workflow execution to signal.</li>
	 * 	<li><code>workflowId</code> - <code>string</code> - Required - The workflowId of the workflow execution to signal.</li>
	 * 	<li><code>runId</code> - <code>string</code> - Optional - The runId of the workflow execution to signal.</li>
	 * 	<li><code>signalName</code> - <code>string</code> - Required - The name of the signal. This name must be meaningful to the target workflow.</li>
	 * 	<li><code>input</code> - <code>string</code> - Optional - Data to attach to the <code>WorkflowExecutionSignaled</code> event in the target workflow execution's history.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function signal_workflow_execution($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('SignalWorkflowExecution', $opt);
	}

	/**
	 * Starts an execution of the workflow type in the specified domain using the provided
	 * <code>workflowId</code> and input data.
	 *  
	 * This action returns the newly started workflow execution.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The name of the domain in which the workflow execution is created.</li>
	 * 	<li><code>workflowId</code> - <code>string</code> - Required - The user defined identifier associated with the workflow execution. You can use this to associate a custom identifier with the workflow execution. You may specify the same identifier if a workflow execution is logically a <em>restart</em> of a previous execution. You cannot have two open workflow executions with the same <code>workflowId</code> at the same time. The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn".</li>
	 * 	<li><code>workflowType</code> - <code>array</code> - Required - The type of the workflow to start. <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 		<li><code>version</code> - <code>string</code> - Required - The version of the workflow type. This field is required. <p class="note">The combination of workflow type name and version must be unique with in a domain.</p></li>
	 * 	</ul></li>
	 * 	<li><code>taskList</code> - <code>array</code> - Optional - The task list to use for the decision tasks generated for this workflow execution. This overrides the <code>defaultTaskList</code> specified when registering the workflow type. <p class="note">A task list for this workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default task list was specified at registration time then a fault will be returned.</p> The specified string must not start or end with whitespace. It must not contain a <code>:</code> (colon), <code>/</code> (slash), <code>|</code> (vertical bar), or any control characters (\u0000-\u001f | \u007f - \u009f). Also, it must not contain the literal string "arn". <ul>
	 * 		<li><code>name</code> - <code>string</code> - Required - The name of the task list.</li>
	 * 	</ul></li>
	 * 	<li><code>input</code> - <code>string</code> - Optional - The input for the workflow execution. This is a free form string which should be meaningful to the workflow you are starting. This <code>input</code> is made available to the new workflow execution in the <code>WorkflowExecutionStarted</code> history event.</li>
	 * 	<li><code>executionStartToCloseTimeout</code> - <code>string</code> - Optional - The total duration for this workflow execution. This overrides the defaultExecutionStartToCloseTimeout specified when registering the workflow type. The duration is specified in seconds. The valid values are integers greater than or equal to 0. Exceeding this limit will cause the workflow execution to time out. Unlike some of the other timeout parameters in Amazon SWF, you cannot specify a value of "NONE" for this timeout; there is a one-year max limit on the time that a workflow execution can run. <p class="note">An execution start-to-close timeout must be specified either through this parameter or as a default when the workflow type is registered. If neither this parameter nor a default execution start-to-close timeout is specified, a fault is returned.</p></li>
	 * 	<li><code>tagList</code> - <code>string|array</code> - Optional - The list of tags to associate with the workflow execution. You can specify a maximum of 5 tags. You can list workflow executions with a specific tag by calling <code>ListOpenWorkflowExecutions</code> or <code>ListClosedWorkflowExecutions</code> and specifying a <code>TagFilter</code>. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>taskStartToCloseTimeout</code> - <code>string</code> - Optional - Specifies the maximum duration of decision tasks for this workflow execution. This parameter overrides the <code>defaultTaskStartToCloseTimout</code> specified when registering the workflow type using <code>RegisterWorkflowType</code>. The valid values are integers greater than or equal to <code>0</code>. An integer value can be used to specify the duration in seconds while <code>NONE</code> can be used to specify unlimited duration. <p class="note">A task start-to-close timeout for this workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default task start-to-close timeout was specified at registration time then a fault will be returned.</p></li>
	 * 	<li><code>childPolicy</code> - <code>string</code> - Optional - If set, specifies the policy to use for the child workflow executions of this workflow execution if it is terminated, by calling the <code>TerminateWorkflowExecution</code> action explicitly or due to an expired timeout. This policy overrides the default child policy specified when registering the workflow type using <code>RegisterWorkflowType</code>. The supported child policies are:<ul><li> <strong>TERMINATE:</strong> the child executions will be terminated.</li><li> <strong>REQUEST_CANCEL:</strong> a request to cancel will be attempted for each child execution by recording a <code>WorkflowExecutionCancelRequested</code> event in its history. It is up to the decider to take appropriate actions when it receives an execution history with this event.</li><li> <strong>ABANDON:</strong> no action will be taken. The child executions will continue to run.</li></ul> <p class="note">A child policy for this workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default child policy was specified at registration time then a fault will be returned.</p> [Allowed values: <code>TERMINATE</code>, <code>REQUEST_CANCEL</code>, <code>ABANDON</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function start_workflow_execution($opt = null)
	{
		if (!$opt) $opt = array();
		
		// List (non-map)
		if (isset($opt['tagList']))
		{
			$opt['tagList'] = (is_array($opt['tagList']) ? $opt['tagList'] : array($opt['tagList']));
		}

		return $this->authenticate('StartWorkflowExecution', $opt);
	}

	/**
	 * Records a <code>WorkflowExecutionTerminated</code> event and forces closure of the workflow
	 * execution identified by the given domain, runId, and workflowId. The child policy, registered
	 * with the workflow type or specified when starting this execution, is applied to any open child
	 * workflow executions of this workflow execution.
	 * 
	 * <p class="important">
	 * If the identified workflow execution was in progress, it is terminated immediately.
	 * </p>
	 * <p class="note">
	 * If a runId is not specified, then the <code>WorkflowExecutionTerminated</code> event is
	 * recorded in the history of the current open workflow with the matching workflowId in the
	 * domain.
	 * </p>
	 * <p class="note">
	 * You should consider using <code>RequestCancelWorkflowExecution</code> action instead because it
	 * allows the workflow to gracefully close while <code>TerminateWorkflowExecution</code> does not.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>domain</code> - <code>string</code> - Required - The domain of the workflow execution to terminate.</li>
	 * 	<li><code>workflowId</code> - <code>string</code> - Required - The workflowId of the workflow execution to terminate.</li>
	 * 	<li><code>runId</code> - <code>string</code> - Optional - The runId of the workflow execution to terminate.</li>
	 * 	<li><code>reason</code> - <code>string</code> - Optional - An optional descriptive reason for terminating the workflow execution.</li>
	 * 	<li><code>details</code> - <code>string</code> - Optional - Optional details for terminating the workflow execution.</li>
	 * 	<li><code>childPolicy</code> - <code>string</code> - Optional - If set, specifies the policy to use for the child workflow executions of the workflow execution being terminated. This policy overrides the child policy specified for the workflow execution at registration time or when starting the execution. The supported child policies are:<ul><li> <strong>TERMINATE:</strong> the child executions will be terminated.</li><li> <strong>REQUEST_CANCEL:</strong> a request to cancel will be attempted for each child execution by recording a <code>WorkflowExecutionCancelRequested</code> event in its history. It is up to the decider to take appropriate actions when it receives an execution history with this event.</li><li> <strong>ABANDON:</strong> no action will be taken. The child executions will continue to run.</li></ul> <p class="note">A child policy for this workflow execution must be specified either as a default for the workflow type or through this parameter. If neither this parameter is set nor a default child policy was specified at registration time, a fault will be returned.</p> [Allowed values: <code>TERMINATE</code>, <code>REQUEST_CANCEL</code>, <code>ABANDON</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function terminate_workflow_execution($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('TerminateWorkflowExecution', $opt);
	}
}


/*%******************************************************************************************%*/
// EXCEPTIONS

class SWF_Exception extends Exception {}


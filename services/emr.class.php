<?php
/*
 * Copyright 2010 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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
 * File: AmazonEMR
 * 	This is the Amazon Elastic MapReduce API Reference Guide. This guide is for programmers who need
 * 	detailed information about the Amazon Elastic MapReduce APIs.
 *
 * Version:
 * 	Fri Dec 03 16:25:08 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon Elastic MapReduce](http://aws.amazon.com/elasticmapreduce/)
 * 	[Amazon Elastic MapReduce documentation](http://aws.amazon.com/documentation/elasticmapreduce/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: EMR_Exception
 * 	Default EMR Exception.
 */
class EMR_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonEMR
 * 	Container for all service-related methods.
 */
class AmazonEMR extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'us-east-1.elasticmapreduce.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = self::DEFAULT_URL;

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'us-west-1.elasticmapreduce.amazonaws.com';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'eu-west-1.elasticmapreduce.amazonaws.com';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'ap-southeast-1.elasticmapreduce.amazonaws.com';


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * Method: set_region()
	 * 	This allows you to explicitly sets the region for the service to use.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$region - _string_ (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_W1>, <REGION_EU_W1>, or <REGION_APAC_SE1>.
	 *
	 * Returns:
	 * 	`$this`
	 */
	public function set_region($region)
	{
		$this->set_hostname($region);
		return $this;
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonEMR>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$key - _string_ (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * 	$secret_key - _string_ (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 *
	 * Returns:
	 * 	_boolean_ false if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->api_version = '2009-03-31';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new EMR_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new EMR_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: add_instance_groups()
	 * 	AddInstanceGroups adds an instance group to a running cluster.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$job_flow_id - _string_ (Required) Job flow in which to add the instance groups.
	 *	$instance_groups - _ComplexList_ (Required) Instance Groups to add. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs which must be set by passing an associative array. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $instance_groups parameter:
	 *	Name - _string_ (Optional) Friendly name given to the instance group.
	 *	Market - _string_ (Required) Market type of the Amazon EC2 instances used to create a cluster node. [Allowed values: `ON_DEMAND`]
	 *	InstanceRole - _string_ (Required) The role of the instance group in the cluster. [Allowed values: `MASTER`, `CORE`, `TASK`]
	 *	InstanceType - _string_ (Required) The Amazon EC2 instance type for all instances in the instance group.
	 *	InstanceCount - _integer_ (Required) Target number of instances for the instance group.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_instance_groups($job_flow_id, $instance_groups, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['JobFlowId'] = $job_flow_id;

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'InstanceGroups' => (is_array($instance_groups) ? $instance_groups : array($instance_groups))
		), 'member'));

		return $this->authenticate('AddInstanceGroups', $opt, $this->hostname);
	}

	/**
	 * Method: add_job_flow_steps()
	 * 	AddJobFlowSteps adds new steps to a running job flow. A maximum of 256 steps are allowed in each job
	 * 	flow. A step specifies the location of a JAR file stored either on the master node of the job flow
	 * 	or in Amazon S3. Each step is performed by the main function of the main class of the JAR file. The
	 * 	main class can be specified either in the manifest of the JAR or by using the MainFunction parameter
	 * 	of the step. Elastic MapReduce executes each step in the order listed. For a step to be considered
	 * 	complete, the main function must exit with a zero exit code and all Hadoop jobs started while the
	 * 	step was running must have completed and run successfully. You can only add steps to a job flow that
	 * 	is in one of the following states: STARTING, BOOTSTAPPING, RUNNING, or WAITING.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$job_flow_id - _string_ (Required) A string that uniquely identifies the job flow. This identifier is returned by RunJobFlow and can also be obtained from DescribeJobFlows .
	 *	$steps - _ComplexList_ (Required) A list of StepConfig to be executed by the job flow. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs which must be set by passing an associative array. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $steps parameter:
	 *	Name - _string_ (Required) The name of the job flow step.
	 *	ActionOnFailure - _string_ (Optional) Specifies the action to take if the job flow step fails. [Allowed values: `TERMINATE_JOB_FLOW`, `CANCEL_AND_WAIT`, `CONTINUE`]
	 *	HadoopJarStep.Properties.x.Key - _string_ (Optional) The unique identifier of a key value pair.
	 *	HadoopJarStep.Properties.x.Value - _string_ (Optional) The value part of the identified key.
	 *	HadoopJarStep.Jar - _string_ (Required) A path to a JAR file run during the step.
	 *	HadoopJarStep.MainClass - _string_ (Optional) The name of the main class in the specified Java file. If not specified, the JAR file should specify a Main-Class in its manifest file.
	 *	HadoopJarStep.Args.x - _string_ (Optional) A list of command line arguments passed to the JAR file's main function when executed.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_job_flow_steps($job_flow_id, $steps, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['JobFlowId'] = $job_flow_id;

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'Steps' => (is_array($steps) ? $steps : array($steps))
		), 'member'));

		return $this->authenticate('AddJobFlowSteps', $opt, $this->hostname);
	}

	/**
	 * Method: terminate_job_flows()
	 * 	TerminateJobFlows shuts a list of job flows down. When a job flow is shut down, any step not yet
	 * 	completed is canceled and the EC2 instances on which the job flow is running are stopped. Any log
	 * 	files not already saved are uploaded to Amazon S3 if a LogUri was specified when the job flow was
	 * 	created.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$job_flow_ids - _string_|_array_ (Required) A list of job flows to be shutdown. Pass a string for a single value, or an indexed array for multiple values.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function terminate_job_flows($job_flow_ids, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'JobFlowIds' => (is_array($job_flow_ids) ? $job_flow_ids : array($job_flow_ids))
		), 'member'));

		return $this->authenticate('TerminateJobFlows', $opt, $this->hostname);
	}

	/**
	 * Method: describe_job_flows()
	 * 	DescribeJobFlows returns a list of job flows that match all of the supplied parameters. The
	 * 	parameters can include a list of job flow IDs, job flow states, and restrictions on job flow
	 * 	creation date and time. Regardless of supplied parameters, only job flows created within the last
	 * 	two months are returned. If no parameters are supplied, then job flows matching either of the
	 * 	following criteria are returned:
	 *
	 * 	- Job flows created and completed in the last two weeks
	 *
	 * 	- Job flows created within the last two months that are in one of the following states: `RUNNING` ,
	 * 	`WAITING` , `SHUTTING_DOWN` , `STARTING`
	 *
	 * 	Amazon Elastic MapReduce can return a maximum of 512 job flow descriptions.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	CreatedAfter - _string_ (Optional) Return only job flows created after this date and time. Accepts any value that `strtotime()` understands.
	 *	CreatedBefore - _string_ (Optional) Return only job flows created before this date and time. Accepts any value that `strtotime()` understands.
	 *	JobFlowIds - _string_|_array_ (Optional) Return only job flows whose job flow ID is contained in this list. Pass a string for a single value, or an indexed array for multiple values.
	 *	JobFlowStates - _string_|_array_ (Optional) Return only job flows whose state is contained in this list. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_job_flows($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['CreatedAfter']))
		{
			$opt['CreatedAfter'] = $this->util->convert_date_to_iso8601($opt['CreatedAfter']);
		}

		// Optional parameter
		if (isset($opt['CreatedBefore']))
		{
			$opt['CreatedBefore'] = $this->util->convert_date_to_iso8601($opt['CreatedBefore']);
		}

		// Optional parameter
		if (isset($opt['JobFlowIds']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'JobFlowIds' => (is_array($opt['JobFlowIds']) ? $opt['JobFlowIds'] : array($opt['JobFlowIds']))
			), 'member'));
			unset($opt['JobFlowIds']);
		}

		// Optional parameter
		if (isset($opt['JobFlowStates']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'JobFlowStates' => (is_array($opt['JobFlowStates']) ? $opt['JobFlowStates'] : array($opt['JobFlowStates']))
			), 'member'));
			unset($opt['JobFlowStates']);
		}

		return $this->authenticate('DescribeJobFlows', $opt, $this->hostname);
	}

	/**
	 * Method: run_job_flow()
	 * 	RunJobFlow creates and starts running a new job flow. The job flow will run the steps specified.
	 * 	Once the job flow completes, the cluster is stopped and the HDFS partition is lost. To prevent loss
	 * 	of data, configure the last step of the job flow to store results in Amazon S3. If the
	 * 	JobFlowInstancesDetail : KeepJobFlowAliveWhenNoSteps parameter is set to `TRUE`, the job flow will
	 * 	transition to the WAITING state rather than shutting down once the steps have completed.
	 *
	 * 	A maximum of 256 steps are allowed in each job flow. For long running job flows, we recommended
	 * 	that you periodically store your results.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$name - _string_ (Required) The name of the job flow.
	 *	$instances - _ComplexType_ (Required) A specification of the number and type of Amazon EC2 instances on which to run the job flow. A required ComplexType is a set of key-value pairs which must be set by passing an associative array with certain entries as keys. See below for a list.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $instances parameter:
	 *	MasterInstanceType - _string_ (Optional) The EC2 instance type of the master node.
	 *	SlaveInstanceType - _string_ (Optional) The EC2 instance type of the slave nodes.
	 *	InstanceCount - _integer_ (Optional) The number of Amazon EC2 instances used to execute the job flow.
	 *	InstanceGroups.x.Name - _string_ (Optional) Friendly name given to the instance group.
	 *	InstanceGroups.x.Market - _string_ (Required) Market type of the Amazon EC2 instances used to create a cluster node. [Allowed values: `ON_DEMAND`]
	 *	InstanceGroups.x.InstanceRole - _string_ (Required) The role of the instance group in the cluster. [Allowed values: `MASTER`, `CORE`, `TASK`]
	 *	InstanceGroups.x.InstanceType - _string_ (Required) The Amazon EC2 instance type for all instances in the instance group.
	 *	InstanceGroups.x.InstanceCount - _integer_ (Required) Target number of instances for the instance group.
	 *	Ec2KeyName - _string_ (Optional) Specifies the name of the Amazon EC2 key pair that can be used to ssh to the master node as the user called "hadoop."
	 *	Placement.AvailabilityZone - _string_ (Required) The Amazon EC2 Availability Zone for the job flow.
	 *	KeepJobFlowAliveWhenNoSteps - _boolean_ (Optional) Specifies whether the job flow should terminate after completing all steps.
	 *	HadoopVersion - _string_ (Optional) Specifies the Hadoop version for the job flow. Valid inputs are "0.18" or "0.20".
	 *
	 * Keys for the $opt parameter:
	 *	LogUri - _string_ (Optional) Specifies the location in Amazon S3 to write the log files of the job flow. If a value is not provided, logs are not created.
	 *	AdditionalInfo - _string_ (Optional) A JSON string for selecting additional features.
	 *	Steps - _ComplexList_ (Optional) A list of steps to be executed by the job flow. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `Steps` subtype (documented next), or by passing an associative array with the following `Steps`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	Steps.x.Name - _string_ (Required) The name of the job flow step.
	 *	Steps.x.ActionOnFailure - _string_ (Optional) Specifies the action to take if the job flow step fails. [Allowed values: `TERMINATE_JOB_FLOW`, `CANCEL_AND_WAIT`, `CONTINUE`]
	 *	Steps.x.HadoopJarStep.Properties.x.Key - _string_ (Optional) The unique identifier of a key value pair.
	 *	Steps.x.HadoopJarStep.Properties.x.Value - _string_ (Optional) The value part of the identified key.
	 *	Steps.x.HadoopJarStep.Jar - _string_ (Required) A path to a JAR file run during the step.
	 *	Steps.x.HadoopJarStep.MainClass - _string_ (Optional) The name of the main class in the specified Java file. If not specified, the JAR file should specify a Main-Class in its manifest file.
	 *	Steps.x.HadoopJarStep.Args.x - _string_ (Optional) A list of command line arguments passed to the JAR file's main function when executed.
	 *	BootstrapActions - _ComplexList_ (Optional) A list of bootstrap actions that will be run before Hadoop is started on the cluster nodes. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `BootstrapActions` subtype (documented next), or by passing an associative array with the following `BootstrapActions`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	BootstrapActions.x.Name - _string_ (Required) The name of the bootstrap action.
	 *	BootstrapActions.x.ScriptBootstrapAction.Path - _string_ (Optional) Location of the script to run during a bootstrap action. Can be either a location in Amazon S3 or on a local file system.
	 *	BootstrapActions.x.ScriptBootstrapAction.Args.x - _string_ (Optional) A list of command line arguments to pass to the bootstrap action script.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function run_job_flow($name, $instances, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Name'] = $name;

		// Collapse these list values for the required parameter
		if (isset($instances['InstanceGroups']))
		{
			$instances['InstanceGroups'] = CFComplexType::map(array(
				'member' => (is_array($instances['InstanceGroups']) ? $instances['InstanceGroups'] : array($instances['InstanceGroups']))
			));
		}

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'Instances' => (is_array($instances) ? $instances : array($instances))
		), 'member'));

		// Optional parameter
		if (isset($opt['Steps']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Steps' => $opt['Steps']
			), 'member'));
			unset($opt['Steps']);
		}

		// Optional parameter
		if (isset($opt['BootstrapActions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'BootstrapActions' => $opt['BootstrapActions']
			), 'member'));
			unset($opt['BootstrapActions']);
		}

		return $this->authenticate('RunJobFlow', $opt, $this->hostname);
	}

	/**
	 * Method: modify_instance_groups()
	 * 	ModifyInstanceGroups modifies the number of nodes and configuration settings of an instance group.
	 * 	The input parameters include the new target instance count for the group and the instance group ID.
	 * 	The call will either succeed or fail atomically.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	InstanceGroups - _ComplexList_ (Optional) Instance groups to change. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `InstanceGroups` subtype (documented next), or by passing an associative array with the following `InstanceGroups`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	InstanceGroups.x.InstanceGroupId - _string_ (Required) Unique ID of the instance group to expand or shrink.
	 *	InstanceGroups.x.InstanceCount - _integer_ (Required) Target size for the instance group.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function modify_instance_groups($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['InstanceGroups']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'InstanceGroups' => $opt['InstanceGroups']
			), 'member'));
			unset($opt['InstanceGroups']);
		}

		return $this->authenticate('ModifyInstanceGroups', $opt, $this->hostname);
	}
}


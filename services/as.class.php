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
 * File: AmazonAS
 * 	 *
 * 	Auto Scaling is a web service designed to automatically launch or terminate EC2 instances based on
 * 	user-defined policies, schedules, and health checks. Auto Scaling responds automatically to changing
 * 	conditions. All you need to do is specify how it should respond to those changes.
 *
 * 	Auto Scaling groups can work across multiple Availability Zones - distinct physical locations for
 * 	the hosted Amazon EC2 instances - so that if an Availability Zone becomes unavailable, Auto Scaling
 * 	will automatically redistribute applications to a different Availability Zone.
 *
 * Version:
 * 	Fri Dec 03 16:22:08 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon Auto-Scaling](http://aws.amazon.com/autoscaling/)
 * 	[Amazon Auto-Scaling documentation](http://aws.amazon.com/documentation/autoscaling/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: AS_Exception
 * 	Default AS Exception.
 */
class AS_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonAS
 * 	Container for all service-related methods.
 */
class AmazonAS extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'autoscaling.us-east-1.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = self::DEFAULT_URL;

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'autoscaling.us-west-1.amazonaws.com';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'autoscaling.eu-west-1.amazonaws.com';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'autoscaling.ap-southeast-1.amazonaws.com';


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
	 * 	Constructs a new instance of <AmazonAS>.
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
		$this->api_version = '2010-08-01';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new AS_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new AS_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: put_scheduled_update_group_action()
	 * 	Creates a scheduled scaling action for a Auto Scaling group. If you leave a parameter unspecified,
	 * 	the corresponding value remains unchanged in the affected Auto Scaling group.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name or ARN of the Auto Scaling Group.
	 *	$scheduled_action_name - _string_ (Required) The name of this scaling action.
	 *	$time - _string_ (Required) The time for this action to start. Accepts any value that `strtotime()` understands.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	MinSize - _integer_ (Optional) The minimum size for the new Auto Scaling group.
	 *	MaxSize - _integer_ (Optional) The maximum size for the Auto Scaling group.
	 *	DesiredCapacity - _integer_ (Optional) The number of EC2 instances that should be running in the group.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function put_scheduled_update_group_action($auto_scaling_group_name, $scheduled_action_name, $time, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;
		$opt['ScheduledActionName'] = $scheduled_action_name;
		$opt['Time'] = $this->util->convert_date_to_iso8601($time);

		return $this->authenticate('PutScheduledUpdateGroupAction', $opt, $this->hostname);
	}

	/**
	 * Method: set_desired_capacity()
	 * 	Adjusts the desired size of the AutoScalingGroup by initiating scaling activities. When reducing the
	 * 	size of the group, it is not possible to define which EC2 instances will be terminated. This applies
	 * 	to any auto-scaling decisions that might result in the termination of instances.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name of the AutoScalingGroup.
	 *	$desired_capacity - _integer_ (Required) The new capacity setting for the AutoScalingGroup.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	HonorCooldown - _boolean_ (Optional) Set to True if you want Auto Scaling to reject this request if the Auto Scaling group is in cooldown.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function set_desired_capacity($auto_scaling_group_name, $desired_capacity, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;
		$opt['DesiredCapacity'] = $desired_capacity;

		return $this->authenticate('SetDesiredCapacity', $opt, $this->hostname);
	}

	/**
	 * Method: delete_policy()
	 * 	Deletes a policy created by PutScalingPolicy
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$policy_name - _string_ (Required) The name or PolicyARN of the policy you want to delete
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AutoScalingGroupName - _string_ (Optional) The name of the Auto Scaling group.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_policy($policy_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['PolicyName'] = $policy_name;

		return $this->authenticate('DeletePolicy', $opt, $this->hostname);
	}

	/**
	 * Method: delete_scheduled_action()
	 * 	Deletes a scheduled action previously created using the PutScheduledUpdateGroupAction.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$scheduled_action_name - _string_ (Required) The name of the action you want to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AutoScalingGroupName - _string_ (Optional) The name of the Auto Scaling group
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_scheduled_action($scheduled_action_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ScheduledActionName'] = $scheduled_action_name;

		return $this->authenticate('DeleteScheduledAction', $opt, $this->hostname);
	}

	/**
	 * Method: describe_launch_configurations()
	 * 	Returns a full description of the launch configurations given the specified names.
	 *
	 * 	If no names are specified, then the full details of all launch configurations are returned.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	LaunchConfigurationNames - _string_|_array_ (Optional) A list of launch configuration names. Pass a string for a single value, or an indexed array for multiple values.
	 *	NextToken - _string_ (Optional) A string that marks the start of the next batch of returned results.
	 *	MaxRecords - _integer_ (Optional) The maximum number of launch configurations.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_launch_configurations($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['LaunchConfigurationNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'LaunchConfigurationNames' => (is_array($opt['LaunchConfigurationNames']) ? $opt['LaunchConfigurationNames'] : array($opt['LaunchConfigurationNames']))
			), 'member'));
			unset($opt['LaunchConfigurationNames']);
		}

		return $this->authenticate('DescribeLaunchConfigurations', $opt, $this->hostname);
	}

	/**
	 * Method: describe_scaling_process_types()
	 * 	Returns scaling process types for use in the ResumeProcesses and SuspendProcesses actions.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_scaling_process_types($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeScalingProcessTypes', $opt, $this->hostname);
	}

	/**
	 * Method: describe_auto_scaling_groups()
	 * 	Returns a full description of each Auto Scaling group in the given list. This includes all Amazon
	 * 	EC2 instances that are members of the group. If a list of names is not provided, the service returns
	 * 	the full details of all Auto Scaling groups.
	 *
	 * 	This action supports pagination by returning a token if there are more pages to retrieve. To get
	 * 	the next page, call this action again with the returned token as the NextToken parameter.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AutoScalingGroupNames - _string_|_array_ (Optional)  Pass a string for a single value, or an indexed array for multiple values.
	 *	NextToken - _string_ (Optional) A string that marks the start of the next batch of returned results.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to return.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_auto_scaling_groups($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['AutoScalingGroupNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'AutoScalingGroupNames' => (is_array($opt['AutoScalingGroupNames']) ? $opt['AutoScalingGroupNames'] : array($opt['AutoScalingGroupNames']))
			), 'member'));
			unset($opt['AutoScalingGroupNames']);
		}

		return $this->authenticate('DescribeAutoScalingGroups', $opt, $this->hostname);
	}

	/**
	 * Method: enable_metrics_collection()
	 * 	Enables monitoring for the list of metrics in Metrics at the granularity specified in Granularity.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name or ARN of the Auto Scaling Group.
	 *	$granularity - _string_ (Required) The granularity to associate with the metrics to collect.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Metrics - _string_|_array_ (Optional) The list of metrics to collect. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function enable_metrics_collection($auto_scaling_group_name, $granularity, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;

		// Optional parameter
		if (isset($opt['Metrics']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Metrics' => (is_array($opt['Metrics']) ? $opt['Metrics'] : array($opt['Metrics']))
			), 'member'));
			unset($opt['Metrics']);
		}
		$opt['Granularity'] = $granularity;

		return $this->authenticate('EnableMetricsCollection', $opt, $this->hostname);
	}

	/**
	 * Method: terminate_instance_in_auto_scaling_group()
	 * 	Terminates the specified instance. Optionally, the desired group size can be adjusted.
	 *
	 * 	This call simply registers a termination request. The termination of the instance cannot happen
	 * 	immediately.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$instance_id - _string_ (Required) The ID of the EC2 instance to be terminated.
	 *	$should_decrement_desired_capacity - _boolean_ (Required) Specifies whether (_true_) or not (_false_) terminating this instance should also decrement the size of the AutoScalingGroup.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function terminate_instance_in_auto_scaling_group($instance_id, $should_decrement_desired_capacity, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InstanceId'] = $instance_id;
		$opt['ShouldDecrementDesiredCapacity'] = $should_decrement_desired_capacity;

		return $this->authenticate('TerminateInstanceInAutoScalingGroup', $opt, $this->hostname);
	}

	/**
	 * Method: describe_scaling_activities()
	 * 	Returns the scaling activities for the specified Auto Scaling group.
	 *
	 * 	If the specified ActivityIds list is empty, all the activities from the past six weeks are
	 * 	returned. Activities are sorted by completion time. Activities still in progress appear first on the
	 * 	list.
	 *
	 * 	This action supports pagination. If the response includes a token, there are more records
	 * 	available. To get the additional records, repeat the request with the response token as the
	 * 	NextToken parameter.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ActivityIds - _string_|_array_ (Optional) A list containing the activity IDs of the desired scaling activities. If this list is omitted, all activities are described. If an AutoScalingGroupName is provided, the results are limited to that group. The list of requested activities cannot contain more than 50 items. If unknown activities are requested, they are ignored with no error. Pass a string for a single value, or an indexed array for multiple values.
	 *	AutoScalingGroupName - _string_ (Optional) The name of the AutoScalingGroup.
	 *	MaxRecords - _integer_ (Optional) The maximum number of scaling activities to return.
	 *	NextToken - _string_ (Optional) A string that marks the start of the next batch of returned results for pagination.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_scaling_activities($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['ActivityIds']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ActivityIds' => (is_array($opt['ActivityIds']) ? $opt['ActivityIds'] : array($opt['ActivityIds']))
			), 'member'));
			unset($opt['ActivityIds']);
		}

		return $this->authenticate('DescribeScalingActivities', $opt, $this->hostname);
	}

	/**
	 * Method: execute_policy()
	 * 	Runs the policy you create for your Auto Scaling group in PutScalingPolicy.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$policy_name - _string_ (Required) The name or PolicyARN of the policy you want to run.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AutoScalingGroupName - _string_ (Optional) The name or ARN of the Auto Scaling Group.
	 *	HonorCooldown - _boolean_ (Optional) Set to True if you want Auto Scaling to reject this request if the Auto Scaling group is in cooldown.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function execute_policy($policy_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['PolicyName'] = $policy_name;

		return $this->authenticate('ExecutePolicy', $opt, $this->hostname);
	}

	/**
	 * Method: describe_metric_collection_types()
	 * 	Returns a list of metrics and a corresponding list of granularities for each metric.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_metric_collection_types($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeMetricCollectionTypes', $opt, $this->hostname);
	}

	/**
	 * Method: describe_policies()
	 * 	Returns descriptions of what each policy does. This action supports pagination. If the response
	 * 	includes a token, there are more records available. To get the additional records, repeat the
	 * 	request with the response token as the NextToken parameter.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AutoScalingGroupName - _string_ (Optional) The name of the Auto Scaling group.
	 *	PolicyNames - _string_|_array_ (Optional) A list of policy names or policy ARNs to be described. If this list is omitted, all policy names are described. If an auto scaling group name is provided, the results are limited to that group.The list of requested policy names cannot contain more than 50 items. If unknown policy names are requested, they are ignored with no error. Pass a string for a single value, or an indexed array for multiple values.
	 *	NextToken - _string_ (Optional) A string that is used to mark the start of the next batch of returned results for pagination.
	 *	MaxRecords - _integer_ (Optional) The maximum number of policies that will be described with each call.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_policies($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['PolicyNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'PolicyNames' => (is_array($opt['PolicyNames']) ? $opt['PolicyNames'] : array($opt['PolicyNames']))
			), 'member'));
			unset($opt['PolicyNames']);
		}

		return $this->authenticate('DescribePolicies', $opt, $this->hostname);
	}

	/**
	 * Method: describe_adjustment_types()
	 * 	Returns policy adjustment types for use in the PutScalingPolicy action.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_adjustment_types($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeAdjustmentTypes', $opt, $this->hostname);
	}

	/**
	 * Method: delete_auto_scaling_group()
	 * 	Deletes the specified auto scaling group if the group has no instances and no scaling activities in
	 * 	progress.
	 *
	 * 	To remove all instances before calling DeleteAutoScalingGroup, you can call UpdateAutoScalingGroup
	 * 	to set the minimum and maximum size of the AutoScalingGroup to zero.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name of the Auto Scaling group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_auto_scaling_group($auto_scaling_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;

		return $this->authenticate('DeleteAutoScalingGroup', $opt, $this->hostname);
	}

	/**
	 * Method: create_auto_scaling_group()
	 * 	Creates a new Auto Scaling group with the specified name. Once the creation request is completed,
	 * 	the AutoScalingGroup is ready to be used in other calls.
	 *
	 * 	The Auto Scaling group name must be unique within the scope of your AWS account, and under the
	 * 	quota of Auto Scaling groups allowed for your account.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name of the Auto Scaling group.
	 *	$launch_configuration_name - _string_ (Required) The name of the launch configuration to use with the Auto Scaling group.
	 *	$min_size - _integer_ (Required) The minimum size of the Auto Scaling group.
	 *	$max_size - _integer_ (Required) The maximum size of the Auto Scaling group.
	 *	$availability_zones - _string_|_array_ (Required) A list of availability zones for the Auto Scaling group. Pass a string for a single value, or an indexed array for multiple values.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DesiredCapacity - _integer_ (Optional) The number of EC2 instances that should be running in the group.
	 *	DefaultCooldown - _integer_ (Optional) The amount of time, in seconds, after a scaling activity completes before any further trigger-related scaling activities can start.
	 *	LoadBalancerNames - _string_|_array_ (Optional) A list of LoadBalancers to use. Pass a string for a single value, or an indexed array for multiple values.
	 *	HealthCheckType - _string_ (Optional) The service you want the health status from, Amazon EC2 or Elastic Load Balancer.
	 *	HealthCheckGracePeriod - _integer_ (Optional) Length of time in seconds after a new EC2 instance comes into service that Auto Scaling starts checking its health.
	 *	PlacementGroup - _string_ (Optional) Physical location of your cluster placement group created in Amazon EC2.
	 *	VPCZoneIdentifier - _string_ (Optional) The subnet identifier of the Virtual Private Cloud.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_auto_scaling_group($auto_scaling_group_name, $launch_configuration_name, $min_size, $max_size, $availability_zones, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;
		$opt['LaunchConfigurationName'] = $launch_configuration_name;
		$opt['MinSize'] = $min_size;
		$opt['MaxSize'] = $max_size;

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'AvailabilityZones' => (is_array($availability_zones) ? $availability_zones : array($availability_zones))
		), 'member'));

		// Optional parameter
		if (isset($opt['LoadBalancerNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'LoadBalancerNames' => (is_array($opt['LoadBalancerNames']) ? $opt['LoadBalancerNames'] : array($opt['LoadBalancerNames']))
			), 'member'));
			unset($opt['LoadBalancerNames']);
		}

		return $this->authenticate('CreateAutoScalingGroup', $opt, $this->hostname);
	}

	/**
	 * Method: describe_auto_scaling_instances()
	 * 	Returns a description of each Auto Scaling instance in the InstanceIds list. If a list is not
	 * 	provided, the service returns the full details of all instances up to a maximum of fifty.
	 *
	 * 	This action supports pagination by returning a token if there are more pages to retrieve. To get
	 * 	the next page, call this action again with the returned token as the NextToken parameter.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	InstanceIds - _string_|_array_ (Optional) The list of Auto Scaling instances to describe. If this list is omitted, all auto scaling instances are described. The list of requested instances cannot contain more than 50 items. If unknown instances are requested, they are ignored with no error. Pass a string for a single value, or an indexed array for multiple values.
	 *	MaxRecords - _integer_ (Optional) The maximum number of Auto Scaling instances to be described with each call.
	 *	NextToken - _string_ (Optional) The token returned by a previous call to indicate that there is more data available.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_auto_scaling_instances($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['InstanceIds']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'InstanceIds' => (is_array($opt['InstanceIds']) ? $opt['InstanceIds'] : array($opt['InstanceIds']))
			), 'member'));
			unset($opt['InstanceIds']);
		}

		return $this->authenticate('DescribeAutoScalingInstances', $opt, $this->hostname);
	}

	/**
	 * Method: delete_launch_configuration()
	 * 	Deletes the specified LaunchConfiguration.
	 *
	 * 	The specified launch configuration must not be attached to an Auto Scaling group. Once this call
	 * 	completes, the launch configuration is no longer available for use.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$launch_configuration_name - _string_ (Required) The name of the launch configuration.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_launch_configuration($launch_configuration_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['LaunchConfigurationName'] = $launch_configuration_name;

		return $this->authenticate('DeleteLaunchConfiguration', $opt, $this->hostname);
	}

	/**
	 * Method: put_scaling_policy()
	 * 	Creates or updates a policy for an Auto Scaling group. To update an existing policy, use the
	 * 	existing policy name and set the parameter(s) you want to change. Any existing parameter not changed
	 * 	in an update to an existing policy is not changed in this update request.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name or ARN of the Auto Scaling Group.
	 *	$policy_name - _string_ (Required) The name of the policy you want to create or update.
	 *	$scaling_adjustment - _integer_ (Required) The number of instances by which to scale. AdjustmentType determines the interpretation of this number (e.g., as an absolute number or as a percentage of the existing Auto Scaling group size). A positive increment adds to the current capacity and a negative value removes from the current capacity.
	 *	$adjustment_type - _string_ (Required) Specifies whether the ScalingAdjustment is an absolute number or a percentage of the current capacity. Valid values are ChangeInCapacity, ExactCapacity, and PercentOfCapacity.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Cooldown - _integer_ (Optional) The amount of time, in seconds, after a scaling activity completes before any further trigger-related scaling activities can start.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function put_scaling_policy($auto_scaling_group_name, $policy_name, $scaling_adjustment, $adjustment_type, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;
		$opt['PolicyName'] = $policy_name;
		$opt['ScalingAdjustment'] = $scaling_adjustment;
		$opt['AdjustmentType'] = $adjustment_type;

		return $this->authenticate('PutScalingPolicy', $opt, $this->hostname);
	}

	/**
	 * Method: set_instance_health()
	 * 	Sets the health status of an instance.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$instance_id - _string_ (Required) The identifier of the EC2 instance.
	 *	$health_status - _string_ (Required) The health status of the instance. "Healthy" means that the instance is healthy and should remain in service. "Unhealthy" means that the instance is unhealthy. Auto Scaling should terminate and replace it.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ShouldRespectGracePeriod - _boolean_ (Optional) If True, this call should respect the grace period associated with the group.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function set_instance_health($instance_id, $health_status, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InstanceId'] = $instance_id;
		$opt['HealthStatus'] = $health_status;

		return $this->authenticate('SetInstanceHealth', $opt, $this->hostname);
	}

	/**
	 * Method: update_auto_scaling_group()
	 * 	Updates the configuration for the specified AutoScalingGroup.
	 *
	 * 	The new settings are registered upon the completion of this call. Any launch configuration settings
	 * 	take effect on any triggers after this call returns. Triggers that are currently in progress aren't
	 * 	affected.
	 *
	 * 	If the new values are specified for the MinSize or MaxSize parameters, then there will be an
	 * 	implicit call to SetDesiredCapacity to set the group to the new MaxSize. All optional parameters are
	 * 	left unchanged if not passed in the request.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name of the Auto Scaling group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	LaunchConfigurationName - _string_ (Optional) The name of the launch configuration.
	 *	MinSize - _integer_ (Optional) The minimum size of the Auto Scaling group.
	 *	MaxSize - _integer_ (Optional) The maximum size of the Auto Scaling group.
	 *	DesiredCapacity - _integer_ (Optional) The desired capacity for the Auto Scaling group.
	 *	DefaultCooldown - _integer_ (Optional) The amount of time, in seconds, after a scaling activity completes before any further trigger-related scaling activities can start.
	 *	AvailabilityZones - _string_|_array_ (Optional) Availability zones for the group. Pass a string for a single value, or an indexed array for multiple values.
	 *	HealthCheckType - _string_ (Optional) The service of interest for the health status check, either "EC2" for Amazon EC2 or "ELB" for Elastic Load Balancing.
	 *	HealthCheckGracePeriod - _integer_ (Optional) The length of time that Auto Scaling waits before checking an instance's health status. The grace period begins when an instance comes into service.
	 *	PlacementGroup - _string_ (Optional) The name of the cluster placement group, if applicable. For more information, go to Cluster Compute Instance Concepts in the Amazon EC2 Developer Guide.
	 *	VPCZoneIdentifier - _string_ (Optional) The identifier for the VPC connection, if applicable.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_auto_scaling_group($auto_scaling_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;

		// Optional parameter
		if (isset($opt['AvailabilityZones']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'AvailabilityZones' => (is_array($opt['AvailabilityZones']) ? $opt['AvailabilityZones'] : array($opt['AvailabilityZones']))
			), 'member'));
			unset($opt['AvailabilityZones']);
		}

		return $this->authenticate('UpdateAutoScalingGroup', $opt, $this->hostname);
	}

	/**
	 * Method: describe_scheduled_actions()
	 * 	Lists all the actions scheduled for your Auto Scaling group that haven't been executed. To see a
	 * 	list of action already executed, see the activity record returned in DescribeScalingActivities.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AutoScalingGroupName - _string_ (Optional) The name of the Auto Scaling group.
	 *	ScheduledActionNames - _string_|_array_ (Optional) A list of scheduled actions to be described. If this list is omitted, all scheduled actions are described. The list of requested scheduled actions cannot contain more than 50 items. If an auto scaling group name is provided, the results are limited to that group. If unknown scheduled actions are requested, they are ignored with no error. Pass a string for a single value, or an indexed array for multiple values.
	 *	StartTime - _string_ (Optional) The earliest scheduled start time to return. If scheduled action names are provided, this field will be ignored. Accepts any value that `strtotime()` understands.
	 *	EndTime - _string_ (Optional) The latest scheduled start time to return. If scheduled action names are provided, this field will be ignored. Accepts any value that `strtotime()` understands.
	 *	NextToken - _string_ (Optional) A string that marks the start of the next batch of returned results.
	 *	MaxRecords - _integer_ (Optional) The maximum number of scheduled actions to return.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_scheduled_actions($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['ScheduledActionNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ScheduledActionNames' => (is_array($opt['ScheduledActionNames']) ? $opt['ScheduledActionNames'] : array($opt['ScheduledActionNames']))
			), 'member'));
			unset($opt['ScheduledActionNames']);
		}

		// Optional parameter
		if (isset($opt['StartTime']))
		{
			$opt['StartTime'] = $this->util->convert_date_to_iso8601($opt['StartTime']);
		}

		// Optional parameter
		if (isset($opt['EndTime']))
		{
			$opt['EndTime'] = $this->util->convert_date_to_iso8601($opt['EndTime']);
		}

		return $this->authenticate('DescribeScheduledActions', $opt, $this->hostname);
	}

	/**
	 * Method: suspend_processes()
	 * 	Suspends Auto Scaling activities for an Auto Scaling group. To suspend specific process types,
	 * 	specify them by name with the `ScalingProcesses.member.N` parameter. To suspend all process types,
	 * 	omit the `ScalingProcesses.member.N` parameter.
	 *
	 * 	Suspending either of the two primary process types, `Launch` or `Terminate`, can prevent other
	 * 	process types from functioning properly. For more information about processes and their
	 * 	dependencies, see ProcessType.
	 *
	 * 	To resume processes that have been suspended, use ResumeProcesses.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name or Amazon Resource Name (ARN) of the Auto Scaling group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ScalingProcesses - _string_|_array_ (Optional) The processes that you want to suspend or resume, which can include one or more of the following: Launch; Terminate; HealthCheck; ReplaceUnhealthy; AZRebalance; AlarmNotifications; ScheduledActions. To suspend all process types, omit this parameter. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function suspend_processes($auto_scaling_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;

		// Optional parameter
		if (isset($opt['ScalingProcesses']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ScalingProcesses' => (is_array($opt['ScalingProcesses']) ? $opt['ScalingProcesses'] : array($opt['ScalingProcesses']))
			), 'member'));
			unset($opt['ScalingProcesses']);
		}

		return $this->authenticate('SuspendProcesses', $opt, $this->hostname);
	}

	/**
	 * Method: resume_processes()
	 * 	Resumes Auto Scaling activities for an Auto Scaling group. For more information, see
	 * 	SuspendProcesses and ProcessType.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name or Amazon Resource Name (ARN) of the Auto Scaling group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ScalingProcesses - _string_|_array_ (Optional) The processes that you want to suspend or resume, which can include one or more of the following: Launch; Terminate; HealthCheck; ReplaceUnhealthy; AZRebalance; AlarmNotifications; ScheduledActions. To suspend all process types, omit this parameter. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function resume_processes($auto_scaling_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;

		// Optional parameter
		if (isset($opt['ScalingProcesses']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ScalingProcesses' => (is_array($opt['ScalingProcesses']) ? $opt['ScalingProcesses'] : array($opt['ScalingProcesses']))
			), 'member'));
			unset($opt['ScalingProcesses']);
		}

		return $this->authenticate('ResumeProcesses', $opt, $this->hostname);
	}

	/**
	 * Method: create_launch_configuration()
	 * 	Creates a new launch configuration. Once created, the new launch configuration is available for
	 * 	immediate use.
	 *
	 * 	The launch configuration name used must be unique, within the scope of the client's AWS account,
	 * 	and the maximum limit of launch configurations must not yet have been met, or else the call will
	 * 	fail.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$launch_configuration_name - _string_ (Required) The name of the launch configuration to create.
	 *	$image_id - _string_ (Required) Unique ID of the _Amazon Machine Image_ (AMI) which was assigned during registration. For more information about Amazon EC2 images, please see Amazon EC2 product documentation
	 *	$instance_type - _string_ (Required) The instance type of the EC2 instance. For more information about Amazon EC2 instance types, please see Amazon EC2 product documentation
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	KeyName - _string_ (Optional) The name of the EC2 key pair.
	 *	SecurityGroups - _string_|_array_ (Optional) The names of the security groups with which to associate EC2 instances. For more information about Amazon EC2 security groups, go to the Amazon EC2 product documentation. Pass a string for a single value, or an indexed array for multiple values.
	 *	UserData - _string_ (Optional) The user data available to the launched EC2 instances. For more information about Amazon EC2 user data, please see Amazon EC2 product documentation.
	 *	KernelId - _string_ (Optional) The ID of the kernel associated with the EC2 AMI.
	 *	RamdiskId - _string_ (Optional) The ID of the RAM disk associated with the EC2 AMI.
	 *	BlockDeviceMappings - _ComplexList_ (Optional) A list of mappings that specify how block devices are exposed to the instance. Each mapping is made up of a _VirtualName_ and a _DeviceName_. For more information about Amazon EC2 BlockDeviceMappings, please see Amazon EC2 product documentation A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `BlockDeviceMappings` subtype (documented next), or by passing an associative array with the following `BlockDeviceMappings`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	BlockDeviceMappings.x.VirtualName - _string_ (Optional) The virtual name associated with the device.
	 *	BlockDeviceMappings.x.DeviceName - _string_ (Required) The name of the device within Amazon EC2.
	 *	BlockDeviceMappings.x.Ebs.SnapshotId - _string_ (Optional) The Snapshot ID.
	 *	BlockDeviceMappings.x.Ebs.VolumeSize - _integer_ (Optional) The volume size, in GigaBytes.
	 *	InstanceMonitoring - _ComplexType_ (Optional) Enables detailed monitoring. A ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `InstanceMonitoring` subtype (documented next), or by passing an associative array with the following `InstanceMonitoring`-prefixed entries as keys. See below for a list and a usage example.
	 *	InstanceMonitoring.Enabled - _boolean_ (Optional) If true, instance monitoring is enabled.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_launch_configuration($launch_configuration_name, $image_id, $instance_type, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['LaunchConfigurationName'] = $launch_configuration_name;
		$opt['ImageId'] = $image_id;

		// Optional parameter
		if (isset($opt['SecurityGroups']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'SecurityGroups' => (is_array($opt['SecurityGroups']) ? $opt['SecurityGroups'] : array($opt['SecurityGroups']))
			), 'member'));
			unset($opt['SecurityGroups']);
		}
		$opt['InstanceType'] = $instance_type;

		// Optional parameter
		if (isset($opt['BlockDeviceMappings']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'BlockDeviceMappings' => $opt['BlockDeviceMappings']
			), 'member'));
			unset($opt['BlockDeviceMappings']);
		}

		// Optional parameter
		if (isset($opt['InstanceMonitoring']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'InstanceMonitoring' => $opt['InstanceMonitoring']
			), 'member'));
			unset($opt['InstanceMonitoring']);
		}

		return $this->authenticate('CreateLaunchConfiguration', $opt, $this->hostname);
	}

	/**
	 * Method: disable_metrics_collection()
	 * 	Disables monitoring for the list of metrics in Metrics in the Auto Scaling group specified in
	 * 	AutoScalingGroupName.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$auto_scaling_group_name - _string_ (Required) The name or ARN of the Auto Scaling Group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Metrics - _string_|_array_ (Optional) The list of metrics to no longer collect. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function disable_metrics_collection($auto_scaling_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AutoScalingGroupName'] = $auto_scaling_group_name;

		// Optional parameter
		if (isset($opt['Metrics']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Metrics' => (is_array($opt['Metrics']) ? $opt['Metrics'] : array($opt['Metrics']))
			), 'member'));
			unset($opt['Metrics']);
		}

		return $this->authenticate('DisableMetricsCollection', $opt, $this->hostname);
	}
}


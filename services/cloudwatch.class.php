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
 * File: AmazonCloudWatch
 * 	Amazon CloudWatch is a web service that enables you to monitor and manage various metrics, as well
 * 	as configure alarm actions based on data from metrics. Amazon CloudWatch monitoring enables you to
 * 	collect, analyze, and view system and application metrics so that you can make operational and
 * 	business decisions more quickly and with greater confidence. You can use Amazon CloudWatch to
 * 	collect metrics about your AWS resources, such as the performance of your Amazon EC2 instances. If
 * 	you are registered for an AWS product that supports Amazon CloudWatch, the service automatically
 * 	pushes basic metrics to CloudWatch for you. Once Amazon CloudWatch contains metrics, you can
 * 	calculate statistics based on that data. Amazon CloudWatch alarms help you implement decisions more
 * 	easily by enabling you do things like send notifications or automatically make changes to the
 * 	resources you are monitoring, based on rules that you define. For example, you can create alarms
 * 	that initiate Auto Scaling and Simple Notification Service actions on your behalf.
 *
 * Version:
 * 	Fri Dec 03 16:23:21 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon CloudWatch](http://aws.amazon.com/cloudwatch/)
 * 	[Amazon CloudWatch documentation](http://aws.amazon.com/documentation/cloudwatch/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: CloudWatch_Exception
 * 	Default CloudWatch Exception.
 */
class CloudWatch_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonCloudWatch
 * 	Container for all service-related methods.
 */
class AmazonCloudWatch extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'monitoring.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = 'us-east-1';

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'us-west-1';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'eu-west-1';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'ap-southeast-1';


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
	 * 	$region - _string_ (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_W1>, <REGION_EU_W1>, and <REGION_APAC_SE1>.
	 *
	 * Returns:
	 * 	`$this`
	 */
	public function set_region($region)
	{
		$this->set_hostname('http://monitoring.'. $region .'.amazonaws.com');
		return $this;
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonCloudWatch>.
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
			throw new CW_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new CW_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: put_metric_alarm()
	 * 	Creates or updates an alarm and associates it with the specified Amazon CloudWatch metric.
	 * 	Optionally, this operation can associate one or more Amazon Simple Notification Service resources
	 * 	with the alarm. When this operation creates an alarm, the alarm state is immediately set to
	 * 	`UNKNOWN`. The alarm is evaluated and its `StateValue` is set appropriately. Any actions associated
	 * 	with the `StateValue` is then executed. When updating an existing alarm, its `StateValue` is left
	 * 	unchanged.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$alarm_name - _string_ (Required) The descriptive name for the alarm. This name must be unique within the user's AWS account
	 *	$metric_name - _string_ (Required) The name for the alarm's associated metric.
	 *	$namespace - _string_ (Required) The namespace for the alarm's associated metric.
	 *	$statistic - _string_ (Required) The statistic to apply to the alarm's associated metric. [Allowed values: `SampleCount`, `Average`, `Sum`, `Minimum`, `Maximum`]
	 *	$period - _integer_ (Required) The period in seconds over which the specified statistic is applied.
	 *	$evaluation_periods - _integer_ (Required) The number of periods over which data is compared to the specified threshold.
	 *	$threshold - _double_ (Required) The value against which the specified statistic is compared.
	 *	$comparison_operator - _string_ (Required) The arithmetic operation to use when comparing the specified `Statistic` and `Threshold`. The specified `Statistic` value is used as the first operand. [Allowed values: `GreaterThanOrEqualToThreshold`, `GreaterThanThreshold`, `LessThanThreshold`, `LessThanOrEqualToThreshold`]
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AlarmDescription - _string_ (Optional) The description for the alarm.
	 *	ActionsEnabled - _boolean_ (Optional) Indicates whether or not actions should be executed during any changes to the alarm's state.
	 *	OKActions - _string_|_array_ (Optional) The list of actions to execute when this alarm transitions into an `OK` state from any other state. Each action is specified as an Amazon Resource Number (ARN). Currently the only action supported is publishing to an Amazon SNS topic or an Amazon Auto Scaling policy. Pass a string for a single value, or an indexed array for multiple values.
	 *	AlarmActions - _string_|_array_ (Optional) The list of actions to execute when this alarm transitions into an `ALARM` state from any other state. Each action is specified as an Amazon Resource Number (ARN). Currently the only action supported is publishing to an Amazon SNS topic or an Amazon Auto Scaling policy. Pass a string for a single value, or an indexed array for multiple values.
	 *	InsufficientDataActions - _string_|_array_ (Optional) The list of actions to execute when this alarm transitions into an `UNKNOWN` state from any other state. Each action is specified as an Amazon Resource Number (ARN). Currently the only action supported is publishing to an Amazon SNS topic or an Amazon Auto Scaling policy. Pass a string for a single value, or an indexed array for multiple values.
	 *	Dimensions - _ComplexList_ (Optional) The dimensions for the alarm's associated metric. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `Dimensions` subtype (documented next), or by passing an associative array with the following `Dimensions`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	Dimensions.x.Name - _string_ (Required) The name of the dimension.
	 *	Dimensions.x.Value - _string_ (Required) The value representing the dimension measurement
	 *	Unit - _string_ (Optional) The unit for the alarm's associated metric. [Allowed values: `Seconds`, `Microseconds`, `Milliseconds`, `Bytes`, `Kilobytes`, `Megabytes`, `Gigabytes`, `Terabytes`, `Bits`, `Kilobits`, `Megabits`, `Gigabits`, `Terabits`, `Percent`, `Count`, `Bytes/Second`, `Kilobytes/Second`, `Megabytes/Second`, `Gigabytes/Second`, `Terabytes/Second`, `Bits/Second`, `Kilobits/Second`, `Megabits/Second`, `Gigabits/Second`, `Terabits/Second`, `Count/Second`, `None`]
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function put_metric_alarm($alarm_name, $metric_name, $namespace, $statistic, $period, $evaluation_periods, $threshold, $comparison_operator, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AlarmName'] = $alarm_name;

		// Optional parameter
		if (isset($opt['OKActions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OKActions' => (is_array($opt['OKActions']) ? $opt['OKActions'] : array($opt['OKActions']))
			), 'member'));
			unset($opt['OKActions']);
		}

		// Optional parameter
		if (isset($opt['AlarmActions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'AlarmActions' => (is_array($opt['AlarmActions']) ? $opt['AlarmActions'] : array($opt['AlarmActions']))
			), 'member'));
			unset($opt['AlarmActions']);
		}

		// Optional parameter
		if (isset($opt['InsufficientDataActions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'InsufficientDataActions' => (is_array($opt['InsufficientDataActions']) ? $opt['InsufficientDataActions'] : array($opt['InsufficientDataActions']))
			), 'member'));
			unset($opt['InsufficientDataActions']);
		}
		$opt['MetricName'] = $metric_name;
		$opt['Namespace'] = $namespace;
		$opt['Statistic'] = $statistic;

		// Optional parameter
		if (isset($opt['Dimensions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Dimensions' => $opt['Dimensions']
			), 'member'));
			unset($opt['Dimensions']);
		}
		$opt['Period'] = $period;
		$opt['EvaluationPeriods'] = $evaluation_periods;
		$opt['Threshold'] = $threshold;
		$opt['ComparisonOperator'] = $comparison_operator;

		return $this->authenticate('PutMetricAlarm', $opt, $this->hostname);
	}

	/**
	 * Method: list_metrics()
	 * 	Returns a list of valid metrics stored for the AWS account owner. Returned metrics can be used with
	 * 	`GetMetricStatistics` to obtain statistical data for a given metric. Up to 500 results are returned
	 * 	for any one call. To retrieve further results, use returned `NextToken` values with subsequent
	 * 	`ListMetrics` operations.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Namespace - _string_ (Optional) The namespace to filter against.
	 *	MetricName - _string_ (Optional) The name of the metric to filter against.
	 *	Dimensions - _ComplexList_ (Optional) A list of dimensions to filter against. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `Dimensions` subtype (documented next), or by passing an associative array with the following `Dimensions`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	Dimensions.x.Name - _string_ (Required) The dimension name to be matched.
	 *	Dimensions.x.Value - _string_ (Optional) The value of the dimension to be matched. Specifying a `Name` without specifying a `Value` is equivalent to "wildcarding" the `Name` for all values.
	 *	NextToken - _string_ (Optional) The token returned by a previous call to indicate that there is more data available.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_metrics($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['Dimensions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Dimensions' => $opt['Dimensions']
			), 'member'));
			unset($opt['Dimensions']);
		}

		return $this->authenticate('ListMetrics', $opt, $this->hostname);
	}

	/**
	 * Method: get_metric_statistics()
	 * 	Gets statistics for the specified metric. The maximum number of datapoints returned from a single
	 * 	`GetMetricStatistics` request is 1,440. If a request is made that generates more than 1,440
	 * 	datapoints, Amazon CloudWatch returns an error. In such a case, alter the request by narrowing the
	 * 	specified time range or increasing the specified period. Alternatively, make multiple requests
	 * 	across adjacent time ranges.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$namespace - _string_ (Required) The namespace of the metric.
	 *	$metric_name - _string_ (Required) The name of the metric.
	 *	$start_time - _string_ (Required) The timestamp to use for determining the first datapoint to return. The value specified is inclusive; results include datapoints with the timestamp specified. The specified start time is rounded down to the nearest value. Datapoints are returned for start times up to two weeks in the past. Specified start times that are more than two weeks in the past will not return datapoints for metrics that are older than two weeks. Accepts any value that `strtotime()` understands.
	 *	$end_time - _string_ (Required) The time stamp to use for determining the last datapoint to return. The value specified is exclusive; results will include datapoints up to the time stamp specified. Accepts any value that `strtotime()` understands.
	 *	$period - _integer_ (Required) The granularity, in seconds, of the returned datapoints. `Period` must be at least 60 seconds and must be a multiple of 60. The default value is 60.
	 *	$statistics - _string_|_array_ (Required) The metric statistics to return. Pass a string for a single value, or an indexed array for multiple values.
	 *	$unit - _string_ (Required) The unit for the metric. [Allowed values: `Seconds`, `Microseconds`, `Milliseconds`, `Bytes`, `Kilobytes`, `Megabytes`, `Gigabytes`, `Terabytes`, `Bits`, `Kilobits`, `Megabits`, `Gigabits`, `Terabits`, `Percent`, `Count`, `Bytes/Second`, `Kilobytes/Second`, `Megabytes/Second`, `Gigabytes/Second`, `Terabytes/Second`, `Bits/Second`, `Kilobits/Second`, `Megabits/Second`, `Gigabits/Second`, `Terabits/Second`, `Count/Second`, `None`]
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Dimensions - _ComplexList_ (Optional) A list of dimensions describing qualities of the metric. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `Dimensions` subtype (documented next), or by passing an associative array with the following `Dimensions`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	Dimensions.x.Name - _string_ (Required) The name of the dimension.
	 *	Dimensions.x.Value - _string_ (Required) The value representing the dimension measurement
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_metric_statistics($namespace, $metric_name, $start_time, $end_time, $period, $statistics, $unit, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Namespace'] = $namespace;
		$opt['MetricName'] = $metric_name;

		// Optional parameter
		if (isset($opt['Dimensions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Dimensions' => $opt['Dimensions']
			), 'member'));
			unset($opt['Dimensions']);
		}
		$opt['StartTime'] = $this->util->convert_date_to_iso8601($start_time);
		$opt['EndTime'] = $this->util->convert_date_to_iso8601($end_time);
		$opt['Period'] = $period;

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'Statistics' => (is_array($statistics) ? $statistics : array($statistics))
		), 'member'));
		$opt['Unit'] = $unit;

		return $this->authenticate('GetMetricStatistics', $opt, $this->hostname);
	}

	/**
	 * Method: disable_alarm_actions()
	 * 	Disables actions for the specified alarms. When an alarm's actions are disabled the alarm's state
	 * 	may change, but none of the alarm's actions will execute.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$alarm_names - _string_|_array_ (Required) The names of the alarms to disable actions for. Pass a string for a single value, or an indexed array for multiple values.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function disable_alarm_actions($alarm_names, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'AlarmNames' => (is_array($alarm_names) ? $alarm_names : array($alarm_names))
		), 'member'));

		return $this->authenticate('DisableAlarmActions', $opt, $this->hostname);
	}

	/**
	 * Method: describe_alarms()
	 * 	Retrieves alarms with the specified names. If no name is specified, all alarms for the user are
	 * 	returned. Alarms can be retrieved by using only a prefix for the alarm name, the alarm state, or a
	 * 	prefix for any action.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AlarmNames - _string_|_array_ (Optional) A list of alarm names to retrieve information for. Pass a string for a single value, or an indexed array for multiple values.
	 *	AlarmNamePrefix - _string_ (Optional) The alarm name prefix. `AlarmNames` cannot be specified if this parameter is specified.
	 *	StateValue - _string_ (Optional) The state value to be used in matching alarms. [Allowed values: `OK`, `ALARM`, `INSUFFICIENT_DATA`]
	 *	ActionPrefix - _string_ (Optional) The action name prefix.
	 *	MaxRecords - _integer_ (Optional) The maximum number of alarm descriptions to retrieve.
	 *	NextToken - _string_ (Optional) The token returned by a previous call to indicate that there is more data available.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_alarms($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['AlarmNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'AlarmNames' => (is_array($opt['AlarmNames']) ? $opt['AlarmNames'] : array($opt['AlarmNames']))
			), 'member'));
			unset($opt['AlarmNames']);
		}

		return $this->authenticate('DescribeAlarms', $opt, $this->hostname);
	}

	/**
	 * Method: describe_alarms_for_metric()
	 * 	Retrieves all alarms for a single metric. Specify a statistic, period, or unit to filter the set of
	 * 	alarms further.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$metric_name - _string_ (Required) The name of the metric.
	 *	$namespace - _string_ (Required) The namespace of the metric.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Statistic - _string_ (Optional) The statistic for the metric. [Allowed values: `SampleCount`, `Average`, `Sum`, `Minimum`, `Maximum`]
	 *	Dimensions - _ComplexList_ (Optional) The list of dimensions associated with the metric. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `Dimensions` subtype (documented next), or by passing an associative array with the following `Dimensions`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	Dimensions.x.Name - _string_ (Required) The name of the dimension.
	 *	Dimensions.x.Value - _string_ (Required) The value representing the dimension measurement
	 *	Period - _integer_ (Optional) The period in seconds over which the statistic is applied.
	 *	Unit - _string_ (Optional) The unit for the metric. [Allowed values: `Seconds`, `Microseconds`, `Milliseconds`, `Bytes`, `Kilobytes`, `Megabytes`, `Gigabytes`, `Terabytes`, `Bits`, `Kilobits`, `Megabits`, `Gigabits`, `Terabits`, `Percent`, `Count`, `Bytes/Second`, `Kilobytes/Second`, `Megabytes/Second`, `Gigabytes/Second`, `Terabytes/Second`, `Bits/Second`, `Kilobits/Second`, `Megabits/Second`, `Gigabits/Second`, `Terabits/Second`, `Count/Second`, `None`]
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_alarms_for_metric($metric_name, $namespace, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['MetricName'] = $metric_name;
		$opt['Namespace'] = $namespace;

		// Optional parameter
		if (isset($opt['Dimensions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Dimensions' => $opt['Dimensions']
			), 'member'));
			unset($opt['Dimensions']);
		}

		return $this->authenticate('DescribeAlarmsForMetric', $opt, $this->hostname);
	}

	/**
	 * Method: describe_alarm_history()
	 * 	Retrieves history for the specified alarm. Filter alarms by date range or item type. If an alarm
	 * 	name is not specified, Amazon CloudWatch returns histories for all of the owner's alarms. Amazon
	 * 	CloudWatch retains the history of deleted alarms for a period of six weeks. If an alarm has been
	 * 	deleted, its history can still be queried.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AlarmName - _string_ (Optional) The name of the alarm.
	 *	HistoryItemType - _string_ (Optional) The type of alarm histories to retrieve. [Allowed values: `ConfigurationUpdate`, `StateUpdate`, `Action`]
	 *	StartDate - _string_ (Optional) The starting date to retrieve alarm history. Accepts any value that `strtotime()` understands.
	 *	EndDate - _string_ (Optional) The ending date to retrieve alarm history. Accepts any value that `strtotime()` understands.
	 *	MaxRecords - _integer_ (Optional) The maximum number of alarm history records to retrieve.
	 *	NextToken - _string_ (Optional) The token returned by a previous call to indicate that there is more data available.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_alarm_history($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['StartDate']))
		{
			$opt['StartDate'] = $this->util->convert_date_to_iso8601($opt['StartDate']);
		}

		// Optional parameter
		if (isset($opt['EndDate']))
		{
			$opt['EndDate'] = $this->util->convert_date_to_iso8601($opt['EndDate']);
		}

		return $this->authenticate('DescribeAlarmHistory', $opt, $this->hostname);
	}

	/**
	 * Method: enable_alarm_actions()
	 * 	Enables actions for the specified alarms.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$alarm_names - _string_|_array_ (Required) The names of the alarms to enable actions for. Pass a string for a single value, or an indexed array for multiple values.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function enable_alarm_actions($alarm_names, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'AlarmNames' => (is_array($alarm_names) ? $alarm_names : array($alarm_names))
		), 'member'));

		return $this->authenticate('EnableAlarmActions', $opt, $this->hostname);
	}

	/**
	 * Method: delete_alarms()
	 * 	Deletes all specified alarms. In the event of an error, no alarms are deleted.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$alarm_names - _string_|_array_ (Required) A list of alarms to be deleted. Pass a string for a single value, or an indexed array for multiple values.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_alarms($alarm_names, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'AlarmNames' => (is_array($alarm_names) ? $alarm_names : array($alarm_names))
		), 'member'));

		return $this->authenticate('DeleteAlarms', $opt, $this->hostname);
	}

	/**
	 * Method: set_alarm_state()
	 * 	Temporarily sets the state of an alarm. When the updated `StateValue` differs from the previous
	 * 	value, the action configured for the appropriate state is invoked. This is not a permanent change.
	 * 	The next periodic alarm check (in about a minute) will set the alarm to its actual state.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$alarm_name - _string_ (Required) The descriptive name for the alarm. This name must be unique within the user's AWS account
	 *	$state_value - _string_ (Required) The value of the state. [Allowed values: `OK`, `ALARM`, `INSUFFICIENT_DATA`]
	 *	$state_reason - _string_ (Required) The reason that this alarm is set to this specific state (in human-readable text format)
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	StateReasonData - _string_ (Optional) The reason that this alarm is set to this specific state (in machine-readable JSON format)
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function set_alarm_state($alarm_name, $state_value, $state_reason, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AlarmName'] = $alarm_name;
		$opt['StateValue'] = $state_value;
		$opt['StateReason'] = $state_reason;

		return $this->authenticate('SetAlarmState', $opt, $this->hostname);
	}
}


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
 *
 *
 * Version:
 * 	Tue Oct 05 13:40:50 PDT 2010
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
		$this->api_version = '2009-05-15';
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
	 * Method: list_metrics()
	 * 	Returns a list of up to 500 valid metrics for which there is recorded data available to a you
	 * 	and a NextToken string that can be used to query for the next set of results.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	NextToken - _string_ (Optional) Allows you to retrieve the next set of results for your ListMetrics query.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_metrics($opt = null)
	{
		if (!$opt) $opt = array();
		return $this->authenticate('ListMetrics', $opt, $this->hostname);
	}

	/**
	 * Method: get_metric_statistics()
	 *
	 * 	The maximum number of datapoints that the Amazon CloudWatch service will return in a single
	 * 	GetMetricStatistics request is 1,440. If a request is made that would generate more datapoints
	 * 	than this amount, Amazon CloudWatch returns an error. You can alter your request by narrowing
	 * 	the time range (StartTime, EndTime) or increasing the Period in your single request.
	 *
	 * 	You may also get all of the data at the granularity you originally asked for by making multiple
	 * 	requests with adjacent time ranges.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$measure_name - _string_ (Required)The measure name that corresponds to the measure for the gathered metric. See the [metrics documentation](http://docs.amazonwebservices.com/AmazonCloudWatch/latest/DeveloperGuide/index.html?arch-AmazonCloudWatch-metricscollected.html) for a list of available measurements.
	 * 	$statistics - _string_|_array_ (Required) The statistics to be returned for the given metric. You can pass a string for a single statistic, or an indexed array for multiple statistics. See the [statistics documentation](http://docs.amazonwebservices.com/AmazonCloudWatch/latest/DeveloperGuide/index.html?arch-Amazon-CloudWatch-statistics.html) for a list of available statistics.
	 * 	$unit - _string_ (Required) The standard unit of measurement for a given Measure. See the [units documentation](http://docs.amazonwebservices.com/AmazonCloudWatch/latest/DeveloperGuide/index.html?DT_StandardUnit.html) for a list of available units.
	 * 	$start_time - _string_ (Required) A time stamp representing the beginning of the period to get results for. Looks for an ISO-8601 formatted time stamp, but can convert any understandable time stamp into the correct format automatically.
	 * 	$end_time - _string_ (Required) A time stamp representing the end of the period to get results for. Looks for an ISO-8601 formatted time stamp, but can convert any understandable time stamp into the correct format automatically.
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	CustomUnit - _string_ (Optional) The user-defined CustomUnit applied to a Measure.
	 * 	Dimensions - _CFComplexType_ (Optional) Allows you to specify one Dimension to further filter metric data on. If you don't specify a dimension, the service returns the aggregate of all the measures with the given measure name and time range. See the [dimension documentation](http://docs.amazonwebservices.com/AmazonCloudWatch/latest/DeveloperGuide/index.html?arch-Amazon-CloudWatch-dimensions.html) for a list of available dimensions.
	 * 	Namespace - _string_ (Optional) The namespace corresponding to the service of interest. For example, "AWS/EC2" represents Amazon EC2.
	 * 	Period - _integer_ (Optional) The granularity (in seconds) of the returned datapoints. Must be a multiple of 60. Defaults to 60.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_metric_statistics($measure_name, $statistics, $unit, $start_time, $end_time, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['MeasureName'] = $measure_name;
		$opt['Unit'] = $unit;
		$opt['StartTime'] = $this->util->convert_date_to_iso8601($start_time);
		$opt['EndTime'] = $this->util->convert_date_to_iso8601($end_time);

		$opt = array_merge($opt, CFComplexType::map(array(
			'Statistics' => array(
				'member' => (is_array($statistics) ? $statistics : array($statistics))
			)
		)));

		if (!isset($opt['Period']))
		{
			$opt['Period'] = 60;
		}

		return $this->authenticate('GetMetricStatistics', $opt, $this->hostname);
	}
}

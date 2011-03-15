<?php
/*
 * Copyright 2010-2011 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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
 *
 * This is the AWS CloudFormation API Reference.
 *
 * This guide is for programmers who need detailed information about the CloudFormation APIs. You use AWS CloudFormation to
 * create and manage AWS infrastructure deployments predictably and repeatedly. CloudFormation helps you leverage AWS
 * products such as Amazon EC2, EBS, Amazon SNS, ELB, and Auto Scaling to build highly-reliable, highly scalable, cost
 * effective applications without worrying about creating and configuring the underlying the AWS infrastructure.
 *
 * Through the use of a template file you write, and a few AWS CloudFormation commands or API actions, AWS CloudFormation
 * enables you to manage a collection of resources together as a single unit called a stack. AWS CloudFormation creates and
 * deletes all member resources of the stack together and manages all dependencies between the resources for you.
 *
 * For more information about this product, go to the <a
 * href="http://aws.amazon.com/documentation/cloudformation">CloudFormation Product Page</a>.
 *
 * Amazon CloudFormation makes use of other AWS products. If you need additional technical information about a specific AWS
 * product, you can find the product's technical documentation at http://aws.amazon.com/documentation/.
 *
 * @version Tue Mar 15 11:07:12 PDT 2011
 * @license See the included NOTICE.md file for complete information.
 * @copyright See the included NOTICE.md file for complete information.
 * @link http://aws.amazon.com/cloudformation/Amazon CloudFormation
 * @link http://aws.amazon.com/documentation/cloudformation/Amazon CloudFormation documentation
 */
class AmazonCloudFormation extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Specify the default queue URL.
	 */
	const DEFAULT_URL = 'cloudformation.us-east-1.amazonaws.com';

	/**
	 * Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = self::DEFAULT_URL;

	/**
	 * Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'cloudformation.us-west-1.amazonaws.com';

	/**
	 * Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'cloudformation.eu-west-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'cloudformation.ap-southeast-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific (Japan) Region.
	 */
	const REGION_APAC_NE1 = 'cloudformation.ap-northeast-1.amazonaws.com';


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * This allows you to explicitly sets the region for the service to use.
	 *
	 * @param string $region (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_W1>, <REGION_EU_W1>, or <REGION_APAC_SE1>.
	 * @return $this A reference to the current instance.
	 */
	public function set_region($region)
	{
		$this->set_hostname($region);
		return $this;
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of <AmazonCloudFormation>.
	 *
	 * @param string $key (Optional) Your Amazon API Key. If blank, it will look for the <code>AWS_KEY</code> constant.
	 * @param string $secret_key (Optional) Your Amazon API Secret Key. If blank, it will look for the <code>AWS_SECRET_KEY</code> constant.
	 * @return boolean false if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->api_version = '2010-05-15';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new CloudFormation_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new CloudFormation_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 *
	 * Creates a stack as specified in the template. Once the call completes successfully, the stack creation starts. You can
	 * check the status of the stack via the DescribeStacks API.
	 *
	 * AWS CloudFormation allows you to create and delete related AWS resources together as a unit called a stack. You define
	 * the characteristics of a stack using a template, which is a JSON-compliant text file. For more information, go to the <a
	 * href="http://docs.amazonwebservices.com/AWSCloudFormation/latest/CFNGuide">AWS CloudFormation User Guide</a>.
	 *
	 * Currently, the quota for stacks is 20 per region.
	 *
	 * @param string $stack_name (Required) The name associated with the Stack. The name must be unique within your AWS account. Must contain only alphanumeric characters (case sensitive) and start with an alpha character. Maximum length of the name is 255 characters.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>TemplateBody</code> - <code>string</code> - Optional - Structure containing the template body. (For more information, go to the AWS CloudFormation User Guide.) You must pass <code>TemplateBody</code> or <code>TemplateURL</code>. If both are passed, only <code>TemplateBody</code> is used. </li>
	 * 	<li><code>TemplateURL</code> - <code>string</code> - Optional - Location of file containing the template body. (For more information, go to the AWS CloudFormation User Guide.) You must pass <code>TemplateURL</code> or <code>TemplateBody</code>. If both are passed, only <code>TemplateBody</code> is used. </li>
	 * 	<li><code>Parameters</code> - <code>array</code> - Optional - A list of <code>Parameter</code> structures. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>ParameterKey</code> - <code>string</code> - Optional - The key associated with the parameter. </li>
	 * 			<li><code>ParameterValue</code> - <code>string</code> - Optional - The value associated with the parameter. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>DisableRollback</code> - <code>boolean</code> - Optional - Boolean to enable or disable rollback on stack creation failures. Default: <code>false</code> </li>
	 * 	<li><code>TimeoutInMinutes</code> - <code>integer</code> - Optional - If the time limit is exceeded, the stack is marked CREATE_FAILED; if <code>RollbackOnFailure</code> is set, the stack will be rolled back. </li>
	 * 	<li><code>NotificationARNs</code> - <code>string|array</code> - Optional - The Simple Notification Service (SNS) topic ARNs to publish stack related events. You can find your SNS topic ARNs using the SNS console or your Command Line Interface (CLI).  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <php:curl_setopt()>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_stack($stack_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['StackName'] = $stack_name;

		// Optional parameter
		if (isset($opt['Parameters']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Parameters' => $opt['Parameters']
			), 'member'));
			unset($opt['Parameters']);
		}

		// Optional parameter
		if (isset($opt['NotificationARNs']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'NotificationARNs' => (is_array($opt['NotificationARNs']) ? $opt['NotificationARNs'] : array($opt['NotificationARNs']))
			), 'member'));
			unset($opt['NotificationARNs']);
		}

		return $this->authenticate('CreateStack', $opt, $this->hostname);
	}

	/**
	 *
	 * Validates a specified template.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>TemplateBody</code> - <code>string</code> - Optional - Structure containing the template body. (For more information, go to the AWS CloudFormation User Guide.) </li>
	 * 	<li><code>TemplateURL</code> - <code>string</code> - Optional - Location of file containing the template body. (For more information, go to the AWS CloudFormation User Guide.) </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <php:curl_setopt()>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function validate_template($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ValidateTemplate', $opt, $this->hostname);
	}

	/**
	 *
	 * Returns the description for the specified stack; if no stack name was specified, then it returns the description for
	 * all the stacks created.
	 *
	 * If a specified stack does not exist or has been successfully deleted, a <code>ValidationError</code> is returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>StackName</code> - <code>string</code> - Optional - The name or the unique identifier associated with the stack. Default: <code>null</code> </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <php:curl_setopt()>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_stacks($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeStacks', $opt, $this->hostname);
	}

	/**
	 *
	 * Returns all the stack related events for the AWS account. If <code>StackName</code> is specified, returns events
	 * related to all the stacks with the given name. If <code>StackName</code> is not specified, returns all the events for
	 * the account. For more information about a stack's event history, go to the <a
	 * href="http://docs.amazonwebservices.com/AWSCloudFormation/latest/CFNGuide">AWS CloudFormation User Guide</a>.
	 *
	 * Events are returned, even if the stack has been successfully deleted. If the stack never existed, a
	 * <code>ValidationError</code> is returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>StackName</code> - <code>string</code> - Optional - The name or the unique identifier associated with the stack. Default: <code>null</code> </li>
	 * 	<li><code>NextToken</code> - <code>string</code> - Optional - String that identifies the start of the next list of events, if there is one. Default: <code>null</code> </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <php:curl_setopt()>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_stack_events($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeStackEvents', $opt, $this->hostname);
	}

	/**
	 *
	 * Returns the template body for a specified stack name.
	 *
	 * If the stack does not exist or the stack has been successfully deleted, a <code>ValidationError</code> is returned.
	 *
	 * @param string $stack_name (Required) The name or the unique identifier associated with the stack.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <php:curl_setopt()>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_template($stack_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['StackName'] = $stack_name;

		return $this->authenticate('GetTemplate', $opt, $this->hostname);
	}

	/**
	 *
	 * Deletes a specified stack. Once the call completes successfully, stack deletion starts. Deleted stacks do not show up
	 * in the DescribeStacks API if the deletion has been completed successfully.
	 *
	 * @param string $stack_name (Required) The name or the unique identifier associated with the stack.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <php:curl_setopt()>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_stack($stack_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['StackName'] = $stack_name;

		return $this->authenticate('DeleteStack', $opt, $this->hostname);
	}

	/**
	 *
	 * Returns AWS resource descriptions. If <code>StackName</code> is specified, all the associated resources that are part
	 * of the stack are returned. If <code>PhysicalResourceId</code> is specified, all the associated resources of the stack
	 * the resource belongs to are returned.
	 *
	 * You can use <code>LogicalResourceId</code> to filter the returned result. For more information about resources, the
	 * <code>LogicalResourceId</code> and <code>PhysicalResourceId</code>, go to the <a
	 * href="http://docs.amazonwebservices.com/AWSCloudFormation/latest/CFNGuide">AWS CloudFormation User Guide</a>.
	 *
	 * If the stack does not exist or the stack has been successfully deleted, a <code>ValidationError</code> is returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>StackName</code> - <code>string</code> - Optional - The name or the unique identifier associated with the stack. Default: <code>null</code> </li>
	 * 	<li><code>LogicalResourceId</code> - <code>string</code> - Optional - The logical name of the resource specified in the template. Default: <code>null</code> </li>
	 * 	<li><code>PhysicalResourceId</code> - <code>string</code> - Optional - The name or unique identifier that corresponds to a physical instance ID of a resource supported by AWS CloudFormation. For example, for an Amazon Elastic Compute Cloud (EC2) instance, <code>PhysicalResourceId</code> corresponds to the <code>InstanceId</code>. You can pass the EC2 <code>InstanceId</code> to <code>DescribeStackResources</code> to find what stack the instance belongs to and what other resources are part of the stack. Default: <code>null</code> </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <php:curl_setopt()>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_stack_resources($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeStackResources', $opt, $this->hostname);
	}
}


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Default CloudFormation Exception.
 */
class CloudFormation_Exception extends Exception {}
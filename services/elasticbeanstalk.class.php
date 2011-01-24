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
 * File: AmazonElasticBeanstalk
 * 	 *
 * 	This is the Amazon Elastic Beanstalk API Reference. This guide provides detailed information about
 * 	Amazon Elastic Beanstalk actions, data types, parameters, and errors.
 *
 * 	Amazon Elastic Beanstalk is a tool that makes it easy for you to create, deploy, and manage
 * 	scalable, fault-tolerant applications running on Amazon Web Services cloud resources.
 *
 * 	For more information about this product, go to the [Amazon Elastic
 * 	Beanstalk](http://aws.amazon.com/elasticbeanstalk/) details page. For specific information about
 * 	setting up signatures and authorization through the API, go to the [Amazon Elastic Beanstalk User
 * 	Guide](http://docs.amazonwebservices.com/elasticbeanstalk/latest/ug/).
 *
 * Version:
 * 	Mon Jan 24 14:51:25 PST 2011
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[AWS Elastic Beanstalk](http://aws.amazon.com/elasticbeanstalk/)
 * 	[AWS Elastic Beanstalk documentation](http://aws.amazon.com/documentation/elasticbeanstalk/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: ElasticBeanstalk_Exception
 * 	Default Elastic Beanstalk Exception.
 */
class ElasticBeanstalk_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonElasticBeanstalk
 * 	Container for all service-related methods.
 */
class AmazonElasticBeanstalk extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 *	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'elasticbeanstalk.us-east-1.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 *	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = 'us-east-1';


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
	 * 	$region - _string_ (Required) The region to explicitly set. Available options are <REGION_US_E1>.
	 *
	 * Returns:
	 * 	`$this`
	 */
	public function set_region($region)
	{
		$this->set_hostname('http://elasticbeanstalk.'. $region .'.amazonaws.com');
		return $this;
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonClearBox>.
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
		$this->api_version = '2010-12-01';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new Beanstalk_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new Beanstalk_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: check_dns_availability()
	 * 	Checks if the specified CNAME is available.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$cname_prefix - _string_ (Required) The prefix used when this CNAME is reserved.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function check_dns_availability($cname_prefix, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['CNAMEPrefix'] = $cname_prefix;

		return $this->authenticate('CheckDNSAvailability', $opt, $this->hostname);
	}

	/**
	 * Method: describe_configuration_options()
	 * 	Describes the configuration options that are used in a particular configuration template or
	 * 	environment, or that a specified solution stack defines. The description includes the values the
	 * 	options, their default values, and an indication of the required action on a running environment if
	 * 	an option value is changed.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ApplicationName - _string_ (Optional) The name of the application associated with the configuration template or environment. Only needed if you want to describe the configuration options associated with either the configuration template or environment.
	 *	TemplateName - _string_ (Optional) The name of the configuration template whose configuration options you want to describe.
	 *	EnvironmentName - _string_ (Optional) The name of the environment whose configuration options you want to describe.
	 *	SolutionStackName - _string_ (Optional) The name of the solution stack whose configuration options you want to describe.
	 *	Options - _ComplexList_ (Optional) If specified, restricts the descriptions to only the specified options. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `Options` subtype (documented next), or by passing an associative array with the following `Options`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	Options.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	Options.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_configuration_options($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['Options']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Options' => $opt['Options']
			), 'member'));
			unset($opt['Options']);
		}

		return $this->authenticate('DescribeConfigurationOptions', $opt, $this->hostname);
	}

	/**
	 * Method: delete_configuration_template()
	 * 	Deletes the specified configuration template. When you launch an environment using a configuration
	 * 	template, the environment gets a copy of the template. You can delete or modify the environment's
	 * 	copy of the template without affecting the running environment.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application to delete the configuration template from.
	 *	$template_name - _string_ (Required) The name of the configuration template to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_configuration_template($application_name, $template_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['TemplateName'] = $template_name;

		return $this->authenticate('DeleteConfigurationTemplate', $opt, $this->hostname);
	}

	/**
	 * Method: create_environment()
	 * 	Launches an environment for the specified application using the specified configuration.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application that contains the version to be deployed. If no application is found with this name, returns an `InvalidParameterValue` error.
	 *	$environment_name - _string_ (Required) A unique name for the deployment environment. Used in the application URL. Constraint: Must be from 4 to 23 characters in length. The name can contain only letters, numbers, and hyphens. It cannot start or end with a hyphen. Constraint: This name must be unique in your account. If the specified name already exists, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error. Default: If the CNAME parameter is not specified, the environment name becomes part of the CNAME, and therefore part of the visible URL for your application.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	VersionLabel - _string_ (Optional) The name of the application version to deploy. If the specified application has no associated application versions, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error. Default: If not specified, Amazon Elastic Beanstalk attempts to launch the most recently created application version.
	 *	TemplateName - _string_ (Optional) The name of the configuration template to use in deployment. If no configuration template is found with this name, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error. This parameter is optional. You must specify either this parameter or a `SolutionStackName`, but not both. If you specify both, Amazon Elastic Beanstalk returns an `InvalidParameterCombination` error. If you do not specify either, Amazon Elastic Beanstalk returns a `MissingRequiredParameter` error.
	 *	SolutionStackName - _string_ (Optional) This is an alternative to specifying a configuration name. If specified, Amazon Elastic Beanstalk sets the configuration values to the default values associated with the specified solution stack. This parameter is optional. You must specify either this or a `TemplateName`, but not both. If you specify both, Amazon Elastic Beanstalk returns an `InvalidParameterCombination` error. If you do not specify either, Amazon Elastic Beanstalk returns a `MissingRequiredParameter` error.
	 *	CNAMEPrefix - _string_ (Optional) If specified, the environment attempts to use this value as the prefix for the CNAME. If not specified, the environment uses the environment name.
	 *	Description - _string_ (Optional) Describes this environment.
	 *	OptionSettings - _ComplexList_ (Optional) If specified, Amazon Elastic Beanstalk sets the specified configuration options to the requested value in the configuration set for the new environment. These override the values obtained from the solution stack or the configuration template. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `OptionSettings` subtype (documented next), or by passing an associative array with the following `OptionSettings`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	OptionSettings.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionSettings.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	OptionSettings.x.Value - _string_ (Optional) The current value for the configuration option.
	 *	OptionsToRemove - _ComplexList_ (Optional) A list of custom user-defined configuration options to remove from the configuration set for this new environment. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `OptionsToRemove` subtype (documented next), or by passing an associative array with the following `OptionsToRemove`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	OptionsToRemove.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionsToRemove.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_environment($application_name, $environment_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['EnvironmentName'] = $environment_name;

		// Optional parameter
		if (isset($opt['OptionSettings']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionSettings' => $opt['OptionSettings']
			), 'member'));
			unset($opt['OptionSettings']);
		}

		// Optional parameter
		if (isset($opt['OptionsToRemove']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionsToRemove' => $opt['OptionsToRemove']
			), 'member'));
			unset($opt['OptionsToRemove']);
		}

		return $this->authenticate('CreateEnvironment', $opt, $this->hostname);
	}

	/**
	 * Method: create_storage_location()
	 * 	Creates the Amazon S3 storage location for the account. This location is used to store user log
	 * 	files.
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
	public function create_storage_location($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('CreateStorageLocation', $opt, $this->hostname);
	}

	/**
	 * Method: request_environment_info()
	 * 	Initiates a request to compile the specified type of information of the deployed environment.
	 *
	 * 	Setting the `InfoType` to `tail` compiles the last lines from the application server log files of
	 * 	every Amazon EC2 instance in your environment. Use RetrieveEnvironmentInfo to access the compiled
	 * 	information.
	 *
	 * 	Related Topics
	 *
	 * 	- RetrieveEnvironmentInfo
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$info_type - _string_ (Required) The type of information to request. [Allowed values: `tail`]
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	EnvironmentId - _string_ (Optional) The ID of the environment of the requested data. If no such environment is found, returns an `InvalidParameterValue` error.
	 *	EnvironmentName - _string_ (Optional) The name of the environment of the requested data. If no such environment is found, returns an `InvalidParameterValue` error.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function request_environment_info($info_type, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InfoType'] = $info_type;

		return $this->authenticate('RequestEnvironmentInfo', $opt, $this->hostname);
	}

	/**
	 * Method: create_application_version()
	 * 	Creates an application version for the specified application. Once you create an application version
	 * 	with a specified Amazon S3 bucket and key location, you cannot change that Amazon S3 location. If
	 * 	you change the Amazon S3 location, you receive an exception when you attempt to launch an
	 * 	environment from the application version.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application. If no application is found with this name, and `AutoCreateApplication` is `false` , returns an `InvalidParameterValue` error.
	 *	$version_label - _string_ (Required) A label identifying this version. Constraint: Must be unique per application. If an application version already exists with this label for the specified application, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Description - _string_ (Optional) Describes this version.
	 *	SourceBundle - _ComplexType_ (Optional) The Amazon S3 bucket and key that identify the location of the source bundle for this version. If data found at the Amazon S3 location exceeds the maximum allowed source bundle size, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error. Default: If not specified, Amazon Elastic Beanstalk uses a sample application. If only partially specified (for example, a bucket is provided but not the key) or if no data is found at the Amazon S3 location, Amazon Elastic Beanstalk returns an `InvalidParameterCombination` error. A ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `SourceBundle` subtype (documented next), or by passing an associative array with the following `SourceBundle`-prefixed entries as keys. See below for a list and a usage example.
	 *	SourceBundle.S3Bucket - _string_ (Optional) The Amazon S3 bucket where the data is located.
	 *	SourceBundle.S3Key - _string_ (Optional) The Amazon S3 key where the data is located.
	 *	AutoCreateApplication - _boolean_ (Optional) Determines how the system behaves if the specified application for this version does not already exist: <enumValues> <value name="true"> `true` : Automatically creates the specified application for this version if it does not already exist. </value> <value name="false"> `false` : Throws an `InvalidParameterValue` if the specified application for this version does not already exist. </value> </enumValues> `true` : Automatically creates the specified application for this release if it does not already exist. ; `false` : Throws an `InvalidParameterValue` if the specified application for this release does not already exist. . Default: `false` Valid Values: `true` | `false`
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_application_version($application_name, $version_label, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['VersionLabel'] = $version_label;

		// Optional parameter
		if (isset($opt['SourceBundle']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'SourceBundle' => $opt['SourceBundle']
			), 'member'));
			unset($opt['SourceBundle']);
		}

		return $this->authenticate('CreateApplicationVersion', $opt, $this->hostname);
	}

	/**
	 * Method: delete_application_version()
	 * 	Deletes the specified version from the specified application.
	 *
	 * 	You cannot delete an application version that is associated with a running environment.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application to delete releases from.
	 *	$version_label - _string_ (Required) The label of the version to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DeleteSourceBundle - _boolean_ (Optional) Indicates whether to delete associated source bundle from Amazon S3: `true` : An attempt is made to delete the associated Amazon S3 source bundle specified at time of creation. ; `false` : No action is taken on the Amazon S3 source bundle specified at time of creation. . Valid Values: `true` | `false`
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_application_version($application_name, $version_label, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['VersionLabel'] = $version_label;

		return $this->authenticate('DeleteApplicationVersion', $opt, $this->hostname);
	}

	/**
	 * Method: describe_application_versions()
	 * 	Returns descriptions for existing application versions.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ApplicationName - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to only include ones that are associated with the specified application.
	 *	VersionLabels - _string_|_array_ (Optional) If specified, restricts the returned descriptions to only include ones that have the specified version labels. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_application_versions($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['VersionLabels']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'VersionLabels' => (is_array($opt['VersionLabels']) ? $opt['VersionLabels'] : array($opt['VersionLabels']))
			), 'member'));
			unset($opt['VersionLabels']);
		}

		return $this->authenticate('DescribeApplicationVersions', $opt, $this->hostname);
	}

	/**
	 * Method: delete_application()
	 * 	Deletes the specified application along with all associated versions and configurations.
	 *
	 * 	You cannot delete an application that has a running environment.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_application($application_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;

		return $this->authenticate('DeleteApplication', $opt, $this->hostname);
	}

	/**
	 * Method: update_application_version()
	 * 	Updates the specified application version to have the specified properties.
	 *
	 * 	If a property (for example, `description` ) is not provided, the value remains unchanged. To clear
	 * 	properties, specify an empty string.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application associated with this version. If no application is found with this name, returns an `InvalidParameterValue` error.
	 *	$version_label - _string_ (Required) The name of the version to update. If no application version is found with this label, returns an `InvalidParameterValue` error.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Description - _string_ (Optional) A new description for this release.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_application_version($application_name, $version_label, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['VersionLabel'] = $version_label;

		return $this->authenticate('UpdateApplicationVersion', $opt, $this->hostname);
	}

	/**
	 * Method: create_application()
	 * 	Creates an application that has one configuration template named `default` and no application
	 * 	versions.
	 *
	 * 	The `default` configuration template is for a 32-bit version of the Amazon Linux operating system
	 * 	running the Tomcat 6 application container.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application. Constraint: This name must be unique within your account. If the specified name already exists, the action returns an `InvalidParameterValue` error.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Description - _string_ (Optional) Describes the application.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_application($application_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;

		return $this->authenticate('CreateApplication', $opt, $this->hostname);
	}

	/**
	 * Method: update_configuration_template()
	 * 	Updates the specified configuration template to have the specified properties or configuration
	 * 	option values. If a property (for example, `ApplicationName` ) is not provided, its value remains
	 * 	unchanged. To clear such properties, specify an empty string.
	 *
	 * 	Related Topics
	 *
	 * 	- DescribeConfigurationOptions
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application associated with the configuration template to update. If no application is found with this name, returns an `InvalidParameterValue` error.
	 *	$template_name - _string_ (Required) The name of the configuration template to update. If no configuration template is found with this name, returns an `InvalidParameterValue` error.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Description - _string_ (Optional) A new description for the configuration.
	 *	OptionSettings - _ComplexList_ (Optional) A list of configuration option settings to update with the new specified option value. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `OptionSettings` subtype (documented next), or by passing an associative array with the following `OptionSettings`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	OptionSettings.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionSettings.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	OptionSettings.x.Value - _string_ (Optional) The current value for the configuration option.
	 *	OptionsToRemove - _ComplexList_ (Optional) A list of configuration options to remove from the configuration set. Constraint: You can remove only `UserDefined` configuration options. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `OptionsToRemove` subtype (documented next), or by passing an associative array with the following `OptionsToRemove`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	OptionsToRemove.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionsToRemove.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_configuration_template($application_name, $template_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['TemplateName'] = $template_name;

		// Optional parameter
		if (isset($opt['OptionSettings']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionSettings' => $opt['OptionSettings']
			), 'member'));
			unset($opt['OptionSettings']);
		}

		// Optional parameter
		if (isset($opt['OptionsToRemove']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionsToRemove' => $opt['OptionsToRemove']
			), 'member'));
			unset($opt['OptionsToRemove']);
		}

		return $this->authenticate('UpdateConfigurationTemplate', $opt, $this->hostname);
	}

	/**
	 * Method: retrieve_environment_info()
	 * 	Retrieves the compiled information from a RequestEnvironmentInfo request.
	 *
	 * 	Related Topics
	 *
	 * 	- RequestEnvironmentInfo
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$info_type - _string_ (Required) The type of information to retrieve. [Allowed values: `tail`]
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	EnvironmentId - _string_ (Optional) The ID of the data's environment. If no such environment is found, returns an `InvalidParameterValue` error.
	 *	EnvironmentName - _string_ (Optional) The name of the data's environment. If no such environment is found, returns an `InvalidParameterValue` error.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function retrieve_environment_info($info_type, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InfoType'] = $info_type;

		return $this->authenticate('RetrieveEnvironmentInfo', $opt, $this->hostname);
	}

	/**
	 * Method: list_available_solution_stacks()
	 * 	Returns a list of the available solution stack names.
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
	public function list_available_solution_stacks($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListAvailableSolutionStacks', $opt, $this->hostname);
	}

	/**
	 * Method: update_application()
	 * 	Updates the specified application to have the specified properties. If a property (for example,
	 * 	`description`) is not provided, the value remains unchanged. To clear these properties, specify an
	 * 	empty string.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application to update. If no such application is found, returns an `InvalidParameterValue` error.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Description - _string_ (Optional) A new description for the application. Default: If not specified, Amazon Elastic Beanstalk does not update the description.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_application($application_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;

		return $this->authenticate('UpdateApplication', $opt, $this->hostname);
	}

	/**
	 * Method: describe_environments()
	 * 	Returns descriptions for existing environments.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ApplicationName - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to include only those that are associated with this application.
	 *	VersionLabel - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to include only those that are associated with this application version.
	 *	EnvironmentIds - _string_|_array_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to includes only those that have the specified IDs. Pass a string for a single value, or an indexed array for multiple values.
	 *	EnvironmentNames - _string_|_array_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to includes only those that have the specified names. Pass a string for a single value, or an indexed array for multiple values.
	 *	IncludeDeleted - _boolean_ (Optional) Indicates whether to include deleted environments: `true` : Environments that have been deleted after `IncludedDeletedBackTo` is displayed. `false` : Do not include deleted environments.
	 *	IncludedDeletedBackTo - _string_ (Optional) This parameter is conditional. If specified when `IncludeDeleted` is set to `true` , then environments deleted after this date are displayed. Accepts any value that `strtotime()` understands.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_environments($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['EnvironmentIds']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'EnvironmentIds' => (is_array($opt['EnvironmentIds']) ? $opt['EnvironmentIds'] : array($opt['EnvironmentIds']))
			), 'member'));
			unset($opt['EnvironmentIds']);
		}

		// Optional parameter
		if (isset($opt['EnvironmentNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'EnvironmentNames' => (is_array($opt['EnvironmentNames']) ? $opt['EnvironmentNames'] : array($opt['EnvironmentNames']))
			), 'member'));
			unset($opt['EnvironmentNames']);
		}

		// Optional parameter
		if (isset($opt['IncludedDeletedBackTo']))
		{
			$opt['IncludedDeletedBackTo'] = $this->util->convert_date_to_iso8601($opt['IncludedDeletedBackTo']);
		}

		return $this->authenticate('DescribeEnvironments', $opt, $this->hostname);
	}

	/**
	 * Method: describe_environment_resources()
	 * 	Returns AWS resources for this environment.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	EnvironmentId - _string_ (Optional) The ID of the environment to retrieve AWS resource usage data.
	 *	EnvironmentName - _string_ (Optional) The name of the environment to retrieve AWS resource usage data.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_environment_resources($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeEnvironmentResources', $opt, $this->hostname);
	}

	/**
	 * Method: terminate_environment()
	 * 	Terminates the specified environment.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	EnvironmentId - _string_ (Optional) The ID of the environment to terminate.
	 *	EnvironmentName - _string_ (Optional) The name of the environment to terminate.
	 *	TerminateResources - _boolean_ (Optional) Indicates whether the associated AWS resources should shut down when the environment is terminated: <enumValues> <value name="true"> `true` : (default) The user AWS resources (for example, the Auto Scaling group, load balancer, etc.) are terminated along with the environment. </value> <value name="false"> `false`: The environment is removed from the Amazon Elastic Beanstalk but the AWS resources continue to operate. </value> </enumValues> `true` : The specified environment as well as the associated AWS resources, such as Auto Scaling group and load balancer, are terminated. ; `false`: Amazon Elastic Beanstalk resource management is removed from the environment but the AWS resources continue to operate. . For more information, see the Amazon Elastic Beanstalk User Guide. Default: `true` Valid Values: `true` | `false`
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function terminate_environment($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('TerminateEnvironment', $opt, $this->hostname);
	}

	/**
	 * Method: validate_configuration_settings()
	 * 	Takes a set of configuration settings and either a configuration template or environment, and
	 * 	determines whether those values are valid. This action returns a list of messages indicating any
	 * 	errors or warnings associated with the selection of option values.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application that the configuration template or environment belongs to.
	 *	$option_settings - _ComplexList_ (Required) A list of the options and desired values to evaluate. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs which must be set by passing an associative array. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $option_settings parameter:
	 *	Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionName - _string_ (Optional) The name of the configuration option.
	 *	Value - _string_ (Optional) The current value for the configuration option.
	 *
	 * Keys for the $opt parameter:
	 *	TemplateName - _string_ (Optional) The name of the configuration template to validate the settings against. You cannot specify both this and an environment name.
	 *	EnvironmentName - _string_ (Optional) The name of the environment to validate the settings against. You cannot specify both this and a configuration template name.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function validate_configuration_settings($application_name, $option_settings, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'OptionSettings' => (is_array($option_settings) ? $option_settings : array($option_settings))
		), 'member'));

		return $this->authenticate('ValidateConfigurationSettings', $opt, $this->hostname);
	}

	/**
	 * Method: restart_app_server()
	 * 	Causes the environment to restart the application container server running on each Amazon EC2
	 * 	instance.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	EnvironmentId - _string_ (Optional) The ID of the environment to restart the server for.
	 *	EnvironmentName - _string_ (Optional) The name of the environment to restart the server for.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function restart_app_server($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('RestartAppServer', $opt, $this->hostname);
	}

	/**
	 * Method: delete_environment_configuration()
	 * 	Deletes the draft configuration associated with the running environment. Updating a running
	 * 	environment with any configuration changes creates a draft configuration set. You can get the draft
	 * 	configuration using DescribeConfigurationSettings while the update is in progress or if the update
	 * 	fails. The `DeploymentStatus` for the draft configuration indicates whether the deployment is in
	 * 	process or has failed. The draft configuration remains in existence until it is deleted with this
	 * 	action.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application the environment is associated with.
	 *	$environment_name - _string_ (Required) The name of the environment to delete the draft configuration from.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_environment_configuration($application_name, $environment_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['EnvironmentName'] = $environment_name;

		return $this->authenticate('DeleteEnvironmentConfiguration', $opt, $this->hostname);
	}

	/**
	 * Method: update_environment()
	 * 	Updates the environment description, deploys a new application version, updates the configuration
	 * 	settings to an entirely new configuration template, or updates select configuration option values in
	 * 	the running environment. Attempting to update both the release and configuration is not allowed and
	 * 	Amazon Elastic Beanstalk throws an `InvalidParameterCombination` error.
	 *
	 * 	When updating the configuration settings to a new template or individual settings, a draft
	 * 	configuration is created and DescribeConfigurationSettings for this environment returns two setting
	 * 	descriptions with different `DeploymentStatus` values.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	EnvironmentId - _string_ (Optional) The ID of the environment to update. If no environment with this ID exists, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error.
	 *	EnvironmentName - _string_ (Optional) The name of the environment to update. If no environment with this name exists, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error.
	 *	VersionLabel - _string_ (Optional) If this parameter is specified, Amazon Elastic Beanstalk deploys the named application version to the environment. If no such application version is found, returns an `InvalidParameterValue` error.
	 *	TemplateName - _string_ (Optional) If this parameter is specified, Amazon Elastic Beanstalk deploys this configuration template to the environment. If no such configuration template is found, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error.
	 *	Description - _string_ (Optional) If this parameter is specified, Amazon Elastic Beanstalk updates the description of this environment.
	 *	OptionSettings - _ComplexList_ (Optional) If specified, Amazon Elastic Beanstalk updates the configuration set associated with the running environment and sets the specified configuration options to the requested value. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `OptionSettings` subtype (documented next), or by passing an associative array with the following `OptionSettings`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	OptionSettings.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionSettings.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	OptionSettings.x.Value - _string_ (Optional) The current value for the configuration option.
	 *	OptionsToRemove - _ComplexList_ (Optional) A list of custom user-defined configuration options to remove from the configuration set for this environment. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `OptionsToRemove` subtype (documented next), or by passing an associative array with the following `OptionsToRemove`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	OptionsToRemove.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionsToRemove.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_environment($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['OptionSettings']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionSettings' => $opt['OptionSettings']
			), 'member'));
			unset($opt['OptionSettings']);
		}

		// Optional parameter
		if (isset($opt['OptionsToRemove']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionsToRemove' => $opt['OptionsToRemove']
			), 'member'));
			unset($opt['OptionsToRemove']);
		}

		return $this->authenticate('UpdateEnvironment', $opt, $this->hostname);
	}

	/**
	 * Method: create_configuration_template()
	 * 	Creates a configuration template. Templates are associated with a specific application and are used
	 * 	to deploy different versions of the application with the same configuration settings. Related Topics
	 *
	 * 	- DescribeConfigurationOptions
	 *
	 * 	- DescribeConfigurationSettings
	 *
	 * 	- ListAvailableSolutionStacks
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The name of the application to associate with this configuration template. If no application is found with this name, returns an `InvalidParameterValue` error.
	 *	$template_name - _string_ (Required) The name of the configuration template. Constraint: This name must be unique per application. Default: If a configuration template already exists with this name, Amazon Elastic Beanstalk returns an `InvalidParameterValue` error.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	SolutionStackName - _string_ (Optional) The name of the solution stack used by this configuration. The solution stack specifies the operating system, architecture, and application server for a configuration template. It determines the set of configuration options as well as the possible and default values. Use ListAvailableSolutionStacks to obtain a list of available solution stacks. Default: If the `SolutionStackName` is not specified and the source configuration parameter is blank, Amazon Elastic Beanstalk uses the default solution stack, which is a 32-bit version of the default operating system running the Tomcat 6 application container server. If not specified and the source configuration parameter is specified, Amazon Elastic Beanstalk uses the same solution stack as the source configuration template.
	 *	SourceConfiguration - _ComplexType_ (Optional) If specified, Amazon Elastic Beanstalk uses the configuration values from the specified configuration template to create a new configuration. Values specified in the `OptionSettings` parameter of this call overrides any values obtained from the `SourceConfiguration` . If no configuration template is found, returns an `InvalidParameterValue` error. Constraint: If both the solution stack name parameter and the source configuration parameters are specified, the solution stack of the source configuration template must match the specified solution stack name or else Amazon Elastic Beanstalk returns an `InvalidParameterCombination` error. A ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `SourceConfiguration` subtype (documented next), or by passing an associative array with the following `SourceConfiguration`-prefixed entries as keys. See below for a list and a usage example.
	 *	SourceConfiguration.ApplicationName - _string_ (Optional) The name of the application associated with the configuration.
	 *	SourceConfiguration.TemplateName - _string_ (Optional) The name of the configuration template.
	 *	Description - _string_ (Optional) Describes this configuration.
	 *	OptionSettings - _ComplexList_ (Optional) If specified, Amazon Elastic Beanstalk sets the specified configuration option to the requested value. The new values override the values obtained from the solution stack or the source configuration template. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `OptionSettings` subtype (documented next), or by passing an associative array with the following `OptionSettings`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	OptionSettings.x.Namespace - _string_ (Optional) A unique namespace identifying the option's associated AWS resource.
	 *	OptionSettings.x.OptionName - _string_ (Optional) The name of the configuration option.
	 *	OptionSettings.x.Value - _string_ (Optional) The current value for the configuration option.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_configuration_template($application_name, $template_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;
		$opt['TemplateName'] = $template_name;

		// Optional parameter
		if (isset($opt['SourceConfiguration']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'SourceConfiguration' => $opt['SourceConfiguration']
			), 'member'));
			unset($opt['SourceConfiguration']);
		}

		// Optional parameter
		if (isset($opt['OptionSettings']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionSettings' => $opt['OptionSettings']
			), 'member'));
			unset($opt['OptionSettings']);
		}

		return $this->authenticate('CreateConfigurationTemplate', $opt, $this->hostname);
	}

	/**
	 * Method: describe_configuration_settings()
	 * 	Returns a description of the settings for the specified configuration set, that is, either a
	 * 	configuration template or the configuration set associated with a running environment. When
	 * 	describing the settings for the configuration set associated with a running environment, it is
	 * 	possible to receive two sets of setting descriptions. One is the deployed configuration set, and the
	 * 	other is a draft configuration of an environment that is either in the process of deployment or that
	 * 	failed to deploy. Related Topics
	 *
	 * 	- DeleteEnvironmentConfiguration
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$application_name - _string_ (Required) The application for the environment or configuration template.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	TemplateName - _string_ (Optional) The name of the configuration template to describe.
	 *	EnvironmentName - _string_ (Optional) The name of the environment to describe.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_configuration_settings($application_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ApplicationName'] = $application_name;

		return $this->authenticate('DescribeConfigurationSettings', $opt, $this->hostname);
	}

	/**
	 * Method: describe_applications()
	 * 	Returns the descriptions of existing applications.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ApplicationNames - _string_|_array_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to only include those with the specified names. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_applications($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['ApplicationNames']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ApplicationNames' => (is_array($opt['ApplicationNames']) ? $opt['ApplicationNames'] : array($opt['ApplicationNames']))
			), 'member'));
			unset($opt['ApplicationNames']);
		}

		return $this->authenticate('DescribeApplications', $opt, $this->hostname);
	}

	/**
	 * Method: rebuild_environment()
	 * 	Deletes and recreates all of the AWS resources (for example: the Auto Scaling group, load balancer,
	 * 	etc.) for a specified environment and forces a restart.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	EnvironmentId - _string_ (Optional) The ID of the environment to rebuild.
	 *	EnvironmentName - _string_ (Optional) The name of the environment to rebuild.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function rebuild_environment($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('RebuildEnvironment', $opt, $this->hostname);
	}

	/**
	 * Method: describe_events()
	 * 	Returns list of event descriptions matching criteria. This action returns the most recent 1,000
	 * 	events from the specified `NextToken`.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ApplicationName - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to include only those associated with this application.
	 *	VersionLabel - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to those associated with this application version.
	 *	TemplateName - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to those that are associated with this environment configuration.
	 *	EnvironmentId - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to those associated with this environment.
	 *	EnvironmentName - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to those associated with this environment.
	 *	RequestId - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the described events to include only those associated with this request ID.
	 *	Severity - _string_ (Optional) If specified, limits the events returned from this call to include only those with the specified severity or higher. [Allowed values: `TRACE`, `DEBUG`, `INFO`, `WARN`, `ERROR`, `FATAL`]
	 *	StartTime - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to those that occur on or after this time. Accepts any value that `strtotime()` understands.
	 *	EndTime - _string_ (Optional) If specified, Amazon Elastic Beanstalk restricts the returned descriptions to those that occur up to but not including the `EndTime`. Accepts any value that `strtotime()` understands.
	 *	NextToken - _string_ (Optional) Pagination token. If specified, the events return the next batch of results.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_events($opt = null)
	{
		if (!$opt) $opt = array();

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

		return $this->authenticate('DescribeEvents', $opt, $this->hostname);
	}
}


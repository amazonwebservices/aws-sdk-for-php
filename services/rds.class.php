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
 * File: AmazonRDS
 * 	Amazon Relational Database Service (Amazon RDS) is a web service that makes it easier to set up,
 * 	operate, and scale a relational database in the cloud. It provides cost-efficient, resizable
 * 	capacity for an industry-standard relational database and manages common database administration
 * 	tasks, freeing up developers to focus on what makes their applications and businesses unique.
 *
 * 	Amazon RDS gives you access to the capabilities of a familiar MySQL database server. This means the
 * 	code, applications, and tools you already use today with your existing MySQL databases work with
 * 	Amazon RDS without modification. Amazon RDS automatically backs up your database and maintains the
 * 	database software that powers your DB Instance. Amazon RDS is flexible: you can scale your database
 * 	instance's compute resources and storage capacity to meet your application's demand. As with all
 * 	Amazon Web Services, there are no up-front investments, and you pay only for the resources you use.
 *
 * Version:
 * 	Fri Dec 03 16:26:47 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon Relational Database Service](http://aws.amazon.com/rds/)
 * 	[Amazon Relational Database Service documentation](http://aws.amazon.com/documentation/rds/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: RDS_Exception
 * 	Default RDS Exception.
 */
class RDS_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonRDS
 * 	Container for all service-related methods.
 */
class AmazonRDS extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'rds.us-east-1.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = self::DEFAULT_URL;

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'rds.us-west-1.amazonaws.com';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'rds.eu-west-1.amazonaws.com';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'rds.ap-southeast-1.amazonaws.com';


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
	 * 	Constructs a new instance of <AmazonRDS>.
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
		$this->api_version = '2010-07-28';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new RDS_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new RDS_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: delete_db_parameter_group()
	 * 	This API deletes a particular DBParameterGroup. The DBParameterGroup cannot be associated with any
	 * 	RDS instances to be deleted.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_parameter_group_name - _string_ (Required) The name of the DB Parameter Group. The specified database security group must not be associated with any DB instances.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_parameter_group($db_parameter_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;

		return $this->authenticate('DeleteDBParameterGroup', $opt, $this->hostname);
	}

	/**
	 * Method: delete_db_snapshot()
	 * 	This API is used to delete a DBSnapshot. The DBSnapshot must be in the "available" state to be
	 * 	deleted.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_snapshot_identifier - _string_ (Required) The DBSnapshot identifier.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_snapshot($db_snapshot_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSnapshotIdentifier'] = $db_snapshot_identifier;

		return $this->authenticate('DeleteDBSnapshot', $opt, $this->hostname);
	}

	/**
	 * Method: modify_db_parameter_group()
	 * 	This API modifies the parameters of a DBParameterGroup. To modify more than one parameter submit a
	 * 	list of the following: ParameterName, ParameterValue, and ApplyMethod. A maximum of 20 parameters
	 * 	can be modified in a single request.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_parameter_group_name - _string_ (Required) The name of the database parameter group.
	 *	$parameters - _ComplexList_ (Required) An array of parameter names, values, and the apply method for the parameter update. At least one parameter name, value, and apply method must be supplied; subsequent arguments are optional. A maximum of 20 parameters may be modified in a single request. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs which must be set by passing an associative array. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $parameters parameter:
	 *	ParameterName - _string_ (Optional) Specifies the name of the parameter.
	 *	ParameterValue - _string_ (Optional) Specifies the value of the parameter.
	 *	Description - _string_ (Optional) Provides a description of the parameter.
	 *	Source - _string_ (Optional) Indicates the source of the parameter value.
	 *	ApplyType - _string_ (Optional) Specifies the engine specific parameters type.
	 *	DataType - _string_ (Optional) Specifies the valid data type for the parameter.
	 *	AllowedValues - _string_ (Optional) Specifies the valid range of values for the parameter.
	 *	IsModifiable - _boolean_ (Optional) Indicates whether (`true`) or not (`false`) the parameter can be modified. Some parameters have security or operational implications that prevent them from being changed.
	 *	MinimumEngineVersion - _string_ (Optional) The earliest engine version to which the parameter can apply.
	 *	ApplyMethod - _string_ (Optional) Indicates when to apply parameter updates. [Allowed values: `immediate`, `pending-reboot`]
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function modify_db_parameter_group($db_parameter_group_name, $parameters, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'Parameters' => (is_array($parameters) ? $parameters : array($parameters))
		), 'member'));

		return $this->authenticate('ModifyDBParameterGroup', $opt, $this->hostname);
	}

	/**
	 * Method: revoke_db_security_group_ingress()
	 * 	This API revokes ingress from a DBSecurityGroup for previously authorized IP ranges or EC2 Security
	 * 	Groups. Required parameters for this API are one of CIDRIP or (EC2SecurityGroupName AND
	 * 	EC2SecurityGroupOwnerId).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_security_group_name - _string_ (Required) The name of the DB Security Group to revoke ingress from.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	CIDRIP - _string_ (Optional) The IP range to revoke access from.
	 *	EC2SecurityGroupName - _string_ (Optional) The name of the EC2 Security Group to revoke access from.
	 *	EC2SecurityGroupOwnerId - _string_ (Optional) The AWS Account Number of the owner of the security group specified in the `EC2SecurityGroupName` parameter. The AWS Access Key ID is not an acceptable value.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function revoke_db_security_group_ingress($db_security_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;

		return $this->authenticate('RevokeDBSecurityGroupIngress', $opt, $this->hostname);
	}

	/**
	 * Method: describe_db_parameters()
	 * 	This API returns the detailed parameter list for a particular DBParameterGroup.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_parameter_group_name - _string_ (Required) The name of a specific database parameter group to return details for.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Source - _string_ (Optional) The parameter types to return.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more records exist than the specified `MaxRecords` value, a marker is included in the response so that the remaining results may be retrieved.
	 *	Marker - _string_ (Optional) An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by `MaxRecords`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_parameters($db_parameter_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;

		return $this->authenticate('DescribeDBParameters', $opt, $this->hostname);
	}

	/**
	 * Method: describe_events()
	 * 	This API returns events related to DB Instances, DB Security Groups, DB Snapshots and DB Parameter
	 * 	Groups for the past 14 das. Events specific to a particular DB Instance, database security group,
	 * 	database snapshot or database parameter group can be obtained by providing the name as a parameter.
	 * 	By default, the past hour of events are returned.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	SourceIdentifier - _string_ (Optional) The identifier of the event source for which events will be returned. If not specified, then all sources are included in the response.
	 *	SourceType - _string_ (Optional) The event source to retrieve events for. If no value is specified, all events are returned. [Allowed values: `db-instance`, `db-parameter-group`, `db-security-group`, `db-snapshot`]
	 *	StartTime - _string_ (Optional) The beginning of the time interval to retrieve events for, specified in ISO 8601 format. Accepts any value that `strtotime()` understands.
	 *	EndTime - _string_ (Optional) The end of the time interval for which to retrieve events, specified in ISO 8601 format. Accepts any value that `strtotime()` understands.
	 *	Duration - _integer_ (Optional) The number of minutes to retrieve events for.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more records exist than the specified `MaxRecords` value, a marker is included in the response so that the remaining results may be retrieved.
	 *	Marker - _string_ (Optional) An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by `MaxRecords`.
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

	/**
	 * Method: create_db_security_group()
	 * 	This API creates a new database security group. Database Security groups control access to a
	 * 	database instance.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_security_group_name - _string_ (Required) The name for the DB Security Group. This value is stored as a lowercase string.
	 *	$db_security_group_description - _string_ (Required) The description for the DB Security Group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_security_group($db_security_group_name, $db_security_group_description, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;
		$opt['DBSecurityGroupDescription'] = $db_security_group_description;

		return $this->authenticate('CreateDBSecurityGroup', $opt, $this->hostname);
	}

	/**
	 * Method: describe_db_instances()
	 * 	This API is used to retrieve information about provisioned RDS instances. DescribeDBInstances
	 * 	supports pagination.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DBInstanceIdentifier - _string_ (Optional) The user-supplied instance identifier. If this parameter is specified, information from only the specific DB Instance is returned. This parameter isn't case sensitive.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more records exist than the specified `MaxRecords` value, a marker is included in the response so that the remaining results may be retrieved.
	 *	Marker - _string_ (Optional) An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by `MaxRecords` .
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_instances($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeDBInstances', $opt, $this->hostname);
	}

	/**
	 * Method: describe_db_parameter_groups()
	 * 	This API returns a list of DBParameterGroup descriptions. If a DBParameterGroupName is specified,
	 * 	the list will contain only the descriptions of the specified DBParameterGroup.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DBParameterGroupName - _string_ (Optional) The name of a specific database parameter group to return details for.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more records exist than the specified `MaxRecords` value, a marker is included in the response so that the remaining results may be retrieved.
	 *	Marker - _string_ (Optional) An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by `MaxRecords`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_parameter_groups($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeDBParameterGroups', $opt, $this->hostname);
	}

	/**
	 * Method: create_db_snapshot()
	 * 	This API is used to create a DBSnapshot. The source DBInstance must be in "available" state.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_snapshot_identifier - _string_ (Required) The identifier for the DB Snapshot.
	 *	$db_instance_identifier - _string_ (Required) The DB Instance identifier. This is the unique key that identifies a DB Instance. This parameter isn't case sensitive.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_snapshot($db_snapshot_identifier, $db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSnapshotIdentifier'] = $db_snapshot_identifier;
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;

		return $this->authenticate('CreateDBSnapshot', $opt, $this->hostname);
	}

	/**
	 * Method: describe_db_engine_versions()
	 * 	Returns a list of the available DB engines.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Engine - _string_ (Optional) The database engine to return.
	 *	EngineVersion - _string_ (Optional) The database engine version to return.
	 *	DBParameterGroupFamily - _string_ (Optional) The name of a specific database parameter group family to return details for.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more than the `MaxRecords` value is available, a marker is included in the response so that the following results can be retrieved.
	 *	Marker - _string_ (Optional) The marker provided in the previous request. If this parameter is specified, the response includes records beyond the marker only, up to `MaxRecords`.
	 *	DefaultOnly - _boolean_ (Optional) Indicates that only the default version of the specified engine or engine and major version combination is returned.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_engine_versions($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeDBEngineVersions', $opt, $this->hostname);
	}

	/**
	 * Method: reboot_db_instance()
	 * 	The RebootDBInstance API reboots a previously provisioned RDS instance. This API results in the
	 * 	application of modified DBParameterGroup parameters with ApplyStatus of pending-reboot to the RDS
	 * 	instance. This action is taken as soon as possible, and results in a momentary outage to the RDS
	 * 	instance during which the RDS instance status is set to rebooting. A DBInstance event is created
	 * 	when the reboot is completed.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_instance_identifier - _string_ (Required) The DB Instance identifier. This parameter is stored as a lowercase string.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function reboot_db_instance($db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;

		return $this->authenticate('RebootDBInstance', $opt, $this->hostname);
	}

	/**
	 * Method: authorize_db_security_group_ingress()
	 * 	This API allows for ingress to a DBSecurityGroup using one of two forms of authorization. First, EC2
	 * 	Security Groups can be added to the DBSecurityGroup if the application using the database is running
	 * 	on EC2 instances. Second, IP ranges are available if the application accessing your database is
	 * 	running on the Internet. Required parameters for this API are one of CIDR range or
	 * 	(EC2SecurityGroupName AND EC2SecurityGroupOwnerId).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_security_group_name - _string_ (Required) The name of the DB Security Group to authorize.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	CIDRIP - _string_ (Optional) The IP range to authorize.
	 *	EC2SecurityGroupName - _string_ (Optional) Name of the EC2 Security Group to authorize.
	 *	EC2SecurityGroupOwnerId - _string_ (Optional) AWS Account Number of the owner of the security group specified in the EC2SecurityGroupName parameter. The AWS Access Key ID is not an acceptable value.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function authorize_db_security_group_ingress($db_security_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;

		return $this->authenticate('AuthorizeDBSecurityGroupIngress', $opt, $this->hostname);
	}

	/**
	 * Method: restore_db_instance_to_point_in_time()
	 * 	This API creates a new RDS instance from a point-in-time system snapshot. The target database is
	 * 	created from the source database restore point with the same configuration as the original source
	 * 	database, except that the new RDS instance is created with the default security group.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$source_db_instance_identifier - _string_ (Required) The identifier of the source DB Instance from which to restore.
	 *	$target_db_instance_identifier - _string_ (Required) The name of the new database instance to be created.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	RestoreTime - _string_ (Optional) The date and time from to restore from. Accepts any value that `strtotime()` understands.
	 *	UseLatestRestorableTime - _boolean_ (Optional) Specifies whether (`true`) or not (`false`) the DB Instance is restored from the latest backup time.
	 *	DBInstanceClass - _string_ (Optional) The compute and memory capacity of the Amazon RDS DB instance.
	 *	Port - _integer_ (Optional) The port number on which the database accepts connections.
	 *	AvailabilityZone - _string_ (Optional) The EC2 Availability Zone that the database instance will be created in.
	 *	MultiAZ - _boolean_ (Optional) Specifies if the DB Instance is a Multi-AZ deployment.
	 *	AutoMinorVersionUpgrade - _boolean_ (Optional) Indicates that minor version upgrades will be applied automatically to the DB Instance during the maintenance window.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function restore_db_instance_to_point_in_time($source_db_instance_identifier, $target_db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['SourceDBInstanceIdentifier'] = $source_db_instance_identifier;
		$opt['TargetDBInstanceIdentifier'] = $target_db_instance_identifier;

		// Optional parameter
		if (isset($opt['RestoreTime']))
		{
			$opt['RestoreTime'] = $this->util->convert_date_to_iso8601($opt['RestoreTime']);
		}

		return $this->authenticate('RestoreDBInstanceToPointInTime', $opt, $this->hostname);
	}

	/**
	 * Method: describe_db_snapshots()
	 * 	This API is used to retrieve information about DBSnapshots. This API supports pagination.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DBInstanceIdentifier - _string_ (Optional) The unique identifier for the Amazon RDS DB snapshot. This value is stored as a lowercase string.
	 *	DBSnapshotIdentifier - _string_ (Optional) The DB Instance identifier. This parameter isn't case sensitive.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more records exist than the specified `MaxRecords` value, a marker is included in the response so that the remaining results may be retrieved.
	 *	Marker - _string_ (Optional) An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by `MaxRecords`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_snapshots($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeDBSnapshots', $opt, $this->hostname);
	}

	/**
	 * Method: describe_reserved_db_instances_offerings()
	 * 	Lists available reserved DB Instance offerings.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ReservedDBInstancesOfferingId - _string_ (Optional) The offering identifier filter value. Specify this parameter to show only the available offering that matches the specified reservation identifier.
	 *	DBInstanceClass - _string_ (Optional) The DB Instance class filter value. Specify this parameter to show only the available offerings matching the specified DB Instance class.
	 *	Duration - _string_ (Optional) Duration filter value, specified in years or seconds. Specify this parameter to show only reservations for this duration.
	 *	ProductDescription - _string_ (Optional) Product description filter value. Specify this parameter to show only the available offerings matching the specified product description.
	 *	MultiAZ - _boolean_ (Optional) The Multi-AZ filter value. Specify this parameter to show only the available offerings matching the specified Multi-AZ parameter.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more than the `MaxRecords` value is available, a marker is included in the response so that the following results can be retrieved.
	 *	Marker - _string_ (Optional) The marker provided in the previous request. If this parameter is specified, the response includes records beyond the marker only, up to `MaxRecords`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_reserved_db_instances_offerings($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeReservedDBInstancesOfferings', $opt, $this->hostname);
	}

	/**
	 * Method: describe_engine_default_parameters()
	 * 	This API returns the default engine and system parameter information for the specified database
	 * 	engine.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_parameter_group_family - _string_ (Required) The name of the DB Parameter Group Family.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more records exist than the specified `MaxRecords` value, a marker is included in the response so that the remaining results may be retrieved.
	 *	Marker - _string_ (Optional) An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by `MaxRecords`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_engine_default_parameters($db_parameter_group_family, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupFamily'] = $db_parameter_group_family;

		return $this->authenticate('DescribeEngineDefaultParameters', $opt, $this->hostname);
	}

	/**
	 * Method: delete_db_instance()
	 * 	The DeleteDBInstance API deletes a previously provisioned RDS instance. A successful response from
	 * 	the web service indicates the request was received correctly. If a final DBSnapshot is requested the
	 * 	status of the RDS instance will be "deleting" until the DBSnapshot is created. DescribeDBInstance is
	 * 	used to monitor the status of this operation. This cannot be canceled or reverted once submitted.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_instance_identifier - _string_ (Required) The DB Instance identifier for the DB Instance to be deleted. This parameter isn't case sensitive.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	SkipFinalSnapshot - _boolean_ (Optional)
	 *	FinalDBSnapshotIdentifier - _string_ (Optional) Determines whether a final DB Snapshot is created before the DB Instance is deleted. If `true`, no DBSnapshot is created. If `false`, a DB Snapshot is created before the DB Instance is deleted.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_instance($db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;

		return $this->authenticate('DeleteDBInstance', $opt, $this->hostname);
	}

	/**
	 * Method: describe_db_security_groups()
	 * 	This API returns a list of DBSecurityGroup descriptions. If a DBSecurityGroupName is specified, the
	 * 	list will contain only the descriptions of the specified DBSecurityGroup.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DBSecurityGroupName - _string_ (Optional) The name of the DB Security Group to return details for.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more records exist than the specified `MaxRecords` value, a marker is included in the response so that the remaining results may be retrieved.
	 *	Marker - _string_ (Optional) An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by `MaxRecords`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_security_groups($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeDBSecurityGroups', $opt, $this->hostname);
	}

	/**
	 * Method: create_db_instance()
	 * 	This API creates a new DB instance.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_instance_identifier - _string_ (Required) The DB Instance identifier. This parameter is stored as a lowercase string.
	 *	$allocated_storage - _integer_ (Required) The amount of storage (in gigabytes) to be initially allocated for the database instance.
	 *	$db_instance_class - _string_ (Required) The compute and memory capacity of the DB Instance.
	 *	$engine - _string_ (Required) The name of the database engine to be used for this instance.
	 *	$master_username - _string_ (Required) The name of master user for the client DB Instance.
	 *	$master_user_password - _string_ (Required) The password for the master DB Instance user.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DBName - _string_ (Optional) The name of the database to create when the DB Instance is created. If this parameter is not specified, no database is created in the DB Instance.
	 *	DBSecurityGroups - _string_|_array_ (Optional) A list of DB Security Groups to associate with this DB Instance. Pass a string for a single value, or an indexed array for multiple values.
	 *	AvailabilityZone - _string_ (Optional) The EC2 Availability Zone that the database instance will be created in.
	 *	PreferredMaintenanceWindow - _string_ (Optional) The weekly time range (in UTC) during which system maintenance can occur.
	 *	DBParameterGroupName - _string_ (Optional) The name of the database parameter group to associate with this DB instance. If this argument is omitted, the default DBParameterGroup for the specified engine will be used.
	 *	BackupRetentionPeriod - _integer_ (Optional) The number of days for which automated backups are retained. Setting this parameter to a positive number enables backups. Setting this parameter to 0 disables automated backups.
	 *	PreferredBackupWindow - _string_ (Optional) The daily time range during which automated backups are created if automated backups are enabled, as determined by the `BackupRetentionPeriod`.
	 *	Port - _integer_ (Optional) The port number on which the database accepts connections.
	 *	MultiAZ - _boolean_ (Optional) Specifies if the DB Instance is a Multi-AZ deployment.
	 *	EngineVersion - _string_ (Optional) The version number of the database engine to use.
	 *	AutoMinorVersionUpgrade - _boolean_ (Optional) Indicates that minor engine upgrades will be applied automatically to the DB Instance during the maintenance window.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_instance($db_instance_identifier, $allocated_storage, $db_instance_class, $engine, $master_username, $master_user_password, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		$opt['AllocatedStorage'] = $allocated_storage;
		$opt['DBInstanceClass'] = $db_instance_class;
		$opt['Engine'] = $engine;
		$opt['MasterUsername'] = $master_username;
		$opt['MasterUserPassword'] = $master_user_password;

		// Optional parameter
		if (isset($opt['DBSecurityGroups']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'DBSecurityGroups' => (is_array($opt['DBSecurityGroups']) ? $opt['DBSecurityGroups'] : array($opt['DBSecurityGroups']))
			), 'member'));
			unset($opt['DBSecurityGroups']);
		}

		return $this->authenticate('CreateDBInstance', $opt, $this->hostname);
	}

	/**
	 * Method: reset_db_parameter_group()
	 * 	This API modifies the parameters of a DBParameterGroup to the engine/system default value. To reset
	 * 	specific parameters submit a list of the following: ParameterName and ApplyMethod. To reset the
	 * 	entire DBParameterGroup specify the DBParameterGroup name and ResetAllParameters parameters. When
	 * 	resetting the entire group, dynamic parameters are updated immediately and static parameters are set
	 * 	to pending-reboot to take effect on the next MySQL reboot or RebootDBInstance request.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_parameter_group_name - _string_ (Required) The name of the DB Parameter Group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ResetAllParameters - _boolean_ (Optional) Specifies whether (`true`) or not (`false`) to reset all parameters in the DB Parameter Group to default values.
	 *	Parameters - _ComplexList_ (Optional) An array of parameter names, values, and the apply method for the parameter update. At least one parameter name, value, and apply method must be supplied; subsequent arguments are optional. A maximum of 20 parameters may be modified in a single request. A ComplexList is an indexed array of ComplexTypes. Each ComplexType is a set of key-value pairs. These pairs can be set one of two ways: by setting each individual `Parameters` subtype (documented next), or by passing an associative array with the following `Parameters`-prefixed entries as keys. In the descriptions below, `x`, `y` and `z` should be integers starting at `1`. See below for a list and a usage example.
	 *	Parameters.x.ParameterName - _string_ (Optional) Specifies the name of the parameter.
	 *	Parameters.x.ParameterValue - _string_ (Optional) Specifies the value of the parameter.
	 *	Parameters.x.Description - _string_ (Optional) Provides a description of the parameter.
	 *	Parameters.x.Source - _string_ (Optional) Indicates the source of the parameter value.
	 *	Parameters.x.ApplyType - _string_ (Optional) Specifies the engine specific parameters type.
	 *	Parameters.x.DataType - _string_ (Optional) Specifies the valid data type for the parameter.
	 *	Parameters.x.AllowedValues - _string_ (Optional) Specifies the valid range of values for the parameter.
	 *	Parameters.x.IsModifiable - _boolean_ (Optional) Indicates whether (`true`) or not (`false`) the parameter can be modified. Some parameters have security or operational implications that prevent them from being changed.
	 *	Parameters.x.MinimumEngineVersion - _string_ (Optional) The earliest engine version to which the parameter can apply.
	 *	Parameters.x.ApplyMethod - _string_ (Optional) Indicates when to apply parameter updates. [Allowed values: `immediate`, `pending-reboot`]
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function reset_db_parameter_group($db_parameter_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;

		// Optional parameter
		if (isset($opt['Parameters']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Parameters' => $opt['Parameters']
			), 'member'));
			unset($opt['Parameters']);
		}

		return $this->authenticate('ResetDBParameterGroup', $opt, $this->hostname);
	}

	/**
	 * Method: modify_db_instance()
	 * 	This API is used to change RDS Instance settings. Users call the ModifyDBInstance API to change one
	 * 	or more database configuration parameters by specifying these parameters and the new values in the
	 * 	request.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_instance_identifier - _string_ (Required) The DB Instance identifier. This value is stored as a lowercase string.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AllocatedStorage - _integer_ (Optional) The new storage capacity of the RDS instance. This change does not result in an outage and is applied during the next maintenance window unless the `ApplyImmediately` parameter is specified as `true` for this request.
	 *	DBInstanceClass - _string_ (Optional) The new compute and memory capacity of the DB Instance. Passing a value for this parameter causes an outage during the change and is applied during the next maintenance window, unless the `ApplyImmediately` parameter is specified as `true` for this request.
	 *	DBSecurityGroups - _string_|_array_ (Optional) A list of DB Security Groups to authorize on this DB Instance. This change is asynchronously applied as soon as possible. Pass a string for a single value, or an indexed array for multiple values.
	 *	ApplyImmediately - _boolean_ (Optional) Specifies whether or not the modifications in this request and any pending modifications are asynchronously applied as soon as possible, regardless of the `PreferredMaintenanceWindow` setting for the DB Instance. If this parameter is passed as `false`, changes to the DB Instance are applied on the next call to RebootDBInstance, the next maintenance reboot, or the next failure reboot, whichever occurs first.
	 *	MasterUserPassword - _string_ (Optional) The new password for the DB Instance master user. This change is asynchronously applied as soon as possible. Between the time of the request and the completion of the request, the `MasterUserPassword` element exists in the `PendingModifiedValues` element of the operation response.
	 *	DBParameterGroupName - _string_ (Optional) The name of the DB Parameter Group to apply to this DB Instance. This change is asynchronously applied as soon as possible for parameters when the _ApplyImmediately_ parameter is specified as `true` for this request.
	 *	BackupRetentionPeriod - _integer_ (Optional) The number of days to retain automated backups. Setting this parameter to a positive number enables backups. Setting this parameter to 0 disables automated backups.
	 *	PreferredBackupWindow - _string_ (Optional) The daily time range during which automated backups are created if automated backups are enabled, as determined by the `BackupRetentionPeriod`.
	 *	PreferredMaintenanceWindow - _string_ (Optional) The weekly time range (in UTC) during which system maintenance can occur, which may result in an outage. This change is made immediately. If moving this window to the current time, there must be at least 120 minutes between the current time and end of the window to ensure pending changes are applied.
	 *	MultiAZ - _boolean_ (Optional) Specifies if the DB Instance is a Multi-AZ deployment.
	 *	EngineVersion - _string_ (Optional) The version number of the database engine to upgrade to. For major version upgrades, if a non-default DB Parameter Group is currently in use, a new DB Parameter Group in the DB Parameter Group Family for the new engine version must be specified. The new DB Parameter Group can be the default for that DB Parameter Group Family.
	 *	AllowMajorVersionUpgrade - _boolean_ (Optional) The indicates that major version upgrades are allowed.
	 *	AutoMinorVersionUpgrade - _boolean_ (Optional) The indicates that minor version upgrades will be applied automatically to the DB Instance during the maintenance window.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function modify_db_instance($db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;

		// Optional parameter
		if (isset($opt['DBSecurityGroups']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'DBSecurityGroups' => (is_array($opt['DBSecurityGroups']) ? $opt['DBSecurityGroups'] : array($opt['DBSecurityGroups']))
			), 'member'));
			unset($opt['DBSecurityGroups']);
		}

		return $this->authenticate('ModifyDBInstance', $opt, $this->hostname);
	}

	/**
	 * Method: restore_db_instance_from_db_snapshot()
	 * 	This API creates a new DB Instance to an arbitrary point-in-time. Users can restore to any point in
	 * 	time before the latestRestorableTime for up to backupRetentionPeriod days. The target database is
	 * 	created from the source database with the same configuration as the original database except that
	 * 	the DB instance is created with the default DB security group.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_instance_identifier - _string_ (Required) The identifier for the DB Snapshot to restore from.
	 *	$db_snapshot_identifier - _string_ (Required) Name of the DB Instance to create from the DB Snapshot. This parameter isn't case sensitive.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DBInstanceClass - _string_ (Optional) The compute and memory capacity of the Amazon RDS DB instance.
	 *	Port - _integer_ (Optional) The port number on which the database accepts connections.
	 *	AvailabilityZone - _string_ (Optional) The EC2 Availability Zone that the database instance will be created in.
	 *	MultiAZ - _boolean_ (Optional) Specifies if the DB Instance is a Multi-AZ deployment.
	 *	AutoMinorVersionUpgrade - _boolean_ (Optional) Indicates that minor version upgrades will be applied automatically to the DB Instance during the maintenance window.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function restore_db_instance_from_db_snapshot($db_instance_identifier, $db_snapshot_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		$opt['DBSnapshotIdentifier'] = $db_snapshot_identifier;

		return $this->authenticate('RestoreDBInstanceFromDBSnapshot', $opt, $this->hostname);
	}

	/**
	 * Method: describe_reserved_db_instances()
	 * 	Returns information about reserved DB Instances for this account, or about a specified reserved DB
	 * 	Instance.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ReservedDBInstanceId - _string_ (Optional) The reserved DB Instance identifier filter value. Specify this parameter to show only the reservation that matches the specified reservation ID.
	 *	ReservedDBInstancesOfferingId - _string_ (Optional) The offering identifier filter value. Specify this parameter to show only purchased reservations matching the specified offering identifier.
	 *	DBInstanceClass - _string_ (Optional) The DB Instance class filter value. Specify this parameter to show only those reservations matching the specified DB Instances class.
	 *	Duration - _string_ (Optional) The duration filter value, specified in years or seconds. Specify this parameter to show only reservations for this duration.
	 *	ProductDescription - _string_ (Optional) The product description filter value. Specify this parameter to show only those reservations matching the specified product description.
	 *	MultiAZ - _boolean_ (Optional) The Multi-AZ filter value. Specify this parameter to show only those reservations matching the specified Multi-AZ parameter.
	 *	MaxRecords - _integer_ (Optional) The maximum number of records to include in the response. If more than the `MaxRecords` value is available, a marker is included in the response so that the following results can be retrieved.
	 *	Marker - _string_ (Optional) The marker provided in the previous request. If this parameter is specified, the response includes records beyond the marker only, up to `MaxRecords`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_reserved_db_instances($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeReservedDBInstances', $opt, $this->hostname);
	}

	/**
	 * Method: create_db_parameter_group()
	 * 	This API creates a new database parameter group.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_parameter_group_name - _string_ (Required) The name of the DB Parameter Group.
	 *	$db_parameter_group_family - _string_ (Required) The name of the DB Parameter Group Family the DB Parameter Group can be used with.
	 *	$description - _string_ (Required) The description for the DB Parameter Group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_parameter_group($db_parameter_group_name, $db_parameter_group_family, $description, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;
		$opt['DBParameterGroupFamily'] = $db_parameter_group_family;
		$opt['Description'] = $description;

		return $this->authenticate('CreateDBParameterGroup', $opt, $this->hostname);
	}

	/**
	 * Method: delete_db_security_group()
	 * 	This API deletes a database security group. Database security group must not be associated with any
	 * 	RDS Instances.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_security_group_name - _string_ (Required) The name of the database security group to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_security_group($db_security_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;

		return $this->authenticate('DeleteDBSecurityGroup', $opt, $this->hostname);
	}

	/**
	 * Method: create_db_instance_read_replica()
	 * 	Creates a DB Instance that acts as a Read Replica of a source DB Instance.
	 *
	 * 	All Read Replica DB Instances are created as Single-AZ deployments with backups disabled. All other
	 * 	DB Instance attributes (including DB Security Groups and DB Parameter Groups) are inherited from the
	 * 	source DB Instance, except as specified below.
	 *
	 * 	The source DB Instance must have backup retention enabled.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$db_instance_identifier - _string_ (Required) The DB Instance identifier of the Read Replica. This is the unique key that identifies a DB Instance. This parameter is stored as a lowercase string.
	 *	$source_db_instance_identifier - _string_ (Required) The identifier of the DB Instance that will act as the source for the Read Replica. Each DB Instance can have up to five Read Replicas.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	DBInstanceClass - _string_ (Optional) The compute and memory capacity of the Read Replica.
	 *	AvailabilityZone - _string_ (Optional) The Amazon EC2 Availability Zone that the Read Replica will be created in.
	 *	Port - _integer_ (Optional) The port number that the DB Instance uses for connections.
	 *	AutoMinorVersionUpgrade - _boolean_ (Optional) Indicates that minor engine upgrades will be applied automatically to the Read Replica during the maintenance window.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_instance_read_replica($db_instance_identifier, $source_db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		$opt['SourceDBInstanceIdentifier'] = $source_db_instance_identifier;

		return $this->authenticate('CreateDBInstanceReadReplica', $opt, $this->hostname);
	}

	/**
	 * Method: purchase_reserved_db_instances_offering()
	 * 	Purchases a reserved DB Instance offering.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$reserved_db_instances_offering_id - _string_ (Required) The ID of the Reserved DB Instance offering to purchase.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ReservedDBInstanceId - _string_ (Optional) Customer-specified identifier to track this reservation.
	 *	DBInstanceCount - _integer_ (Optional) The number of instances to reserve.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function purchase_reserved_db_instances_offering($reserved_db_instances_offering_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ReservedDBInstancesOfferingId'] = $reserved_db_instances_offering_id;

		return $this->authenticate('PurchaseReservedDBInstancesOffering', $opt, $this->hostname);
	}
}


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
 * Amazon Relational Database Service (Amazon RDS) is a web service that makes it easier to set
 * up, operate, and scale a relational database in the cloud. It provides cost-efficient,
 * resizable capacity for an industry-standard relational database and manages common database
 * administration tasks, freeing up developers to focus on what makes their applications and
 * businesses unique.
 *  
 * Amazon RDS gives you access to the capabilities of a MySQL, Oracle, or SQL Server database
 * server. This means the code, applications, and tools you already use today with your existing
 * MySQL, Oracle, or SQL Server databases work with Amazon RDS without modification. Amazon RDS
 * automatically backs up your database and maintains the database software that powers your DB
 * Instance. Amazon RDS is flexible: you can scale your database instance's compute resources and
 * storage capacity to meet your application's demand. As with all Amazon Web Services, there are
 * no up-front investments, and you pay only for the resources you use.
 *  
 * This is the <em>Amazon RDS API Reference</em>. It contains a comprehensive description of all
 * Amazon RDS Query APIs and data types. Note that this API is asynchronous and some actions may
 * require polling to determine when an action has been applied. See the parameter description to
 * determine if a change is applied immediately or on the next instance reboot or during the
 * maintenance window.
 *  
 * To get started with Amazon RDS, go to the <a href=
 * "http://docs.amazonwebservices.com/AmazonRDS/latest/GettingStartedGuide/">Amazon RDS Getting
 * Started Guide</a>. For more information on Amazon RDS concepts and usage scenarios, go to the
 * 	<a href="http://docs.amazonwebservices.com/AmazonRDS/latest/UserGuide/">Amazon RDS User
 * Guide</a>.
 *
 * @version 2013.01.14
 * @license See the included NOTICE.md file for complete information.
 * @copyright See the included NOTICE.md file for complete information.
 * @link http://aws.amazon.com/rds/ Amazon Relational Database Service
 * @link http://aws.amazon.com/rds/documentation/ Amazon Relational Database Service documentation
 */
class AmazonRDS extends CFRuntime
{
	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = 'rds.us-east-1.amazonaws.com';

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_VIRGINIA = self::REGION_US_E1;

	/**
	 * Specify the queue URL for the United States West (Northern California) Region.
	 */
	const REGION_US_W1 = 'rds.us-west-1.amazonaws.com';

	/**
	 * Specify the queue URL for the United States West (Northern California) Region.
	 */
	const REGION_CALIFORNIA = self::REGION_US_W1;

	/**
	 * Specify the queue URL for the United States West (Oregon) Region.
	 */
	const REGION_US_W2 = 'rds.us-west-2.amazonaws.com';

	/**
	 * Specify the queue URL for the United States West (Oregon) Region.
	 */
	const REGION_OREGON = self::REGION_US_W2;

	/**
	 * Specify the queue URL for the Europe West (Ireland) Region.
	 */
	const REGION_EU_W1 = 'rds.eu-west-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Europe West (Ireland) Region.
	 */
	const REGION_IRELAND = self::REGION_EU_W1;

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'rds.ap-southeast-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_SINGAPORE = self::REGION_APAC_SE1;

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_APAC_SE2 = 'rds.ap-southeast-2.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_SYDNEY = self::REGION_APAC_SE2;

	/**
	 * Specify the queue URL for the Asia Pacific Northeast (Tokyo) Region.
	 */
	const REGION_APAC_NE1 = 'rds.ap-northeast-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific Northeast (Tokyo) Region.
	 */
	const REGION_TOKYO = self::REGION_APAC_NE1;

	/**
	 * Specify the queue URL for the South America (Sao Paulo) Region.
	 */
	const REGION_SA_E1 = 'rds.sa-east-1.amazonaws.com';

	/**
	 * Specify the queue URL for the South America (Sao Paulo) Region.
	 */
	const REGION_SAO_PAULO = self::REGION_SA_E1;

	/**
	 * Specify the queue URL for the United States GovCloud Region.
	 */
	const REGION_US_GOV1 = 'rds.us-gov-west-1.amazonaws.com';

	/**
	 * Default service endpoint.
	 */
	const DEFAULT_URL = self::REGION_US_E1;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of <AmazonRDS>.
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
		$this->api_version = '2012-09-17';
		$this->hostname = self::DEFAULT_URL;
		$this->auth_class = 'AuthV4Query';

		return parent::__construct($options);
	}


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * This allows you to explicitly sets the region for the service to use.
	 *
	 * @param string $region (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_W1>, <REGION_US_W2>, <REGION_EU_W1>, <REGION_APAC_SE1>, <REGION_APAC_SE2>, <REGION_APAC_NE1>, <REGION_SA_E1>, <REGION_US_GOV1>.
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
	 * Adds metadata tags to a DB Instance. These tags can also be used with cost allocation reporting
	 * to track cost associated with a DB Instance.
	 *  
	 * For an overview on tagging DB Instances, see <a href=
	 * "http://docs.amazonwebservices.com/AmazonRDS/latest/UserGuide/Overview.Tagging.html">DB
	 * Instance Tags.</a>
	 *
	 * @param string $resource_name (Required) The DB Instance the tags will be added to.
	 * @param array $tags (Required) The tags to be assigned to the DB Instance. <ul>
	 * 	<li><code>x</code> - <code>array</code> - Optional - This represents a simple array index. <ul>
	 * 		<li><code>Key</code> - <code>string</code> - Optional - A key is the required name of the tag. The string value can be from 1 to 128 Unicode characters in length and cannot be prefixed with "aws:". The string may only contain only the set of Unicode letters, digits, white-space, '_', '.', '/', '=', '+', '-' (Java regex: "^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-]*)$").</li>
	 * 		<li><code>Value</code> - <code>string</code> - Optional - A value is the optional value of the tag. The string value can be from 1 to 256 Unicode characters in length and cannot be prefixed with "aws:". The string may only contain only the set of Unicode letters, digits, white-space, '_', '.', '/', '=', '+', '-' (Java regex: "^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-]*)$").</li>
	 * 	</ul></li>
	 * </ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_tags_to_resource($resource_name, $tags, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ResourceName'] = $resource_name;
		
		// Required list + map
		$opt = array_merge($opt, CFComplexType::map(array(
			'Tags' => (is_array($tags) ? $tags : array($tags))
		), 'member'));

		return $this->authenticate('AddTagsToResource', $opt);
	}

	/**
	 * Enables ingress to a DBSecurityGroup using one of two forms of authorization. First, EC2 or VPC
	 * Security Groups can be added to the DBSecurityGroup if the application using the database is
	 * running on EC2 or VPC instances. Second, IP ranges are available if the application accessing
	 * your database is running on the Internet. Required parameters for this API are one of CIDR
	 * range, EC2SecurityGroupId for VPC, or (EC2SecurityGroupOwnerId and either EC2SecurityGroupName
	 * or EC2SecurityGroupId for non-VPC).
	 * 
	 * <p class="note">
	 * You cannot authorize ingress from an EC2 security group in one Region to an Amazon RDS DB
	 * Instance in another. You cannot authorize ingress from a VPC security group in one VPC to an
	 * Amazon RDS DB Instance in another.
	 * </p> 
	 * For an overview of CIDR ranges, go to the <a href=
	 * "http://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing">Wikipedia Tutorial</a>.
	 *
	 * @param string $db_security_group_name (Required) The name of the DB Security Group to add authorization to.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>CIDRIP</code> - <code>string</code> - Optional - The IP range to authorize.</li>
	 * 	<li><code>EC2SecurityGroupName</code> - <code>string</code> - Optional - Name of the EC2 Security Group to authorize. For VPC DB Security Groups, <code>EC2SecurityGroupId</code> must be provided. Otherwise, EC2SecurityGroupOwnerId and either <code>EC2SecurityGroupName</code> or <code>EC2SecurityGroupId</code> must be provided.</li>
	 * 	<li><code>EC2SecurityGroupId</code> - <code>string</code> - Optional - Id of the EC2 Security Group to authorize. For VPC DB Security Groups, <code>EC2SecurityGroupId</code> must be provided. Otherwise, EC2SecurityGroupOwnerId and either <code>EC2SecurityGroupName</code> or <code>EC2SecurityGroupId</code> must be provided.</li>
	 * 	<li><code>EC2SecurityGroupOwnerId</code> - <code>string</code> - Optional - AWS Account Number of the owner of the EC2 Security Group specified in the EC2SecurityGroupName parameter. The AWS Access Key ID is not an acceptable value. For VPC DB Security Groups, <code>EC2SecurityGroupId</code> must be provided. Otherwise, EC2SecurityGroupOwnerId and either <code>EC2SecurityGroupName</code> or <code>EC2SecurityGroupId</code> must be provided.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function authorize_db_security_group_ingress($db_security_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;
		
		return $this->authenticate('AuthorizeDBSecurityGroupIngress', $opt);
	}

	/**
	 * Copies the specified DBSnapshot. The source DBSnapshot must be in the "available" state.
	 *
	 * @param string $source_db_snapshot_identifier (Required) The identifier for the source DB snapshot. Constraints:<ul><li>Must be the identifier for a valid system snapshot in the "available" state.</li></ul>Example: <code>rds:mydb-2012-04-02-00-01</code>
	 * @param string $target_db_snapshot_identifier (Required) The identifier for the copied snapshot. Constraints:<ul><li>Cannot be null, empty, or blank</li><li>Must contain from 1 to 255 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>Example: <code>my-db-snapshot</code>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function copy_db_snapshot($source_db_snapshot_identifier, $target_db_snapshot_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['SourceDBSnapshotIdentifier'] = $source_db_snapshot_identifier;
		$opt['TargetDBSnapshotIdentifier'] = $target_db_snapshot_identifier;
		
		return $this->authenticate('CopyDBSnapshot', $opt);
	}

	/**
	 * Creates a new DB instance.
	 *
	 * @param string $db_instance_identifier (Required) The DB Instance identifier. This parameter is stored as a lowercase string. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens (1 to 15 for SQL Server).</li><li>First character must be a letter.</li><li>Cannot end with a hyphen or contain two consecutive hyphens.</li></ul>Example: <code>mydbinstance</code>
	 * @param integer $allocated_storage (Required) The amount of storage (in gigabytes) to be initially allocated for the database instance. <strong>MySQL</strong> Constraints: Must be an integer from 5 to 1024. Type: Integer <strong>Oracle</strong> Constraints: Must be an integer from 10 to 1024. <strong>SQL Server</strong> Constraints: Must be an integer from 200 to 1024 (Standard Edition and Enterprise Edition) or from 30 to 1024 (Express Edition and Web Edition)
	 * @param string $db_instance_class (Required) The compute and memory capacity of the DB Instance. Valid Values: <code>db.t1.micro | db.m1.small | db.m1.medium | db.m1.large | db.m1.xlarge | db.m2.xlarge |db.m2.2xlarge | db.m2.4xlarge</code>
	 * @param string $engine (Required) The name of the database engine to be used for this instance. Valid Values: <code>MySQL</code> | <code>oracle-se1</code> | <code>oracle-se</code> | <code>oracle-ee</code> | <code>sqlserver-ee</code> | <code>sqlserver-se</code> | <code>sqlserver-ex</code> | <code>sqlserver-web</code>
	 * @param string $master_username (Required) The name of master user for the client DB Instance. <strong>MySQL</strong> Constraints:<ul><li>Must be 1 to 16 alphanumeric characters.</li><li>First character must be a letter.</li><li>Cannot be a reserved word for the chosen database engine.</li></ul>Type: String <strong>Oracle</strong> Constraints:<ul><li>Must be 1 to 30 alphanumeric characters.</li><li>First character must be a letter.</li><li>Cannot be a reserved word for the chosen database engine.</li></ul> <strong>SQL Server</strong> Constraints:<ul><li>Must be 1 to 128 alphanumeric characters.</li><li>First character must be a letter.</li><li>Cannot be a reserved word for the chosen database engine.</li></ul>
	 * @param string $master_user_password (Required) The password for the master database user. <strong>MySQL</strong> Constraints: Must contain from 8 to 41 alphanumeric characters. Type: String <strong>Oracle</strong> Constraints: Must contain from 8 to 30 alphanumeric characters. <strong>SQL Server</strong> Constraints: Must contain from 8 to 128 alphanumeric characters.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBName</code> - <code>string</code> - Optional - The meaning of this parameter differs according to the database engine you use. <strong>MySQL</strong> The name of the database to create when the DB Instance is created. If this parameter is not specified, no database is created in the DB Instance. Constraints:<ul><li>Must contain 1 to 64 alphanumeric characters</li><li>Cannot be a word reserved by the specified database engine</li></ul>Type: String <strong>Oracle</strong> The Oracle System ID (SID) of the created DB Instance. Default: <code>ORCL</code> Constraints:<ul><li>Cannot be longer than 8 characters</li></ul> <strong>SQL Server</strong> Not applicable. Must be null.</li>
	 * 	<li><code>DBSecurityGroups</code> - <code>string|array</code> - Optional - A list of DB Security Groups to associate with this DB Instance. Default: The default DB Security Group for the database engine. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>AvailabilityZone</code> - <code>string</code> - Optional - The EC2 Availability Zone that the database instance will be created in. Default: A random, system-chosen Availability Zone in the endpoint's region. Example: <code>us-east-1d</code> Constraint: The AvailabilityZone parameter cannot be specified if the MultiAZ parameter is set to <code>true</code>. The specified Availability Zone must be in the same region as the current endpoint.</li>
	 * 	<li><code>DBSubnetGroupName</code> - <code>string</code> - Optional - A DB Subnet Group to associate with this DB Instance. If there is no DB Subnet Group, then it is a non-VPC DB instance.</li>
	 * 	<li><code>PreferredMaintenanceWindow</code> - <code>string</code> - Optional - The weekly time range (in UTC) during which system maintenance can occur. Format: <code>ddd:hh24:mi-ddd:hh24:mi</code> Default: A 30-minute window selected at random from an 8-hour block of time per region, occurring on a random day of the week. The following list shows the time blocks for each region from which the default maintenance windows are assigned.<ul><li> <strong>US-East (Northern Virginia) Region:</strong> 03:00-11:00 UTC</li><li> <strong>US-West (Northern California) Region:</strong> 06:00-14:00 UTC</li><li> <strong>EU (Ireland) Region:</strong> 22:00-06:00 UTC</li><li> <strong>Asia Pacific (Singapore) Region:</strong> 14:00-22:00 UTC</li><li> <strong>Asia Pacific (Tokyo) Region:</strong> 17:00-03:00 UTC</li></ul>Valid Days: Mon, Tue, Wed, Thu, Fri, Sat, Sun Constraints: Minimum 30-minute window.</li>
	 * 	<li><code>DBParameterGroupName</code> - <code>string</code> - Optional - The name of the DB Parameter Group to associate with this DB instance. If this argument is omitted, the default DBParameterGroup for the specified engine will be used. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul></li>
	 * 	<li><code>BackupRetentionPeriod</code> - <code>integer</code> - Optional - The number of days for which automated backups are retained. Setting this parameter to a positive number enables backups. Setting this parameter to 0 disables automated backups. Default: 1 Constraints:<ul><li>Must be a value from 0 to 8</li><li>Cannot be set to 0 if the DB Instance is a master instance with read replicas</li></ul></li>
	 * 	<li><code>PreferredBackupWindow</code> - <code>string</code> - Optional - The daily time range during which automated backups are created if automated backups are enabled, using the <code>BackupRetentionPeriod</code> parameter. Default: A 30-minute window selected at random from an 8-hour block of time per region. The following list shows the time blocks for each region from which the default backup windows are assigned.<ul><li> <strong>US-East (Northern Virginia) Region:</strong> 03:00-11:00 UTC</li><li> <strong>US-West (Northern California) Region:</strong> 06:00-14:00 UTC</li><li> <strong>EU (Ireland) Region:</strong> 22:00-06:00 UTC</li><li> <strong>Asia Pacific (Singapore) Region:</strong> 14:00-22:00 UTC</li><li> <strong>Asia Pacific (Tokyo) Region:</strong> 17:00-03:00 UTC</li></ul>Constraints: Must be in the format <code>hh24:mi-hh24:mi</code>. Times should be Universal Time Coordinated (UTC). Must not conflict with the preferred maintenance window. Must be at least 30 minutes.</li>
	 * 	<li><code>Port</code> - <code>integer</code> - Optional - The port number on which the database accepts connections. <strong>MySQL</strong> Default: <code>3306</code> Valid Values: <code>1150-65535</code> Type: Integer <strong>Oracle</strong> Default: <code>1521</code> Valid Values: <code>1150-65535</code> <strong>SQL Server</strong> Default: <code>1433</code> Valid Values: <code>1150-65535</code> except for <code>1434</code> and <code>3389</code>.</li>
	 * 	<li><code>MultiAZ</code> - <code>boolean</code> - Optional - Specifies if the DB Instance is a Multi-AZ deployment. You cannot set the AvailabilityZone parameter if the MultiAZ parameter is set to true.</li>
	 * 	<li><code>EngineVersion</code> - <code>string</code> - Optional - The version number of the database engine to use. <strong>MySQL</strong> Example: <code>5.1.42</code> Type: String <strong>Oracle</strong> Example: <code>11.2.0.2.v2</code> Type: String <strong>SQL Server</strong> Example: <code>10.50.2789.0.v1</code></li>
	 * 	<li><code>AutoMinorVersionUpgrade</code> - <code>boolean</code> - Optional - Indicates that minor engine upgrades will be applied automatically to the DB Instance during the maintenance window. Default: <code>true</code></li>
	 * 	<li><code>LicenseModel</code> - <code>string</code> - Optional - License model information for this DB Instance. Valid values: <code>license-included</code> | <code>bring-your-own-license</code> | <code>general-public-license</code></li>
	 * 	<li><code>Iops</code> - <code>integer</code> - Optional - The amount of Provisioned IOPS (input/output operations per second) to be initially allocated for the DB Instance. Constraints: Must be an integer greater than 1000.</li>
	 * 	<li><code>OptionGroupName</code> - <code>string</code> - Optional - Indicates that the DB Instance should be associated with the specified option group.</li>
	 * 	<li><code>CharacterSetName</code> - <code>string</code> - Optional - For supported engines, indicates that the DB Instance should be associated with the specified CharacterSet.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
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
		
		// Optional list (non-map)
		if (isset($opt['DBSecurityGroups']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'DBSecurityGroups' => (is_array($opt['DBSecurityGroups']) ? $opt['DBSecurityGroups'] : array($opt['DBSecurityGroups']))
			), 'member'));
			unset($opt['DBSecurityGroups']);
		}

		return $this->authenticate('CreateDBInstance', $opt);
	}

	/**
	 * Creates a DB Instance that acts as a Read Replica of a source DB Instance.
	 *  
	 * All Read Replica DB Instances are created as Single-AZ deployments with backups disabled. All
	 * other DB Instance attributes (including DB Security Groups and DB Parameter Groups) are
	 * inherited from the source DB Instance, except as specified below.
	 * 
	 * <p class="important"></p> 
	 * The source DB Instance must have backup retention enabled.
	 *
	 * @param string $db_instance_identifier (Required) The DB Instance identifier of the Read Replica. This is the unique key that identifies a DB Instance. This parameter is stored as a lowercase string.
	 * @param string $source_db_instance_identifier (Required) The identifier of the DB Instance that will act as the source for the Read Replica. Each DB Instance can have up to five Read Replicas. Constraints: Must be the identifier of an existing DB Instance that is not already a Read Replica DB Instance.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBInstanceClass</code> - <code>string</code> - Optional - The compute and memory capacity of the Read Replica. Valid Values: <code>db.m1.small | db.m1.medium | db.m1.large | db.m1.xlarge | db.m2.xlarge |db.m2.2xlarge | db.m2.4xlarge</code> Default: Inherits from the source DB Instance.</li>
	 * 	<li><code>AvailabilityZone</code> - <code>string</code> - Optional - The Amazon EC2 Availability Zone that the Read Replica will be created in. Default: A random, system-chosen Availability Zone in the endpoint's region. Example: <code>us-east-1d</code></li>
	 * 	<li><code>Port</code> - <code>integer</code> - Optional - The port number that the DB Instance uses for connections. Default: Inherits from the source DB Instance Valid Values: <code>1150-65535</code></li>
	 * 	<li><code>AutoMinorVersionUpgrade</code> - <code>boolean</code> - Optional - Indicates that minor engine upgrades will be applied automatically to the Read Replica during the maintenance window. Default: Inherits from the source DB Instance</li>
	 * 	<li><code>Iops</code> - <code>integer</code> - Optional - The amount of Provisioned IOPS (input/output operations per second) to be initially allocated for the DB Instance.</li>
	 * 	<li><code>OptionGroupName</code> - <code>string</code> - Optional - </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_instance_read_replica($db_instance_identifier, $source_db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		$opt['SourceDBInstanceIdentifier'] = $source_db_instance_identifier;
		
		return $this->authenticate('CreateDBInstanceReadReplica', $opt);
	}

	/**
	 * Creates a new DB Parameter Group.
	 *  
	 * A DB Parameter Group is initially created with the default parameters for the database engine
	 * used by the DB Instance. To provide custom values for any of the parameters, you must modify
	 * the group after creating it using <em>ModifyDBParameterGroup</em>. Once you've created a DB
	 * Parameter Group, you need to associate it with your DB Instance using
	 * <em>ModifyDBInstance</em>. When you associate a new DB Parameter Group with a running DB
	 * Instance, you need to reboot the DB Instance for the new DB Parameter Group and associated
	 * settings to take effect.
	 *
	 * @param string $db_parameter_group_name (Required) The name of the DB Parameter Group. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul> <p class="note">This value is stored as a lower-case string.</p>
	 * @param string $db_parameter_group_family (Required) The DB Parameter Group Family name. A DB Parameter Group can be associated with one and only one DB Parameter Group Family, and can be applied only to a DB Instance running a database engine and engine version compatible with that DB Parameter Group Family.
	 * @param string $description (Required) The description for the DB Parameter Group.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_parameter_group($db_parameter_group_name, $db_parameter_group_family, $description, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;
		$opt['DBParameterGroupFamily'] = $db_parameter_group_family;
		$opt['Description'] = $description;
		
		return $this->authenticate('CreateDBParameterGroup', $opt);
	}

	/**
	 * Creates a new DB Security Group. DB Security Groups control access to a DB Instance.
	 *
	 * @param string $db_security_group_name (Required) The name for the DB Security Group. This value is stored as a lowercase string. Constraints: Must contain no more than 255 alphanumeric characters or hyphens. Must not be "Default". Example: <code>mysecuritygroup</code>
	 * @param string $db_security_group_description (Required) The description for the DB Security Group.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>EC2VpcId</code> - <code>string</code> - Optional - The Id of VPC. Indicates which VPC this DB Security Group should belong to. Must be specified to create a DB Security Group for a VPC; may not be specified otherwise.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_security_group($db_security_group_name, $db_security_group_description, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;
		$opt['DBSecurityGroupDescription'] = $db_security_group_description;
		
		return $this->authenticate('CreateDBSecurityGroup', $opt);
	}

	/**
	 * Creates a DBSnapshot. The source DBInstance must be in "available" state.
	 *
	 * @param string $db_snapshot_identifier (Required) The identifier for the DB Snapshot. Constraints:<ul><li>Cannot be null, empty, or blank</li><li>Must contain from 1 to 255 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>Example: <code>my-snapshot-id</code>
	 * @param string $db_instance_identifier (Required) The DB Instance identifier. This is the unique key that identifies a DB Instance. This parameter isn't case sensitive. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_snapshot($db_snapshot_identifier, $db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSnapshotIdentifier'] = $db_snapshot_identifier;
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		
		return $this->authenticate('CreateDBSnapshot', $opt);
	}

	/**
	 * Creates a new DB subnet group. DB subnet groups must contain at least one subnet in each AZ in
	 * the region.
	 *
	 * @param string $db_subnet_group_name (Required) The name for the DB Subnet Group. This value is stored as a lowercase string. Constraints: Must contain no more than 255 alphanumeric characters or hyphens. Must not be "Default". Example: <code>mySubnetgroup</code>
	 * @param string $db_subnet_group_description (Required) The description for the DB Subnet Group.
	 * @param string|array $subnet_ids (Required) The EC2 Subnet IDs for the DB Subnet Group. Pass a string for a single value, or an indexed array for multiple values.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_db_subnet_group($db_subnet_group_name, $db_subnet_group_description, $subnet_ids, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSubnetGroupName'] = $db_subnet_group_name;
		$opt['DBSubnetGroupDescription'] = $db_subnet_group_description;
		
		// Required list (non-map)
		$opt = array_merge($opt, CFComplexType::map(array(
			'SubnetIds' => (is_array($subnet_ids) ? $subnet_ids : array($subnet_ids))
		), 'member'));

		return $this->authenticate('CreateDBSubnetGroup', $opt);
	}

	/**
	 * Creates a new Option Group.
	 *
	 * @param string $option_group_name (Required) Specifies the name of the option group to be created. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>Example: <code>myOptiongroup</code>
	 * @param string $engine_name (Required) Specifies the name of the engine that this option group should be associated with.
	 * @param string $major_engine_version (Required) Specifies the major version of the engine that this option group should be associated with.
	 * @param string $option_group_description (Required) The description of the option group.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_option_group($option_group_name, $engine_name, $major_engine_version, $option_group_description, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['OptionGroupName'] = $option_group_name;
		$opt['EngineName'] = $engine_name;
		$opt['MajorEngineVersion'] = $major_engine_version;
		$opt['OptionGroupDescription'] = $option_group_description;
		
		return $this->authenticate('CreateOptionGroup', $opt);
	}

	/**
	 * The DeleteDBInstance API deletes a previously provisioned RDS instance. A successful response
	 * from the web service indicates the request was received correctly. If a final DBSnapshot is
	 * requested the status of the RDS instance will be "deleting" until the DBSnapshot is created.
	 * DescribeDBInstance is used to monitor the status of this operation. This cannot be canceled or
	 * reverted once submitted.
	 *
	 * @param string $db_instance_identifier (Required) The DB Instance identifier for the DB Instance to be deleted. This parameter isn't case sensitive. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>SkipFinalSnapshot</code> - <code>boolean</code> - Optional - Determines whether a final DB Snapshot is created before the DB Instance is deleted. If <code>true</code> is specified, no DBSnapshot is created. If false is specified, a DB Snapshot is created before the DB Instance is deleted. <p class="note">The FinalDBSnapshotIdentifier parameter must be specified if SkipFinalSnapshot is <code>false</code>.</p> Default: <code>false</code></li>
	 * 	<li><code>FinalDBSnapshotIdentifier</code> - <code>string</code> - Optional - The DBSnapshotIdentifier of the new DBSnapshot created when SkipFinalSnapshot is set to <code>false</code>. <p class="note">Specifying this parameter and also setting the SkipFinalShapshot parameter to true results in an error.</p> Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_instance($db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		
		return $this->authenticate('DeleteDBInstance', $opt);
	}

	/**
	 * Deletes a specified DBParameterGroup. The DBParameterGroup cannot be associated with any RDS
	 * instances to be deleted.
	 * 
	 * <p class="note">
	 * The specified DB Parameter Group cannot be associated with any DB Instances.
	 * </p>
	 *
	 * @param string $db_parameter_group_name (Required) The name of the DB Parameter Group. Constraints:<ul><li>Must be the name of an existing DB Parameter Group</li><li>You cannot delete a default DB Parameter Group</li><li>Cannot be associated with any DB Instances</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_parameter_group($db_parameter_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;
		
		return $this->authenticate('DeleteDBParameterGroup', $opt);
	}

	/**
	 * Deletes a DB Security Group.
	 * 
	 * <p class="note">
	 * The specified DB Security Group must not be associated with any DB Instances.
	 * </p>
	 *
	 * @param string $db_security_group_name (Required) The name of the DB Security Group to delete. <p class="note">You cannot delete the default DB Security Group.</p> Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_security_group($db_security_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;
		
		return $this->authenticate('DeleteDBSecurityGroup', $opt);
	}

	/**
	 * Deletes a DBSnapshot.
	 * 
	 * <p class="note">
	 * The DBSnapshot must be in the <code>available</code> state to be deleted.
	 * </p>
	 *
	 * @param string $db_snapshot_identifier (Required) The DBSnapshot identifier. Constraints: Must be the name of an existing DB Snapshot in the <code>available</code> state.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_snapshot($db_snapshot_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSnapshotIdentifier'] = $db_snapshot_identifier;
		
		return $this->authenticate('DeleteDBSnapshot', $opt);
	}

	/**
	 * Deletes a DB subnet group.
	 * 
	 * <p class="note">
	 * The specified database subnet group must not be associated with any DB instances.
	 * </p>
	 *
	 * @param string $db_subnet_group_name (Required) The name of the database subnet group to delete. <p class="note">You cannot delete the default subnet group.</p> Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_db_subnet_group($db_subnet_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSubnetGroupName'] = $db_subnet_group_name;
		
		return $this->authenticate('DeleteDBSubnetGroup', $opt);
	}

	/**
	 * Deletes an existing Option Group.
	 *
	 * @param string $option_group_name (Required) The name of the option group to be deleted. <p class="note">You cannot delete default Option Groups.</p>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_option_group($option_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['OptionGroupName'] = $option_group_name;
		
		return $this->authenticate('DeleteOptionGroup', $opt);
	}

	/**
	 * Returns a list of the available DB engines.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Engine</code> - <code>string</code> - Optional - The database engine to return.</li>
	 * 	<li><code>EngineVersion</code> - <code>string</code> - Optional - The database engine version to return. Example: <code>5.1.49</code></li>
	 * 	<li><code>DBParameterGroupFamily</code> - <code>string</code> - Optional - The name of a specific DB Parameter Group family to return details for. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul></li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more than the <code>MaxRecords</code> value is available, a marker is included in the response so that the following results can be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - The marker provided in the previous request. If this parameter is specified, the response includes records beyond the marker only, up to <code>MaxRecords</code>.</li>
	 * 	<li><code>DefaultOnly</code> - <code>boolean</code> - Optional - Indicates that only the default version of the specified engine or engine and major version combination is returned.</li>
	 * 	<li><code>ListSupportedCharacterSets</code> - <code>boolean</code> - Optional - If this parameter is specified, and if the requested engine supports the CharacterSetName parameter for CreateDBInstance, the response includes a list of supported character sets for each engine version.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_engine_versions($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeDBEngineVersions', $opt);
	}

	/**
	 * Returns information about provisioned RDS instances. This API supports pagination.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBInstanceIdentifier</code> - <code>string</code> - Optional - The user-supplied instance identifier. If this parameter is specified, information from only the specific DB Instance is returned. This parameter isn't case sensitive. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul></li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeDBInstances request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_instances($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeDBInstances', $opt);
	}

	/**
	 * Returns a list of DBParameterGroup descriptions. If a DBParameterGroupName is specified, the
	 * list will contain only the description of the specified DBParameterGroup.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBParameterGroupName</code> - <code>string</code> - Optional - The name of a specific DB Parameter Group to return details for. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul></li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeDBParameterGroups request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_parameter_groups($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeDBParameterGroups', $opt);
	}

	/**
	 * Returns the detailed parameter list for a particular DBParameterGroup.
	 *
	 * @param string $db_parameter_group_name (Required) The name of a specific DB Parameter Group to return details for. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Source</code> - <code>string</code> - Optional - The parameter types to return. Default: All parameter types returned Valid Values: <code>user | system | engine-default</code></li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeDBParameters request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_parameters($db_parameter_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;
		
		return $this->authenticate('DescribeDBParameters', $opt);
	}

	/**
	 * Returns a list of DBSecurityGroup descriptions. If a DBSecurityGroupName is specified, the list
	 * will contain only the descriptions of the specified DBSecurityGroup.
	 *  
	 * For an overview of CIDR ranges, go to the <a href=
	 * "http://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing">Wikipedia Tutorial</a>.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBSecurityGroupName</code> - <code>string</code> - Optional - The name of the DB Security Group to return details for.</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeDBSecurityGroups request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_security_groups($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeDBSecurityGroups', $opt);
	}

	/**
	 * Returns information about DBSnapshots. This API supports pagination.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBInstanceIdentifier</code> - <code>string</code> - Optional - A DB Instance Identifier to retrieve the list of DB Snapshots for. Cannot be used in conjunction with DBSnapshotIdentifier. This parameter isn't case sensitive. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul></li>
	 * 	<li><code>DBSnapshotIdentifier</code> - <code>string</code> - Optional - A specific DB Snapshot Identifier to describe. Cannot be used in conjunction with DBInstanceIdentifier. This value is stored as a lowercase string. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li><li>If this is the identifier of an automated snapshot, the <code>SnapshotType</code> parameter must also be specified.</li></ul></li>
	 * 	<li><code>SnapshotType</code> - <code>string</code> - Optional - An optional snapshot type for which snapshots will be returned. If not specified, the returned results will include snapshots of all types.</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeDBSnapshots request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_snapshots($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeDBSnapshots', $opt);
	}

	/**
	 * Returns a list of DBSubnetGroup descriptions. If a DBSubnetGroupName is specified, the list
	 * will contain only the descriptions of the specified DBSubnetGroup.
	 *  
	 * For an overview of CIDR ranges, go to the <a href=
	 * "http://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing">Wikipedia Tutorial</a>.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBSubnetGroupName</code> - <code>string</code> - Optional - The name of the DB Subnet Group to return details for.</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeDBSubnetGroups request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_db_subnet_groups($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeDBSubnetGroups', $opt);
	}

	/**
	 * Returns the default engine and system parameter information for the specified database engine.
	 *
	 * @param string $db_parameter_group_family (Required) The name of the DB Parameter Group Family.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeEngineDefaultParameters request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_engine_default_parameters($db_parameter_group_family, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupFamily'] = $db_parameter_group_family;
		
		return $this->authenticate('DescribeEngineDefaultParameters', $opt);
	}

	/**
	 * Returns events related to DB Instances, DB Security Groups, DB Snapshots and DB Parameter
	 * Groups for the past 14 days. Events specific to a particular DB Instance, DB Security Group,
	 * database snapshot or DB Parameter Group can be obtained by providing the name as a parameter.
	 * By default, the past hour of events are returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>SourceIdentifier</code> - <code>string</code> - Optional - The identifier of the event source for which events will be returned. If not specified, then all sources are included in the response. Constraints:<ul><li>If SourceIdentifier is supplied, SourceType must also be provided.</li><li>If the source type is DBInstance, then a DBInstanceIdentifier must be supplied.</li><li>If the source type is DBSecurityGroup, a DBSecurityGroupName must be supplied.</li><li>If the source type is DBParameterGroup, a DBParameterGroupName must be supplied.</li><li>If the source type is DBSnapshot, a DBSnapshotIdentifier must be supplied.</li><li>Cannot end with a hyphen or contain two consecutive hyphens.</li></ul></li>
	 * 	<li><code>SourceType</code> - <code>string</code> - Optional - The event source to retrieve events for. If no value is specified, all events are returned. [Allowed values: <code>db-instance</code>, <code>db-parameter-group</code>, <code>db-security-group</code>, <code>db-snapshot</code>]</li>
	 * 	<li><code>StartTime</code> - <code>string</code> - Optional - The beginning of the time interval to retrieve events for, specified in ISO 8601 format. For more information about ISO 8601, go to the <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO8601 Wikipedia page.</a> Example: 2009-07-08T18:00Z May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	<li><code>EndTime</code> - <code>string</code> - Optional - The end of the time interval for which to retrieve events, specified in ISO 8601 format. For more information about ISO 8601, go to the <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO8601 Wikipedia page.</a> Example: 2009-07-08T18:00Z May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	<li><code>Duration</code> - <code>integer</code> - Optional - The number of minutes to retrieve events for. Default: 60</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeEvents request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_events($opt = null)
	{
		if (!$opt) $opt = array();
				
		// Optional DateTime
		if (isset($opt['StartTime']))
		{
			$opt['StartTime'] = $this->util->convert_date_to_iso8601($opt['StartTime']);
		}
		
		// Optional DateTime
		if (isset($opt['EndTime']))
		{
			$opt['EndTime'] = $this->util->convert_date_to_iso8601($opt['EndTime']);
		}

		return $this->authenticate('DescribeEvents', $opt);
	}

	/**
	 * Describes all available options.
	 *
	 * @param string $engine_name (Required) A required parameter. Options available for the given Engine name will be described.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>MajorEngineVersion</code> - <code>string</code> - Optional - If specified, filters the results to include only options for the specified major engine version.</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - </li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_option_group_options($engine_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['EngineName'] = $engine_name;
		
		return $this->authenticate('DescribeOptionGroupOptions', $opt);
	}

	/**
	 * Describes the available option groups.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>OptionGroupName</code> - <code>string</code> - Optional - The name of the option group to describe. Cannot be supplied together with EngineName or MajorEngineVersion.</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - </li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - </li>
	 * 	<li><code>EngineName</code> - <code>string</code> - Optional - Filters the list of option groups to only include groups associated with a specific database engine.</li>
	 * 	<li><code>MajorEngineVersion</code> - <code>string</code> - Optional - Filters the list of option groups to only include groups associated with a specific database engine version. If specified, then EngineName must also be specified.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_option_groups($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeOptionGroups', $opt);
	}

	/**
	 * Returns a list of orderable DB Instance options for the specified engine.
	 *
	 * @param string $engine (Required) The name of the engine to retrieve DB Instance options for.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>EngineVersion</code> - <code>string</code> - Optional - The engine version filter value. Specify this parameter to show only the available offerings matching the specified engine version.</li>
	 * 	<li><code>DBInstanceClass</code> - <code>string</code> - Optional - The DB Instance class filter value. Specify this parameter to show only the available offerings matching the specified DB Instance class.</li>
	 * 	<li><code>LicenseModel</code> - <code>string</code> - Optional - The license model filter value. Specify this parameter to show only the available offerings matching the specified license model.</li>
	 * 	<li><code>Vpc</code> - <code>boolean</code> - Optional - The VPC filter value. Specify this parameter to show only the available VPC or non-VPC offerings.</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more records exist than the specified <code>MaxRecords</code> value, a marker is included in the response so that the remaining results may be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An optional marker provided in the previous DescribeOrderableDBInstanceOptions request. If this parameter is specified, the response includes only records beyond the marker, up to the value specified by <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_orderable_db_instance_options($engine, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Engine'] = $engine;
		
		return $this->authenticate('DescribeOrderableDBInstanceOptions', $opt);
	}

	/**
	 * Returns information about reserved DB Instances for this account, or about a specified reserved
	 * DB Instance.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ReservedDBInstanceId</code> - <code>string</code> - Optional - The reserved DB Instance identifier filter value. Specify this parameter to show only the reservation that matches the specified reservation ID.</li>
	 * 	<li><code>ReservedDBInstancesOfferingId</code> - <code>string</code> - Optional - The offering identifier filter value. Specify this parameter to show only purchased reservations matching the specified offering identifier.</li>
	 * 	<li><code>DBInstanceClass</code> - <code>string</code> - Optional - The DB Instance class filter value. Specify this parameter to show only those reservations matching the specified DB Instances class.</li>
	 * 	<li><code>Duration</code> - <code>string</code> - Optional - The duration filter value, specified in years or seconds. Specify this parameter to show only reservations for this duration. Valid Values: <code>1 | 3 | 31536000 | 94608000</code></li>
	 * 	<li><code>ProductDescription</code> - <code>string</code> - Optional - The product description filter value. Specify this parameter to show only those reservations matching the specified product description.</li>
	 * 	<li><code>OfferingType</code> - <code>string</code> - Optional - The offering type filter value. Specify this parameter to show only the available offerings matching the specified offering type. Valid Values: <code>"Light Utilization" | "Medium Utilization" | "Heavy Utilization"</code></li>
	 * 	<li><code>MultiAZ</code> - <code>boolean</code> - Optional - The Multi-AZ filter value. Specify this parameter to show only those reservations matching the specified Multi-AZ parameter.</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more than the <code>MaxRecords</code> value is available, a marker is included in the response so that the following results can be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - The marker provided in the previous request. If this parameter is specified, the response includes records beyond the marker only, up to <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_reserved_db_instances($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeReservedDBInstances', $opt);
	}

	/**
	 * Lists available reserved DB Instance offerings.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ReservedDBInstancesOfferingId</code> - <code>string</code> - Optional - The offering identifier filter value. Specify this parameter to show only the available offering that matches the specified reservation identifier. Example: <code>438012d3-4052-4cc7-b2e3-8d3372e0e706</code></li>
	 * 	<li><code>DBInstanceClass</code> - <code>string</code> - Optional - The DB Instance class filter value. Specify this parameter to show only the available offerings matching the specified DB Instance class.</li>
	 * 	<li><code>Duration</code> - <code>string</code> - Optional - Duration filter value, specified in years or seconds. Specify this parameter to show only reservations for this duration. Valid Values: <code>1 | 3 | 31536000 | 94608000</code></li>
	 * 	<li><code>ProductDescription</code> - <code>string</code> - Optional - Product description filter value. Specify this parameter to show only the available offerings matching the specified product description.</li>
	 * 	<li><code>OfferingType</code> - <code>string</code> - Optional - The offering type filter value. Specify this parameter to show only the available offerings matching the specified offering type. Valid Values: <code>"Light Utilization" | "Medium Utilization" | "Heavy Utilization"</code></li>
	 * 	<li><code>MultiAZ</code> - <code>boolean</code> - Optional - The Multi-AZ filter value. Specify this parameter to show only the available offerings matching the specified Multi-AZ parameter.</li>
	 * 	<li><code>MaxRecords</code> - <code>integer</code> - Optional - The maximum number of records to include in the response. If more than the <code>MaxRecords</code> value is available, a marker is included in the response so that the following results can be retrieved. Default: 100 Constraints: minimum 20, maximum 100</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - The marker provided in the previous request. If this parameter is specified, the response includes records beyond the marker only, up to <code>MaxRecords</code>.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_reserved_db_instances_offerings($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('DescribeReservedDBInstancesOfferings', $opt);
	}

	/**
	 * Lists all tags on a DB Instance.
	 *  
	 * For an overview on tagging DB Instances, see <a href=
	 * "http://docs.amazonwebservices.com/AmazonRDS/latest/UserGuide/Overview.Tagging.html">DB
	 * Instance Tags.</a>
	 *
	 * @param string $resource_name (Required) The DB Instance with tags to be listed.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_tags_for_resource($resource_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ResourceName'] = $resource_name;
		
		return $this->authenticate('ListTagsForResource', $opt);
	}

	/**
	 * Modify settings for a DB Instance. You can change one or more database configuration parameters
	 * by specifying these parameters and the new values in the request.
	 *  
	 * Some parameter changes are applied immediately while others are applied when the DB Instance is
	 * rebooted or during the next maintenance window. See the individual parameter descriptions for
	 * more information.
	 *
	 * @param string $db_instance_identifier (Required) The DB Instance identifier. This value is stored as a lowercase string. This value cannot be changed. Constraints:<ul><li>Must be the identifier for an existing DB Instance</li><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>Example:<copy>mydbinstance</copy>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>AllocatedStorage</code> - <code>integer</code> - Optional - The new storage capacity of the RDS instance. Changing this parameter does not result in an outage and the change is applied during the next maintenance window unless the <code>ApplyImmediately</code> parameter is set to <code>true</code> for this request. <strong>MySQL</strong> Default: Uses existing setting Valid Values: 5-1024 Constraints: Value supplied must be at least 10% greater than the current value. Values that are not at least 10% greater than the existing value are rounded up so that they are 10% greater than the current value. Type: Integer <strong>Oracle</strong> Default: Uses existing setting Valid Values: 10-1024 Constraints: Value supplied must be at least 10% greater than the current value. Values that are not at least 10% greater than the existing value are rounded up so that they are 10% greater than the current value. <strong>SQL Server</strong> Cannot be modified.</li>
	 * 	<li><code>DBInstanceClass</code> - <code>string</code> - Optional - The new compute and memory capacity of the DB Instance. To determine the instance classes that are available for a particular DB engine, use the <code>DescribeOrderableDBInstanceOptions</code> action. Changing this parameter results in an outage and the change is applied during the next maintenance window, unless the <code>ApplyImmediately</code> parameter is specified as <code>true</code> for this request. Default: Uses existing setting Valid Values: <code>db.t1.micro | db.m1.small | db.m1.medium | db.m1.large | db.m1.xlarge | db.m2.xlarge | db.m2.2xlarge | db.m2.4xlarge</code></li>
	 * 	<li><code>DBSecurityGroups</code> - <code>string|array</code> - Optional - A list of DB Security Groups to authorize on this DB Instance. Changing this parameter does not result in an outage and the change is asynchronously applied as soon as possible. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul> Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>ApplyImmediately</code> - <code>boolean</code> - Optional - Specifies whether or not the modifications in this request and any pending modifications are asynchronously applied as soon as possible, regardless of the <code>PreferredMaintenanceWindow</code> setting for the DB Instance. If this parameter is passed as <code>false</code>, changes to the DB Instance are applied on the next call to <code>RebootDBInstance</code>, the next maintenance reboot, or the next failure reboot, whichever occurs first. See each parameter to determine when a change is applied. Default: <code>false</code></li>
	 * 	<li><code>MasterUserPassword</code> - <code>string</code> - Optional - The new password for the DB Instance master user. Changing this parameter does not result in an outage and the change is asynchronously applied as soon as possible. Between the time of the request and the completion of the request, the <code>MasterUserPassword</code> element exists in the <code>PendingModifiedValues</code> element of the operation response. Default: Uses existing setting Constraints: Must be 8 to 41 alphanumeric characters (MySQL), 8 to 30 alphanumeric characters (Oracle), or 8 to 128 alphanumeric characters (SQL Server). <p class="note">Amazon RDS API actions never return the password, so this action provides a way to regain access to a master instance user if the password is lost.</p></li>
	 * 	<li><code>DBParameterGroupName</code> - <code>string</code> - Optional - The name of the DB Parameter Group to apply to this DB Instance. Changing this parameter does not result in an outage and the change is applied during the next maintenance window unless the <code>ApplyImmediately</code> parameter is set to <code>true</code> for this request. Default: Uses existing setting Constraints: The DB Parameter Group must be in the same DB Parameter Group family as this DB Instance.</li>
	 * 	<li><code>BackupRetentionPeriod</code> - <code>integer</code> - Optional - The number of days to retain automated backups. Setting this parameter to a positive number enables backups. Setting this parameter to 0 disables automated backups. Changing this parameter can result in an outage if you change from 0 to a non-zero value or from a non-zero value to 0. These changes are applied during the next maintenance window unless the <code>ApplyImmediately</code> parameter is set to <code>true</code> for this request. If you change the parameter from one non-zero value to another non-zero value, the change is asynchronously applied as soon as possible. Default: Uses existing setting Constraints:<ul><li>Must be a value from 0 to 8</li><li>Cannot be set to 0 if the DB Instance is a master instance with read replicas or if the DB Instance is a read replica</li></ul></li>
	 * 	<li><code>PreferredBackupWindow</code> - <code>string</code> - Optional - The daily time range during which automated backups are created if automated backups are enabled, as determined by the <code>BackupRetentionPeriod</code>. Changing this parameter does not result in an outage and the change is asynchronously applied as soon as possible. Constraints:<ul><li>Must be in the format hh24:mi-hh24:mi</li><li>Times should be Universal Time Coordinated (UTC)</li><li>Must not conflict with the preferred maintenance window</li><li>Must be at least 30 minutes</li></ul></li>
	 * 	<li><code>PreferredMaintenanceWindow</code> - <code>string</code> - Optional - The weekly time range (in UTC) during which system maintenance can occur, which may result in an outage. Changing this parameter does not result in an outage, except in the following situation, and the change is asynchronously applied as soon as possible. If there are pending actions that cause a reboot, and the maintenance window is changed to include the current time, then changing this parameter will cause a reboot of the DB Instance. If moving this window to the current time, there must be at least 30 minutes between the current time and end of the window to ensure pending changes are applied. Default: Uses existing setting Format: ddd:hh24:mi-ddd:hh24:mi Valid Days: Mon | Tue | Wed | Thu | Fri | Sat | Sun Constraints: Must be at least 30 minutes</li>
	 * 	<li><code>MultiAZ</code> - <code>boolean</code> - Optional - Specifies if the DB Instance is a Multi-AZ deployment. Changing this parameter does not result in an outage and the change is applied during the next maintenance window unless the <code>ApplyImmediately</code> parameter is set to <code>true</code> for this request. Constraints: Cannot be specified if the DB Instance is a read replica.</li>
	 * 	<li><code>EngineVersion</code> - <code>string</code> - Optional - The version number of the database engine to upgrade to. Changing this parameter results in an outage and the change is applied during the next maintenance window unless the <code>ApplyImmediately</code> parameter is set to <code>true</code> for this request. For major version upgrades, if a nondefault DB Parameter Group is currently in use, a new DB Parameter Group in the DB Parameter Group Family for the new engine version must be specified. The new DB Parameter Group can be the default for that DB Parameter Group Family. Example: <code>5.1.42</code></li>
	 * 	<li><code>AllowMajorVersionUpgrade</code> - <code>boolean</code> - Optional - Indicates that major version upgrades are allowed. Changing this parameter does not result in an outage and the change is asynchronously applied as soon as possible. Constraints: This parameter must be set to true when specifying a value for the EngineVersion parameter that is a different major version than the DB Instance's current version.</li>
	 * 	<li><code>AutoMinorVersionUpgrade</code> - <code>boolean</code> - Optional - Indicates that minor version upgrades will be applied automatically to the DB Instance during the maintenance window. Changing this parameter does not result in an outage except in the following case and the change is asynchronously applied as soon as possible. An outage will result if this parameter is set to <code>true</code> during the maintenance window, and a newer minor version is available, and RDS has enabled auto patching for that engine version.</li>
	 * 	<li><code>Iops</code> - <code>integer</code> - Optional - The new Provisioned IOPS (I/O operations per second) value for the RDS instance. Changing this parameter does not result in an outage and the change is applied during the next maintenance window unless the <code>ApplyImmediately</code> parameter is set to <code>true</code> for this request. Default: Uses existing setting Constraints: Value supplied must be at least 10% greater than the current value. Values that are not at least 10% greater than the existing value are rounded up so that they are 10% greater than the current value.</li>
	 * 	<li><code>OptionGroupName</code> - <code>string</code> - Optional - Indicates that the DB Instance should be associated with the specified option group. Changing this parameter does not result in an outage except in the following case and the change is applied during the next maintenance window unless the <code>ApplyImmediately</code> parameter is set to <code>true</code> for this request. If the parameter change results in an option group that enables OEM, this change can cause a brief (sub-second) period during which new connections are rejected but existing connections are not interrupted.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function modify_db_instance($db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		
		// Optional list (non-map)
		if (isset($opt['DBSecurityGroups']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'DBSecurityGroups' => (is_array($opt['DBSecurityGroups']) ? $opt['DBSecurityGroups'] : array($opt['DBSecurityGroups']))
			), 'member'));
			unset($opt['DBSecurityGroups']);
		}

		return $this->authenticate('ModifyDBInstance', $opt);
	}

	/**
	 * Modifies the parameters of a DBParameterGroup. To modify more than one parameter submit a list
	 * of the following: ParameterName, ParameterValue, and ApplyMethod. A maximum of 20 parameters
	 * can be modified in a single request.
	 * 
	 * <p class="note"></p> 
	 * The <code>apply-immediate</code> method can be used only for dynamic parameters; the
	 * <code>pending-reboot</code> method can be used with MySQL and Oracle DB Instances for either
	 * dynamic or static parameters. For Microsoft SQL Server DB Instances, the
	 * <code>pending-reboot</code> method can be used only for static parameters.
	 *
	 * @param string $db_parameter_group_name (Required) The name of the DB Parameter Group. Constraints:<ul><li>Must be the name of an existing DB Parameter Group</li><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $parameters (Required) An array of parameter names, values, and the apply method for the parameter update. At least one parameter name, value, and apply method must be supplied; subsequent arguments are optional. A maximum of 20 parameters may be modified in a single request. Valid Values (for the application method): <code>immediate | pending-reboot</code>  <p class="note">You can use the immediate value with dynamic parameters only. You can use the pending-reboot value for both dynamic and static parameters, and changes are applied when DB Instance reboots.</p> <ul>
	 * 	<li><code>x</code> - <code>array</code> - Optional - This represents a simple array index. <ul>
	 * 		<li><code>ParameterName</code> - <code>string</code> - Optional - Specifies the name of the parameter.</li>
	 * 		<li><code>ParameterValue</code> - <code>string</code> - Optional - Specifies the value of the parameter.</li>
	 * 		<li><code>Description</code> - <code>string</code> - Optional - Provides a description of the parameter.</li>
	 * 		<li><code>Source</code> - <code>string</code> - Optional - Indicates the source of the parameter value.</li>
	 * 		<li><code>ApplyType</code> - <code>string</code> - Optional - Specifies the engine specific parameters type.</li>
	 * 		<li><code>DataType</code> - <code>string</code> - Optional - Specifies the valid data type for the parameter.</li>
	 * 		<li><code>AllowedValues</code> - <code>string</code> - Optional - Specifies the valid range of values for the parameter.</li>
	 * 		<li><code>IsModifiable</code> - <code>boolean</code> - Optional - Indicates whether (<code>true</code>) or not (<code>false</code>) the parameter can be modified. Some parameters have security or operational implications that prevent them from being changed.</li>
	 * 		<li><code>MinimumEngineVersion</code> - <code>string</code> - Optional - The earliest engine version to which the parameter can apply.</li>
	 * 		<li><code>ApplyMethod</code> - <code>string</code> - Optional - Indicates when to apply parameter updates. [Allowed values: <code>immediate</code>, <code>pending-reboot</code>]</li>
	 * 	</ul></li>
	 * </ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function modify_db_parameter_group($db_parameter_group_name, $parameters, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;
		
		// Required list + map
		$opt = array_merge($opt, CFComplexType::map(array(
			'Parameters' => (is_array($parameters) ? $parameters : array($parameters))
		), 'member'));

		return $this->authenticate('ModifyDBParameterGroup', $opt);
	}

	/**
	 * Modifies an existing DB subnet group. DB subnet groups must contain at least one subnet in each
	 * AZ in the region.
	 *
	 * @param string $db_subnet_group_name (Required) The name for the DB Subnet Group. This value is stored as a lowercase string. Constraints: Must contain no more than 255 alphanumeric characters or hyphens. Must not be "Default". Example: <code>mySubnetgroup</code>
	 * @param string|array $subnet_ids (Required) The EC2 Subnet IDs for the DB Subnet Group. Pass a string for a single value, or an indexed array for multiple values.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBSubnetGroupDescription</code> - <code>string</code> - Optional - The description for the DB Subnet Group.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function modify_db_subnet_group($db_subnet_group_name, $subnet_ids, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSubnetGroupName'] = $db_subnet_group_name;
		
		// Required list (non-map)
		$opt = array_merge($opt, CFComplexType::map(array(
			'SubnetIds' => (is_array($subnet_ids) ? $subnet_ids : array($subnet_ids))
		), 'member'));

		return $this->authenticate('ModifyDBSubnetGroup', $opt);
	}

	/**
	 * Modifies an existing Option Group.
	 *
	 * @param string $option_group_name (Required) The name of the option group to be modified.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>OptionsToInclude</code> - <code>array</code> - Optional - Options in this list are added to the Option Group or, if already present, the specified configuration is used to update the existing configuration. <ul>
	 * 		<li><code>x</code> - <code>array</code> - Optional - This represents a simple array index. <ul>
	 * 			<li><code>OptionName</code> - <code>string</code> - Required - </li>
	 * 			<li><code>Port</code> - <code>integer</code> - Optional - </li>
	 * 			<li><code>DBSecurityGroupMemberships</code> - <code>string|array</code> - Optional -  Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>OptionsToRemove</code> - <code>string|array</code> - Optional - Options in this list are removed from the Option Group. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>ApplyImmediately</code> - <code>boolean</code> - Optional - Indicates whether the changes should be applied immediately, or during the next maintenance window for each instance associated with the Option Group.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function modify_option_group($option_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['OptionGroupName'] = $option_group_name;
		
		// Optional list + map
		if (isset($opt['OptionsToInclude']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionsToInclude' => $opt['OptionsToInclude']
			), 'member'));
			unset($opt['OptionsToInclude']);
		}
		
		// Optional list (non-map)
		if (isset($opt['OptionsToRemove']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'OptionsToRemove' => (is_array($opt['OptionsToRemove']) ? $opt['OptionsToRemove'] : array($opt['OptionsToRemove']))
			), 'member'));
			unset($opt['OptionsToRemove']);
		}

		return $this->authenticate('ModifyOptionGroup', $opt);
	}

	/**
	 * Promotes a Read Replica DB Instance to a standalone DB Instance.
	 *
	 * @param string $db_instance_identifier (Required) The DB Instance identifier. This value is stored as a lowercase string. Constraints:<ul><li>Must be the identifier for an existing Read Replica DB Instance</li><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>Example:<copy>mydbinstance</copy>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>BackupRetentionPeriod</code> - <code>integer</code> - Optional - The number of days to retain automated backups. Setting this parameter to a positive number enables backups. Setting this parameter to 0 disables automated backups. Default: 1 Constraints:<ul><li>Must be a value from 0 to 8</li></ul></li>
	 * 	<li><code>PreferredBackupWindow</code> - <code>string</code> - Optional - The daily time range during which automated backups are created if automated backups are enabled, using the <code>BackupRetentionPeriod</code> parameter. Default: A 30-minute window selected at random from an 8-hour block of time per region. The following list shows the time blocks for each region from which the default backup windows are assigned.<ul><li> <strong>US-East (Northern Virginia) Region:</strong> 03:00-11:00 UTC</li><li> <strong>US-West (Northern California) Region:</strong> 06:00-14:00 UTC</li><li> <strong>EU (Ireland) Region:</strong> 22:00-06:00 UTC</li><li> <strong>Asia Pacific (Singapore) Region:</strong> 14:00-22:00 UTC</li><li> <strong>Asia Pacific (Tokyo) Region:</strong> 17:00-03:00 UTC</li></ul>Constraints: Must be in the format <code>hh24:mi-hh24:mi</code>. Times should be Universal Time Coordinated (UTC). Must not conflict with the preferred maintenance window. Must be at least 30 minutes.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function promote_read_replica($db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		
		return $this->authenticate('PromoteReadReplica', $opt);
	}

	/**
	 * Purchases a reserved DB Instance offering.
	 *
	 * @param string $reserved_db_instances_offering_id (Required) The ID of the Reserved DB Instance offering to purchase. Example: 438012d3-4052-4cc7-b2e3-8d3372e0e706
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ReservedDBInstanceId</code> - <code>string</code> - Optional - Customer-specified identifier to track this reservation. Example: myreservationID</li>
	 * 	<li><code>DBInstanceCount</code> - <code>integer</code> - Optional - The number of instances to reserve. Default: <code>1</code></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function purchase_reserved_db_instances_offering($reserved_db_instances_offering_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ReservedDBInstancesOfferingId'] = $reserved_db_instances_offering_id;
		
		return $this->authenticate('PurchaseReservedDBInstancesOffering', $opt);
	}

	/**
	 * Reboots a previously provisioned RDS instance. This API results in the application of modified
	 * DBParameterGroup parameters with ApplyStatus of pending-reboot to the RDS instance. This action
	 * is taken as soon as possible, and results in a momentary outage to the RDS instance during
	 * which the RDS instance status is set to rebooting. If the RDS instance is configured for
	 * MultiAZ, it is possible that the reboot will be conducted through a failover. A DBInstance
	 * event is created when the reboot is completed.
	 *
	 * @param string $db_instance_identifier (Required) The DB Instance identifier. This parameter is stored as a lowercase string. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ForceFailover</code> - <code>boolean</code> - Optional - When <code>true</code>, the reboot will be conducted through a MultiAZ failover. Constraint: You cannot specify <code>true</code> if the instance is not configured for MultiAZ.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function reboot_db_instance($db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		
		return $this->authenticate('RebootDBInstance', $opt);
	}

	/**
	 * Removes metadata tags from a DB Instance.
	 *  
	 * For an overview on tagging DB Instances, see <a href=
	 * "http://docs.amazonwebservices.com/AmazonRDS/latest/UserGuide/Overview.Tagging.html">DB
	 * Instance Tags.</a>
	 *
	 * @param string $resource_name (Required) The DB Instance the tags will be removed from.
	 * @param string|array $tag_keys (Required) The tag key (name) of the tag to be removed. Pass a string for a single value, or an indexed array for multiple values.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function remove_tags_from_resource($resource_name, $tag_keys, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ResourceName'] = $resource_name;
		
		// Required list (non-map)
		$opt = array_merge($opt, CFComplexType::map(array(
			'TagKeys' => (is_array($tag_keys) ? $tag_keys : array($tag_keys))
		), 'member'));

		return $this->authenticate('RemoveTagsFromResource', $opt);
	}

	/**
	 * Modifies the parameters of a DBParameterGroup to the engine/system default value. To reset
	 * specific parameters submit a list of the following: ParameterName and ApplyMethod. To reset the
	 * entire DBParameterGroup specify the DBParameterGroup name and ResetAllParameters parameters.
	 * When resetting the entire group, dynamic parameters are updated immediately and static
	 * parameters are set to pending-reboot to take effect on the next DB instance restart or
	 * RebootDBInstance request.
	 *
	 * @param string $db_parameter_group_name (Required) The name of the DB Parameter Group. Constraints:<ul><li>Must be 1 to 255 alphanumeric characters</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ResetAllParameters</code> - <code>boolean</code> - Optional - Specifies whether (<code>true</code>) or not (<code>false</code>) to reset all parameters in the DB Parameter Group to default values. Default: <code>true</code></li>
	 * 	<li><code>Parameters</code> - <code>array</code> - Optional - An array of parameter names, values, and the apply method for the parameter update. At least one parameter name, value, and apply method must be supplied; subsequent arguments are optional. A maximum of 20 parameters may be modified in a single request. <strong>MySQL</strong> Valid Values (for Apply method): <code>immediate</code> | <code>pending-reboot</code> You can use the immediate value with dynamic parameters only. You can use the <code>pending-reboot</code> value for both dynamic and static parameters, and changes are applied when DB Instance reboots. <strong>Oracle</strong> Valid Values (for Apply method): <code>pending-reboot</code> <ul>
	 * 		<li><code>x</code> - <code>array</code> - Optional - This represents a simple array index. <ul>
	 * 			<li><code>ParameterName</code> - <code>string</code> - Optional - Specifies the name of the parameter.</li>
	 * 			<li><code>ParameterValue</code> - <code>string</code> - Optional - Specifies the value of the parameter.</li>
	 * 			<li><code>Description</code> - <code>string</code> - Optional - Provides a description of the parameter.</li>
	 * 			<li><code>Source</code> - <code>string</code> - Optional - Indicates the source of the parameter value.</li>
	 * 			<li><code>ApplyType</code> - <code>string</code> - Optional - Specifies the engine specific parameters type.</li>
	 * 			<li><code>DataType</code> - <code>string</code> - Optional - Specifies the valid data type for the parameter.</li>
	 * 			<li><code>AllowedValues</code> - <code>string</code> - Optional - Specifies the valid range of values for the parameter.</li>
	 * 			<li><code>IsModifiable</code> - <code>boolean</code> - Optional - Indicates whether (<code>true</code>) or not (<code>false</code>) the parameter can be modified. Some parameters have security or operational implications that prevent them from being changed.</li>
	 * 			<li><code>MinimumEngineVersion</code> - <code>string</code> - Optional - The earliest engine version to which the parameter can apply.</li>
	 * 			<li><code>ApplyMethod</code> - <code>string</code> - Optional - Indicates when to apply parameter updates. [Allowed values: <code>immediate</code>, <code>pending-reboot</code>]</li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function reset_db_parameter_group($db_parameter_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBParameterGroupName'] = $db_parameter_group_name;
		
		// Optional list + map
		if (isset($opt['Parameters']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Parameters' => $opt['Parameters']
			), 'member'));
			unset($opt['Parameters']);
		}

		return $this->authenticate('ResetDBParameterGroup', $opt);
	}

	/**
	 * Creates a new DB Instance from a DB snapshot. The target database is created from the source
	 * database restore point with the same configuration as the original source database, except that
	 * the new RDS instance is created with the default security group.
	 *
	 * @param string $db_instance_identifier (Required) The identifier for the DB Snapshot to restore from. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param string $db_snapshot_identifier (Required) Name of the DB Instance to create from the DB Snapshot. This parameter isn't case sensitive. Constraints:<ul><li>Must contain from 1 to 255 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>Example: <code>my-snapshot-id</code>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DBInstanceClass</code> - <code>string</code> - Optional - The compute and memory capacity of the Amazon RDS DB instance. Valid Values: <code>db.t1.micro | db.m1.small | db.m1.medium | db.m1.large | db.m1.xlarge | db.m2.2xlarge | db.m2.4xlarge</code></li>
	 * 	<li><code>Port</code> - <code>integer</code> - Optional - The port number on which the database accepts connections. Default: The same port as the original DB Instance Constraints: Value must be <code>1150-65535</code></li>
	 * 	<li><code>AvailabilityZone</code> - <code>string</code> - Optional - The EC2 Availability Zone that the database instance will be created in. Default: A random, system-chosen Availability Zone. Constraint: You cannot specify the AvailabilityZone parameter if the MultiAZ parameter is set to <code>true</code>. Example: <code>us-east-1a</code></li>
	 * 	<li><code>DBSubnetGroupName</code> - <code>string</code> - Optional - The DB Subnet Group name to use for the new instance.</li>
	 * 	<li><code>MultiAZ</code> - <code>boolean</code> - Optional - Specifies if the DB Instance is a Multi-AZ deployment. Constraint: You cannot specify the AvailabilityZone parameter if the MultiAZ parameter is set to <code>true</code>.</li>
	 * 	<li><code>AutoMinorVersionUpgrade</code> - <code>boolean</code> - Optional - Indicates that minor version upgrades will be applied automatically to the DB Instance during the maintenance window.</li>
	 * 	<li><code>LicenseModel</code> - <code>string</code> - Optional - License model information for the restored DB Instance. Default: Same as source. Valid values: <code>license-included</code> | <code>bring-your-own-license</code> | <code>general-public-license</code></li>
	 * 	<li><code>DBName</code> - <code>string</code> - Optional - The database name for the restored DB Instance. <p class="note">This parameter doesn't apply to the MySQL engine.</p></li>
	 * 	<li><code>Engine</code> - <code>string</code> - Optional - The database engine to use for the new instance. Default: The same as source Constraint: Must be compatible with the engine of the source Example: <code>oracle-ee</code></li>
	 * 	<li><code>Iops</code> - <code>integer</code> - Optional - The amount of Provisioned IOPS (input/output operations per second) to be initially allocated for the DB Instance. Constraints: Must be an integer greater than 1000.</li>
	 * 	<li><code>OptionGroupName</code> - <code>string</code> - Optional - </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function restore_db_instance_from_db_snapshot($db_instance_identifier, $db_snapshot_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBInstanceIdentifier'] = $db_instance_identifier;
		$opt['DBSnapshotIdentifier'] = $db_snapshot_identifier;
		
		return $this->authenticate('RestoreDBInstanceFromDBSnapshot', $opt);
	}

	/**
	 * Restores a DB Instance to an arbitrary point-in-time. Users can restore to any point in time
	 * before the latestRestorableTime for up to backupRetentionPeriod days. The target database is
	 * created from the source database with the same configuration as the original database except
	 * that the DB instance is created with the default DB security group.
	 *
	 * @param string $source_db_instance_identifier (Required) The identifier of the source DB Instance from which to restore. Constraints:<ul><li>Must be the identifier of an existing database instance</li><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param string $target_db_instance_identifier (Required) The name of the new database instance to be created. Constraints:<ul><li>Must contain from 1 to 63 alphanumeric characters or hyphens</li><li>First character must be a letter</li><li>Cannot end with a hyphen or contain two consecutive hyphens</li></ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>RestoreTime</code> - <code>string</code> - Optional - The date and time to restore from. Valid Values: Value must be a UTC time Constraints:<ul><li>Must be before the latest restorable time for the DB Instance</li><li>Cannot be specified if UseLatestRestorableTime parameter is true</li></ul>Example: <code>2009-09-07T23:45:00Z</code> May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	<li><code>UseLatestRestorableTime</code> - <code>boolean</code> - Optional - Specifies whether (<code>true</code>) or not (<code>false</code>) the DB Instance is restored from the latest backup time. Default: <code>false</code> Constraints: Cannot be specified if RestoreTime parameter is provided.</li>
	 * 	<li><code>DBInstanceClass</code> - <code>string</code> - Optional - The compute and memory capacity of the Amazon RDS DB instance. Valid Values: <code>db.t1.micro | db.m1.small | db.m1.medium | db.m1.large | db.m1.xlarge | db.m2.2xlarge | db.m2.4xlarge</code> Default: The same DBInstanceClass as the original DB Instance.</li>
	 * 	<li><code>Port</code> - <code>integer</code> - Optional - The port number on which the database accepts connections. Constraints: Value must be <code>1150-65535</code> Default: The same port as the original DB Instance.</li>
	 * 	<li><code>AvailabilityZone</code> - <code>string</code> - Optional - The EC2 Availability Zone that the database instance will be created in. Default: A random, system-chosen Availability Zone. Constraint: You cannot specify the AvailabilityZone parameter if the MultiAZ parameter is set to true. Example: <code>us-east-1a</code></li>
	 * 	<li><code>DBSubnetGroupName</code> - <code>string</code> - Optional - The DB subnet group name to use for the new instance.</li>
	 * 	<li><code>MultiAZ</code> - <code>boolean</code> - Optional - Specifies if the DB Instance is a Multi-AZ deployment. Constraint: You cannot specify the AvailabilityZone parameter if the MultiAZ parameter is set to <code>true</code>.</li>
	 * 	<li><code>AutoMinorVersionUpgrade</code> - <code>boolean</code> - Optional - Indicates that minor version upgrades will be applied automatically to the DB Instance during the maintenance window.</li>
	 * 	<li><code>LicenseModel</code> - <code>string</code> - Optional - License model information for the restored DB Instance. Default: Same as source. Valid values: <code>license-included</code> | <code>bring-your-own-license</code> | <code>general-public-license</code></li>
	 * 	<li><code>DBName</code> - <code>string</code> - Optional - The database name for the restored DB Instance. <p class="note">This parameter is not used for the MySQL engine.</p></li>
	 * 	<li><code>Engine</code> - <code>string</code> - Optional - The database engine to use for the new instance. Default: The same as source Constraint: Must be compatible with the engine of the source Example: <code>oracle-ee</code></li>
	 * 	<li><code>Iops</code> - <code>integer</code> - Optional - The amount of Provisioned IOPS (input/output operations per second) to be initially allocated for the DB Instance. Constraints: Must be an integer greater than 1000.</li>
	 * 	<li><code>OptionGroupName</code> - <code>string</code> - Optional - </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function restore_db_instance_to_point_in_time($source_db_instance_identifier, $target_db_instance_identifier, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['SourceDBInstanceIdentifier'] = $source_db_instance_identifier;
		$opt['TargetDBInstanceIdentifier'] = $target_db_instance_identifier;
		
		// Optional DateTime
		if (isset($opt['RestoreTime']))
		{
			$opt['RestoreTime'] = $this->util->convert_date_to_iso8601($opt['RestoreTime']);
		}

		return $this->authenticate('RestoreDBInstanceToPointInTime', $opt);
	}

	/**
	 * Revokes ingress from a DBSecurityGroup for previously authorized IP ranges or EC2 or VPC
	 * Security Groups. Required parameters for this API are one of CIDRIP, EC2SecurityGroupId for
	 * VPC, or (EC2SecurityGroupOwnerId and either EC2SecurityGroupName or EC2SecurityGroupId).
	 *
	 * @param string $db_security_group_name (Required) The name of the DB Security Group to revoke ingress from.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>CIDRIP</code> - <code>string</code> - Optional - The IP range to revoke access from. Must be a valid CIDR range. If <code>CIDRIP</code> is specified, <code>EC2SecurityGroupName</code>, <code>EC2SecurityGroupId</code> and <code>EC2SecurityGroupOwnerId</code> cannot be provided.</li>
	 * 	<li><code>EC2SecurityGroupName</code> - <code>string</code> - Optional - The name of the EC2 Security Group to revoke access from. For VPC DB Security Groups, <code>EC2SecurityGroupId</code> must be provided. Otherwise, EC2SecurityGroupOwnerId and either <code>EC2SecurityGroupName</code> or <code>EC2SecurityGroupId</code> must be provided.</li>
	 * 	<li><code>EC2SecurityGroupId</code> - <code>string</code> - Optional - The id of the EC2 Security Group to revoke access from. For VPC DB Security Groups, <code>EC2SecurityGroupId</code> must be provided. Otherwise, EC2SecurityGroupOwnerId and either <code>EC2SecurityGroupName</code> or <code>EC2SecurityGroupId</code> must be provided.</li>
	 * 	<li><code>EC2SecurityGroupOwnerId</code> - <code>string</code> - Optional - The AWS Account Number of the owner of the EC2 security group specified in the <code>EC2SecurityGroupName</code> parameter. The AWS Access Key ID is not an acceptable value. For VPC DB Security Groups, <code>EC2SecurityGroupId</code> must be provided. Otherwise, EC2SecurityGroupOwnerId and either <code>EC2SecurityGroupName</code> or <code>EC2SecurityGroupId</code> must be provided.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function revoke_db_security_group_ingress($db_security_group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DBSecurityGroupName'] = $db_security_group_name;
		
		return $this->authenticate('RevokeDBSecurityGroupIngress', $opt);
	}
}


/*%******************************************************************************************%*/
// EXCEPTIONS

class RDS_Exception extends Exception {}

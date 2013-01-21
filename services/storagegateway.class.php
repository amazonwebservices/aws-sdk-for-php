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
 * AWS Storage Gateway is a service that connects an on-premises software appliance with
 * cloud-based storage to provide seamless and secure integration between an organization's
 * on-premises IT environment and AWS's storage infrastructure. The service enables you to
 * securely upload data to the AWS cloud for cost effective backup and rapid disaster recovery.
 *  
 * Use the following links to get started using the <em>AWS Storage Gateway Service API
 * Reference</em>:
 * 
 * <ul>
 * 	<li><a href=
 * 	"http://docs.amazonwebservices.com/storagegateway/latest/userguide/AWSStorageGatewayHTTPRequestsHeaders.html">
 * 	AWS Storage Gateway Required Request Headers</a>: Describes the required headers that you
 * 	must send with every POST request to AWS Storage Gateway.</li>
 * 	<li><a href=
 * 	"http://docs.amazonwebservices.com/storagegateway/latest/userguide/AWSStorageGatewaySigningRequests.html">
 * 	Signing Requests</a>: AWS Storage Gateway requires that you authenticate every request you
 * 	send; this topic describes how sign such a request.</li>
 * 	<li><a href=
 * 	"http://docs.amazonwebservices.com/storagegateway/latest/userguide/APIErrorResponses.html">Error
 * 	Responses</a>: Provides reference information about AWS Storage Gateway errors.</li>
 * 	<li><a href=
 * 	"http://docs.amazonwebservices.com/storagegateway/latest/userguide/AWSStorageGatewayAPIOperations.html">
 * 	Operations in AWS Storage Gateway</a>: Contains detailed descriptions of all AWS Storage
 * 	Gateway operations, their request parameters, response elements, possible errors, and
 * 	examples of requests and responses.</li>
 * 	<li><a href="http://docs.amazonwebservices.com/general/latest/gr/index.html?rande.html">AWS
 * 	Storage Gateway Regions and Endpoints</a>: Provides a list of each of the regions and
 * 	endpoints available for use with AWS Storage Gateway.</li>
 * </ul>
 *
 * @version 2013.01.14
 * @license See the included NOTICE.md file for complete information.
 * @copyright See the included NOTICE.md file for complete information.
 * @link http://aws.amazon.com/storagegateway/ AWS Storage Gateway
 * @link http://aws.amazon.com/storagegateway/documentation/ AWS Storage Gateway documentation
 */
class AmazonStorageGateway extends CFRuntime
{
	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = 'storagegateway.us-east-1.amazonaws.com';

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_VIRGINIA = self::REGION_US_E1;

	/**
	 * Specify the queue URL for the United States West (Northern California) Region.
	 */
	const REGION_US_W1 = 'storagegateway.us-west-1.amazonaws.com';

	/**
	 * Specify the queue URL for the United States West (Northern California) Region.
	 */
	const REGION_CALIFORNIA = self::REGION_US_W1;

	/**
	 * Specify the queue URL for the United States West (Oregon) Region.
	 */
	const REGION_US_W2 = 'storagegateway.us-west-2.amazonaws.com';

	/**
	 * Specify the queue URL for the United States West (Oregon) Region.
	 */
	const REGION_OREGON = self::REGION_US_W2;

	/**
	 * Specify the queue URL for the Europe West (Ireland) Region.
	 */
	const REGION_EU_W1 = 'storagegateway.eu-west-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Europe West (Ireland) Region.
	 */
	const REGION_IRELAND = self::REGION_EU_W1;

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'storagegateway.ap-southeast-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_SINGAPORE = self::REGION_APAC_SE1;

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_APAC_SE2 = 'storagegateway.ap-southeast-2.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific Southeast (Singapore) Region.
	 */
	const REGION_SYDNEY = self::REGION_APAC_SE2;

	/**
	 * Specify the queue URL for the Asia Pacific Northeast (Tokyo) Region.
	 */
	const REGION_APAC_NE1 = 'storagegateway.ap-northeast-1.amazonaws.com';

	/**
	 * Specify the queue URL for the Asia Pacific Northeast (Tokyo) Region.
	 */
	const REGION_TOKYO = self::REGION_APAC_NE1;

	/**
	 * Specify the queue URL for the South America (Sao Paulo) Region.
	 */
	const REGION_SA_E1 = 'storagegateway.sa-east-1.amazonaws.com';

	/**
	 * Specify the queue URL for the South America (Sao Paulo) Region.
	 */
	const REGION_SAO_PAULO = self::REGION_SA_E1;

	/**
	 * Default service endpoint.
	 */
	const DEFAULT_URL = self::REGION_US_E1;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of <AmazonStorageGateway>.
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
		$this->api_version = '2012-06-30';
		$this->hostname = self::DEFAULT_URL;
		$this->auth_class = 'AuthV4JSON';
		$this->operation_prefix = "x-amz-target:StorageGateway_20120630.";

		parent::__construct($options);
	}


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * This allows you to explicitly sets the region for the service to use.
	 *
	 * @param string $region (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_W1>, <REGION_US_W2>, <REGION_EU_W1>, <REGION_APAC_SE1>, <REGION_APAC_SE2>, <REGION_APAC_NE1>, <REGION_SA_E1>.
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
	// CONVENIENCE METHODS

	/**
	 * Fetches the activation code for a gateway using its public URL.
	 *
	 * @param string $gateway_url (Required) The public URL to a gateway.
	 * @return string|boolean The activation key for the gateway, or false if it could not be determined.
	 */
	public function acquire_activation_code($gateway_url)
	{
		// Send a request to the gateway's URL
		$request = new RequestCore($gateway_url);
		$request->ssl_verification = false;
		$request->set_curlopts(array(CURLOPT_FOLLOWLOCATION => false));
		$response = $request->send_request(true);

		// Parse the query string from the URL in the location header to get the activation key
		if (isset($response->header['location']))
		{
			$url = $response->header['location'];
			$query = parse_url($url, PHP_URL_QUERY);
			parse_str($query, $params);

			if (isset($params['activationKey']))
			{
				return $params['activationKey'];
			}
		}

		return false;
	}

	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * This operation activates the gateway you previously deployed on your VMware host. For more
	 * information, see <a href=
	 * "http://docs.amazonwebservices.com/storagegateway/latest/userguide/DownloadAndDeploy.html">Downloading
	 * and Deploying AWS Storage Gateway VM</a>. In the activation process you specify information
	 * such as the region you want to use for storing snapshots, the time zone for scheduled snapshots
	 * and the gateway schedule window, an activation key, and a name for your gateway. The activation
	 * process also associates your gateway with your account (see
	 * <code>UpdateGatewayInformation</code>).
	 * 
	 * <p class="note">
	 * You must power on the gateway VM before you can activate your gateway.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ActivationKey</code> - <code>string</code> - Required - Your gateway activation key. You can obtain the activation key by sending an HTTP GET request with redirects enabled to the gateway IP address (port 80). The redirect URL returned in the response provides you the activation key for your gateway in the query string parameter <code>activationKey</code>. It may also include other activation-related parameters, however, these are merely defaults -- the arguments you pass to the <code>ActivateGateway</code> API call determine the actual configuration of your gateway.</li>
	 * 	<li><code>GatewayName</code> - <code>string</code> - Required - A unique identifier for your gateway. This name becomes part of the gateway Amazon Resources Name (ARN) which is what you use as an input to other operations. [Constraints: The value must be between 2 and 255 characters, and must match the following regular expression pattern: <code>^[ -\.0-\[\]-~]*[!-\.0-\[\]-~][ -\.0-\[\]-~]*$</code>]</li>
	 * 	<li><code>GatewayTimezone</code> - <code>string</code> - Required - One of the values that indicates the time zone you want to set for the gateway. The time zone is used, for example, for scheduling snapshots and your gateway's maintenance schedule. [Allowed values: <code>GMT-12:00</code>, <code>GMT-11:00</code>, <code>GMT-10:00</code>, <code>GMT-9:00</code>, <code>GMT-8:00</code>, <code>GMT-7:00</code>, <code>GMT-6:00</code>, <code>GMT-5:00</code>, <code>GMT-4:00</code>, <code>GMT-3:30</code>, <code>GMT-3:00</code>, <code>GMT-2:00</code>, <code>GMT-1:00</code>, <code>GMT</code>, <code>GMT+1:00</code>, <code>GMT+2:00</code>, <code>GMT+3:00</code>, <code>GMT+3:30</code>, <code>GMT+4:00</code>, <code>GMT+4:30</code>, <code>GMT+5:00</code>, <code>GMT+5:30</code>, <code>GMT+5:45</code>, <code>GMT+6:00</code>, <code>GMT+7:00</code>, <code>GMT+8:00</code>, <code>GMT+9:00</code>, <code>GMT+9:30</code>, <code>GMT+10:00</code>, <code>GMT+11:00</code>, <code>GMT+12:00</code>]</li>
	 * 	<li><code>GatewayRegion</code> - <code>string</code> - Required - One of the values that indicates the region where you want to store the snapshot backups. The gateway region specified must be the same region as the region in your <code>Host</code> header in the request. For more information about available regions and endpoints for AWS Storage Gateway, see <a href="http://docs.amazonwebservices.com/general/latest/gr/rande.html#sg_region">Regions and Endpoints</a> in the <strong>Amazon Web Services Glossary</strong>. <em>Valid Values</em>: "us-east-1", "us-west-1", "us-west-2", "eu-west-1", "ap-northeast-1", "ap-southest-1", "sa-east-1"</li>
	 * 	<li><code>GatewayType</code> - <code>string</code> - Optional - One of the values that defines the type of gateway to activate. The type specified is critical to all later functions of the gateway and cannot be changed after activation. The default value is <code>STORED</code>. [Allowed values: <code>STORED</code>, <code>CACHED</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function activate_gateway($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ActivateGateway', $opt);
	}

	/**
	 * This operation configures one or more gateway local disks as cache for a cached-volume gateway.
	 * This operation is supported only for the gateway-cached volume architecture (see <a href=
	 * "http://docs.amazonwebservices.com/storagegateway/latest/userguide/StorageGatewayConcepts.html">
	 * Storage Gateway Concepts</a>).
	 *  
	 * In the request, you specify the gateway Amazon Resource Name (ARN) to which you want to add
	 * cache, and one or more disk IDs that you want to configure as cache.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the ListGateways operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>DiskIds</code> - <code>string|array</code> - Required - An array of strings that identify disks that are to be configured as cache. Each string in the array must be minimum length of 1 and maximum length of 300. You can get the disk IDs from the ListLocalDisks API. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_cache($opt = null)
	{
		if (!$opt) $opt = array();
		
		// List (non-map)
		if (isset($opt['DiskIds']))
		{
			$opt['DiskIds'] = (is_array($opt['DiskIds']) ? $opt['DiskIds'] : array($opt['DiskIds']));
		}

		return $this->authenticate('AddCache', $opt);
	}

	/**
	 * This operation configures one or more gateway local disks as upload buffer for a specified
	 * gateway. This operation is supported for both the gateway-stored and gateway-cached volume
	 * architectures.
	 *  
	 * In the request, you specify the gateway Amazon Resource Name (ARN) to which you want to add
	 * upload buffer, and one or more disk IDs that you want to configure as upload buffer.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>DiskIds</code> - <code>string|array</code> - Required - An array of strings that identify disks that are to be configured as upload buffer. Each string in the array must be minimum length of 1 and maximum length of 300. You can get disk IDs from the <code>ListLocalDisks</code> API. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_upload_buffer($opt = null)
	{
		if (!$opt) $opt = array();
		
		// List (non-map)
		if (isset($opt['DiskIds']))
		{
			$opt['DiskIds'] = (is_array($opt['DiskIds']) ? $opt['DiskIds'] : array($opt['DiskIds']));
		}

		return $this->authenticate('AddUploadBuffer', $opt);
	}

	/**
	 * This operation configures one or more gateway local disks as working storage for a gateway.
	 * This operation is supported only for the gateway-stored volume architecture.
	 * 
	 * <p class="note"></p> 
	 * Working storage is also referred to as upload buffer. You can also use the
	 * <code>AddUploadBuffer</code> operation to add upload buffer to a stored-volume gateway.
	 *  
	 * In the request, you specify the gateway Amazon Resource Name (ARN) to which you want to add
	 * working storage, and one or more disk IDs that you want to configure as working storage.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>DiskIds</code> - <code>string|array</code> - Required - An array of strings that identify disks that are to be configured as working storage. Each string have a minimum length of 1 and maximum length of 300. You can get the disk IDs from the <code>ListLocalDisks</code> API. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_working_storage($opt = null)
	{
		if (!$opt) $opt = array();
		
		// List (non-map)
		if (isset($opt['DiskIds']))
		{
			$opt['DiskIds'] = (is_array($opt['DiskIds']) ? $opt['DiskIds'] : array($opt['DiskIds']));
		}

		return $this->authenticate('AddWorkingStorage', $opt);
	}

	/**
	 * This operation creates a cached volume on a specified cached gateway. This operation is
	 * supported only for the gateway-cached volume architecture.
	 * 
	 * <p class="note">
	 * Cache storage must be allocated to the gateway before you can create a cached volume. Use the
	 * <code>AddCache</code> operation to add cache storage to a gateway.
	 * </p> 
	 * In the request, you must specify the gateway, size of the volume in bytes, the iSCSI target
	 * name, an IP address on which to expose the target, and a unique client token. In response, AWS
	 * Storage Gateway creates the volume and returns information about it such as the volume Amazon
	 * Resource Name (ARN), its size, and the iSCSI target ARN that initiators can use to connect to
	 * the volume target.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>VolumeSizeInBytes</code> - <code>long</code> - Required - The size of the cached volume.</li>
	 * 	<li><code>SnapshotId</code> - <code>string</code> - Optional - The snapshot ID (e.g., "snap-1122aabb") of the snapshot to restore as the new stored volume. Specify this field if you want to create the iSCSI cached volume from a snapshot; otherwise, do not include this field. To list snapshots for your account, use <a href="http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DescribeSnapshots.html">DescribeSnapshots</a> in Amazon Elastic Compute Cloud API Reference. [Constraints: The value must match the following regular expression pattern: <code>\Asnap-[0-9a-fA-F]{8}\z</code>]</li>
	 * 	<li><code>TargetName</code> - <code>string</code> - Required - The name of the iSCSI target used by initiators to connect to the target and as a suffix for the target ARN. For example, specifying <strong>TargetName</strong> as <em>myvolume</em> results in the target ARN of <em>arn:aws:storagegateway:us-east-1:111122223333:gateway/mygateway/target/iqn.1997-05.com.amazon:myvolume</em>. The target name must be unique across all volumes of a gateway. [Constraints: The value must be between 1 and 200 characters, and must match the following regular expression pattern: <code>^[-\.;a-z0-9]+$</code>]</li>
	 * 	<li><code>NetworkInterfaceId</code> - <code>string</code> - Required - The network interface of the gateway on which to expose the iSCSI target. Only IPv4 addresses are accepted. Use the <code>DescribeGatewayInformation</code> operation to get a list of the network interfaces available on the gateway. [Constraints: The value must match the following regular expression pattern: <code>\A(25[0-5]|2[0-4]\d|[0-1]?\d?\d)(\.(25[0-5]|2[0-4]\d|[0-1]?\d?\d)){3}\z</code>]</li>
	 * 	<li><code>ClientToken</code> - <code>string</code> - Required - A unique identifying string for the cached volume.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_cached_iscsi_volume($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CreateCachediSCSIVolume', $opt);
	}

	/**
	 * This operation initiates a snapshot of a volume.
	 *  
	 * AWS Storage Gateway provides the ability to back up point-in-time snapshots of your data to
	 * Amazon Simple Storage (S3) for durable off-site recovery, as well as import the data to an
	 * Amazon Elastic Block Store (EBS) volume in Amazon Elastic Compute Cloud (EC2). You can take
	 * snapshots of your gateway volume on a scheduled or ad-hoc basis. This API enables you to take
	 * ad-hoc snapshot. For more information, see <a href="TBD">Working With Snapshots in the AWS
	 * Storage Gateway Console</a>.
	 *  
	 * In the CreateSnapshot request you identify the volume by providing its Amazon Resource Name
	 * (ARN). You must also provide description for the snapshot. When AWS Storage Gateway takes the
	 * snapshot of specified volume, the snapshot and description appears in the AWS Storage Gateway
	 * Console. In response, AWS Storage Gateway returns you a snapshot ID. You can use this snapshot
	 * ID to check the snapshot progress or later use it when you want to create a volume from a
	 * snapshot.
	 * 
	 * <p class="note">
	 * To list or delete a snapshot, you must use the Amazon EC2 API. For more information, go to
	 * 	<a href=
	 * "http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DeleteSnapshot.html">
	 * DeleteSnapshot</a> and <a href=
	 * "http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DescribeSnapshots.html">
	 * DescribeSnapshots</a> in the <em>Amazon Elastic Compute Cloud API Reference</em>.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the volume. Use the <code>ListVolumes</code> operation to return a list of gateway volumes.</li>
	 * 	<li><code>SnapshotDescription</code> - <code>string</code> - Required - Textual description of the snapshot that appears in the Amazon EC2 console, Elastic Block Store snapshots panel in the <strong>Description</strong> field, and in the AWS Storage Gateway snapshot <strong>Details</strong> pane, <strong>Description</strong> field</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_snapshot($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CreateSnapshot', $opt);
	}

	/**
	 * This operation initiates a snapshot of a gateway from a volume recovery point. This operation
	 * is supported only for the gateway-cached volume architecture (see
	 * <code>StorageGatewayConcepts</code>).
	 *  
	 * A volume recovery point is a point in time at which all data of the volume is consistent and
	 * from which you can create a snapshot. To get a list of volume recovery point for gateway-cached
	 * volumes, use <code>ListVolumeRecoveryPoints</code>.
	 *  
	 * In the <code>CreateSnapshotFromVolumeRecoveryPoint</code> request, you identify the volume by
	 * providing its Amazon Resource Name (ARN). You must also provide a description for the snapshot.
	 * When AWS Storage Gateway takes a snapshot of the specified volume, the snapshot and its
	 * description appear in the AWS Storage Gateway console. In response, AWS Storage Gateway returns
	 * you a snapshot ID. You can use this snapshot ID to check the snapshot progress or later use it
	 * when you want to create a volume from a snapshot.
	 * 
	 * <p class="note"></p> 
	 * To list or delete a snapshot, you must use the Amazon EC2 API. For more information, go to
	 * 	<a href=
	 * "http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DeleteSnapshot.html">
	 * DeleteSnapshot</a> and <a href=
	 * "http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DescribeSnapshots.html">
	 * DescribeSnapshots</a> in <em>Amazon Elastic Compute Cloud API Reference</em>.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the volume. Use the <code>ListVolumes</code> operation to return a list of gateway volumes.</li>
	 * 	<li><code>SnapshotDescription</code> - <code>string</code> - Required - A textual description of the snapshot that appears in the Amazon EC2 console, Elastic Block Store snapshots panel in the <strong>Description</strong> field, and in the AWS Storage Gateway snapshot <strong>Details</strong> pane, <strong>Description</strong> field. <em>Length</em>: Minimum length of 1. Maximum length of 255.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_snapshot_from_volume_recovery_point($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CreateSnapshotFromVolumeRecoveryPoint', $opt);
	}

	/**
	 * This operation creates a volume on a specified gateway. This operation is supported only for
	 * the gateway-cached volume architecture.
	 *  
	 * The size of the volume to create is inferred from the disk size. You can choose to preserve
	 * existing data on the disk, create volume from an existing snapshot, or create an empty volume.
	 * If you choose to create an empty gateway volume, then any existing data on the disk is erased.
	 *  
	 * In the request you must specify the gateway and the disk information on which you are creating
	 * the volume. In response, AWS Storage Gateway creates the volume and returns volume information
	 * such as the volume Amazon Resource Name (ARN), its size, and the iSCSI target ARN that
	 * initiators can use to connect to the volume target.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>DiskId</code> - <code>string</code> - Required - The unique identifier for the gateway local disk that is configured as a stored volume. Use <a href="http://docs.amazonwebservices.com/storagegateway/latest/userguide/API_ListLocalDisks.html">ListLocalDisks</a> to list disk IDs for a gateway.</li>
	 * 	<li><code>SnapshotId</code> - <code>string</code> - Optional - The snapshot ID (e.g. "snap-1122aabb") of the snapshot to restore as the new stored volume. Specify this field if you want to create the iSCSI storage volume from a snapshot otherwise do not include this field. To list snapshots for your account use <a href="http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DescribeSnapshots.html">DescribeSnapshots</a> in the <em>Amazon Elastic Compute Cloud API Reference</em>. [Constraints: The value must match the following regular expression pattern: <code>\Asnap-[0-9a-fA-F]{8}\z</code>]</li>
	 * 	<li><code>PreserveExistingData</code> - <code>boolean</code> - Required - Specify this field as true if you want to preserve the data on the local disk. Otherwise, specifying this field as false creates an empty volume. <em>Valid Values</em>: true, false</li>
	 * 	<li><code>TargetName</code> - <code>string</code> - Required - The name of the iSCSI target used by initiators to connect to the target and as a suffix for the target ARN. For example, specifying <code>TargetName</code> as <em>myvolume</em> results in the target ARN of arn:aws:storagegateway:us-east-1:111122223333:gateway/mygateway/target/iqn.1997-05.com.amazon:myvolume. The target name must be unique across all volumes of a gateway. [Constraints: The value must be between 1 and 200 characters, and must match the following regular expression pattern: <code>^[-\.;a-z0-9]+$</code>]</li>
	 * 	<li><code>NetworkInterfaceId</code> - <code>string</code> - Required - The network interface of the gateway on which to expose the iSCSI target. Only IPv4 addresses are accepted. Use <code>DescribeGatewayInformation</code> to get a list of the network interfaces available on a gateway. <em>Valid Values</em>: A valid IP address. [Constraints: The value must match the following regular expression pattern: <code>\A(25[0-5]|2[0-4]\d|[0-1]?\d?\d)(\.(25[0-5]|2[0-4]\d|[0-1]?\d?\d)){3}\z</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_stored_iscsi_volume($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('CreateStorediSCSIVolume', $opt);
	}

	/**
	 * This operation deletes the bandwidth rate limits of a gateway. You can delete either the upload
	 * and download bandwidth rate limit, or you can delete both. If you delete only one of the
	 * limits, the other limit remains unchanged. To specify which gateway to work with, use the
	 * Amazon Resource Name (ARN) of the gateway in your request.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>BandwidthType</code> - <code>string</code> - Required - One of the <code>BandwidthType</code> values that indicates the gateway bandwidth rate limit to delete. <em>Valid Values</em>: <code>Upload</code>, <code>Download</code>, <code>All</code> [Allowed values: <code>UPLOAD</code>, <code>DOWNLOAD</code>, <code>ALL</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_bandwidth_rate_limit($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeleteBandwidthRateLimit', $opt);
	}

	/**
	 * This operation deletes Challenge-Handshake Authentication Protocol (CHAP) credentials for a
	 * specified iSCSI target and initiator pair.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>TargetARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the iSCSI volume target. Use the <code>DescribeStorediSCSIVolumes</code> operation to return to retrieve the TargetARN for specified VolumeARN.</li>
	 * 	<li><code>InitiatorName</code> - <code>string</code> - Required - The iSCSI initiator that connects to the target. [Constraints: The value must be between 1 and 255 characters, and must match the following regular expression pattern: <code>[0-9a-z:.-]+</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_chap_credentials($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeleteChapCredentials', $opt);
	}

	/**
	 * This operation deletes a gateway. To specify which gateway to delete, use the Amazon Resource
	 * Name (ARN) of the gateway in your request. The operation deletes the gateway; however, it does
	 * not delete the gateway virtual machine (VM) from your host computer.
	 *  
	 * After you delete a gateway, you cannot reactivate it. Completed snapshots of the gateway
	 * volumes are not deleted upon deleting the gateway, however, pending snapshots will not
	 * complete. After you delete a gateway, your next step is to remove it from your environment.
	 * 
	 * <p class="important"></p> 
	 * You no longer pay software charges after the gateway is deleted; however, your existing Amazon
	 * EBS snapshots persist and you will continue to be billed for these snapshots.&Acirc;&nbsp;You
	 * can choose to remove all remaining Amazon EBS snapshots by canceling your Amazon EC2
	 * subscription.&Acirc;&nbsp; If you prefer not to cancel your Amazon EC2 subscription, you can
	 * delete your snapshots using the Amazon EC2 console. For more information, see the <a href=
	 * "http://aws.amazon.com/storagegateway">AWS Storage Gateway Detail Page</a>.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_gateway($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeleteGateway', $opt);
	}

	/**
	 * This operation deletes a snapshot of a volume.
	 *  
	 * You can take snapshots of your gateway volumes on a scheduled or ad-hoc basis. This API enables
	 * you to delete a snapshot schedule for a volume. For more information, see <a href=
	 * "http://docs.amazonwebservices.com/storagegateway/latest/userguide/WorkingWithSnapshots.html">Working
	 * with Snapshots</a>. In the <code>DeleteSnapshotSchedule</code> request, you identify the volume
	 * by providing its Amazon Resource Name (ARN).
	 * 
	 * <p class="note"></p> 
	 * To list or delete a snapshot, you must use the Amazon EC2 API. For more information, go to
	 * 	<a url=
	 * "http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DeleteSnapshot.html">
	 * DeleteSnapshot</a> and <a url=
	 * "http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DescribeSnapshots.html">
	 * DescribeSnapshots</a> in <em>Amazon Elastic Compute Cloud API Reference</em>.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the volume. Use the <code>ListVolumes</code> operation to return a list of gateway volumes.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_snapshot_schedule($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeleteSnapshotSchedule', $opt);
	}

	/**
	 * This operation delete the specified gateway volume that you previously created using the
	 * <code>CreateStorediSCSIVolume</code> API. For gateway-stored volumes, the local disk that was
	 * configured as the storage volume is not deleted. You can reuse the local disk to create another
	 * storage volume.
	 *  
	 * Before you delete a gateway volume, make sure there are no iSCSI connections to the volume you
	 * are deleting. You should also make sure there is no snapshot in progress. You can use the
	 * Amazon Elastic Compute Cloud (Amazon EC2) API to query snapshots on the volume you are deleting
	 * and check the snapshot status. For more information, go to <a href=
	 * "http://docs.amazonwebservices.com/AWSEC2/latest/APIReference/ApiReference-query-DescribeSnapshots.html">
	 * DescribeSnapshots</a> in the <em>Amazon Elastic Compute Cloud API Reference</em>.
	 *  
	 * In the request, you must provide the Amazon Resource Name (ARN) of the storage volume you want
	 * to delete.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the volume. Use the <code>ListVolumes</code> operation to return a list of gateway volumes.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_volume($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DeleteVolume', $opt);
	}

	/**
	 * This operation returns the bandwidth rate limits of a gateway. By default, these limits are not
	 * set, which means no bandwidth rate limiting is in effect.
	 *  
	 * This operation only returns a value for a bandwidth rate limit only if the limit is set. If no
	 * limits are set for the gateway, then this operation returns only the gateway ARN in the
	 * response body. To specify which gateway to describe, use the Amazon Resource Name (ARN) of the
	 * gateway in your request.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_bandwidth_rate_limit($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeBandwidthRateLimit', $opt);
	}

	/**
	 * This operation returns information about the cache of a gateway. This operation is supported
	 * only for the gateway-cached volume architecture.
	 *  
	 * The response includes disk IDs that are configured as cache, and it includes the amount of
	 * cache allocated and used.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_cache($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeCache', $opt);
	}

	/**
	 * This operation returns a description of the gateway volumes specified in the request. This
	 * operation is supported only for the gateway-cached volume architecture.
	 *  
	 * The list of gateway volumes in the request must be from one gateway. In the response Amazon
	 * Storage Gateway returns volume information sorted by volume Amazon Resource Name (ARN).
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARNs</code> - <code>string|array</code> - Required - An array of strings, where each string represents the Amazon Resource Name (ARN) of a cached volume. All of the specified cached volumes must be from the same gateway. Use <code>ListVolumes</code> to get volume ARNs of a gateway. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_cached_iscsi_volumes($opt = null)
	{
		if (!$opt) $opt = array();
		
		// List (non-map)
		if (isset($opt['VolumeARNs']))
		{
			$opt['VolumeARNs'] = (is_array($opt['VolumeARNs']) ? $opt['VolumeARNs'] : array($opt['VolumeARNs']));
		}

		return $this->authenticate('DescribeCachediSCSIVolumes', $opt);
	}

	/**
	 * This operation returns an array of Challenge-Handshake Authentication Protocol (CHAP)
	 * credentials information for a specified iSCSI target, one for each target-initiator pair.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>TargetARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the iSCSI volume target. Use the <code>DescribeStorediSCSIVolumes</code> operation to return to retrieve the TargetARN for specified VolumeARN.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_chap_credentials($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeChapCredentials', $opt);
	}

	/**
	 * This operation returns metadata about a gateway such as its name, network interfaces,
	 * configured time zone, and the state (whether the gateway is running or not). To specify which
	 * gateway to describe, use the Amazon Resource Name (ARN) of the gateway in your request.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_gateway_information($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeGatewayInformation', $opt);
	}

	/**
	 * This operation returns your gateway's weekly maintenance start time including the day and time
	 * of the week. Note that values are in terms of the gateway's time zone.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_maintenance_start_time($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeMaintenanceStartTime', $opt);
	}

	/**
	 * This operation describes the snapshot schedule for the specified gateway volume. The snapshot
	 * schedule information includes intervals at which snapshots are automatically initiated on the
	 * volume.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the volume. Use the <code>ListVolumes</code> operation to return a list of gateway volumes.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_snapshot_schedule($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeSnapshotSchedule', $opt);
	}

	/**
	 * This operation returns description of the gateway volumes specified in the request. The list of
	 * gateway volumes in the request must be from one gateway. In the response Amazon Storage Gateway
	 * returns volume information sorted by volume ARNs.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARNs</code> - <code>string|array</code> - Required - An array of strings where each string represents the Amazon Resource Name (ARN) of a stored volume. All of the specified stored volumes must from the same gateway. Use <code>ListVolumes</code> to get volume ARNs for a gateway. Pass a string for a single value, or an indexed array for multiple values.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_stored_iscsi_volumes($opt = null)
	{
		if (!$opt) $opt = array();
		
		// List (non-map)
		if (isset($opt['VolumeARNs']))
		{
			$opt['VolumeARNs'] = (is_array($opt['VolumeARNs']) ? $opt['VolumeARNs'] : array($opt['VolumeARNs']));
		}

		return $this->authenticate('DescribeStorediSCSIVolumes', $opt);
	}

	/**
	 * This operation returns information about the upload buffer of a gateway. This operation is
	 * supported for both the gateway-stored and gateway-cached volume architectures.
	 *  
	 * The response includes disk IDs that are configured as upload buffer space, and it includes the
	 * amount of upload buffer space allocated and used.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_upload_buffer($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeUploadBuffer', $opt);
	}

	/**
	 * This operation returns information about the working storage of a gateway. This operation is
	 * supported only for the gateway-stored volume architecture.
	 * 
	 * <p class="note"></p> 
	 * Working storage is also referred to as upload buffer. You can also use the
	 * <code>DescribeUploadBuffer</code> operation to add upload buffer to a stored-volume gateway.
	 *  
	 * The response includes disk IDs that are configured as working storage, and it includes the
	 * amount of working storage allocated and used.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_working_storage($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('DescribeWorkingStorage', $opt);
	}

	/**
	 * This operation lists gateways owned by an AWS account in a region specified in the request. The
	 * returned list is ordered by gateway Amazon Resource Name (ARN).
	 *  
	 * By default, the operation returns a maximum of 100 gateways. This operation supports pagination
	 * that allows you to optionally reduce the number of gateways returned in a response.
	 *  
	 * If you have more gateways than are returned in a response-that is, the response returns only a
	 * truncated list of your gateways-the response contains a marker that you can specify in your
	 * next request to fetch the next page of gateways.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - An opaque string that indicates the position at which to begin the returned list of gateways.</li>
	 * 	<li><code>Limit</code> - <code>integer</code> - Optional - Specifies that the list of gateways returned be limited to the specified number of items.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_gateways($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListGateways', $opt);
	}

	/**
	 * This operation returns a list of the local disks of a gateway. To specify which gateway to
	 * describe you use the Amazon Resource Name (ARN) of the gateway in the body of the request.
	 *  
	 * The request returns all disks, specifying which are configured as working storage, stored
	 * volume or not configured at all.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_local_disks($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListLocalDisks', $opt);
	}

	/**
	 * This operation lists the recovery points for a specified gateway. This operation is supported
	 * only for the gateway-cached volume architecture.
	 *  
	 * Each gateway-cached volume has one recovery point. A volume recovery point is a point in time
	 * at which all data of the volume is consistent and from which you can create a snapshot. To
	 * create a snapshot from a volume recovery point use the
	 * <code>CreateSnapshotFromVolumeRecoveryPoint</code> operation.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_volume_recovery_points($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListVolumeRecoveryPoints', $opt);
	}

	/**
	 * This operation lists the iSCSI stored volumes of a gateway. Results are sorted by volume ARN.
	 * The response includes only the volume ARNs. If you want additional volume information, use the
	 * <code>DescribeStorediSCSIVolumes</code> API.
	 *  
	 * The operation supports pagination. By default, the operation returns a maximum of up to 100
	 * volumes. You can optionally specify the <code>Limit</code> field in the body to limit the
	 * number of volumes in the response. If the number of volumes returned in the response is
	 * truncated, the response includes a Marker field. You can use this Marker value in your
	 * subsequent request to retrieve the next set of volumes.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - A string that indicates the position at which to begin the returned list of volumes. Obtain the marker from the response of a previous List iSCSI Volumes request.</li>
	 * 	<li><code>Limit</code> - <code>integer</code> - Optional - Specifies that the list of volumes returned be limited to the specified number of items.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_volumes($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ListVolumes', $opt);
	}

	/**
	 * This operation shuts down a gateway. To specify which gateway to shut down, use the Amazon
	 * Resource Name (ARN) of the gateway in the body of your request.
	 *  
	 * The operation shuts down the gateway service component running in the storage gateway's virtual
	 * machine (VM) and not the VM.
	 * 
	 * <p class="note">
	 * If you want to shut down the VM, it is recommended that you first shut down the gateway
	 * component in the VM to avoid unpredictable conditions.
	 * </p> 
	 * After the gateway is shutdown, you cannot call any other API except <code>StartGateway</code>,
	 * <code>DescribeGatewayInformation</code>, and <code>ListGateways</code>. For more information,
	 * see <code>ActivateGateway</code>. Your applications cannot read from or write to the gateway's
	 * storage volumes, and there are no snapshots taken.
	 * 
	 * <p class="note">
	 * When you make a shutdown request, you will get a <code>200 OK</code> success response
	 * immediately. However, it might take some time for the gateway to shut down. You can call the
	 * <code>DescribeGatewayInformation</code> API to check the status. For more information, see
	 * <code>ActivateGateway</code>.
	 * </p> 
	 * If do not intend to use the gateway again, you must delete the gateway (using
	 * <code>DeleteGateway</code>) to no longer pay software charges associated with the gateway.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function shutdown_gateway($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('ShutdownGateway', $opt);
	}

	/**
	 * This operation starts a gateway that you previously shut down (see
	 * <code>ShutdownGateway</code>). After the gateway starts, you can then make other API calls,
	 * your applications can read from or write to the gateway's storage volumes and you will be able
	 * to take snapshot backups.
	 * 
	 * <p class="note">
	 * When you make a request, you will get a 200 OK success response immediately. However, it might
	 * take some time for the gateway to be ready. You should call
	 * <code>DescribeGatewayInformation</code> and check the status before making any additional API
	 * calls. For more information, see <code>ActivateGateway</code>.
	 * </p> 
	 * To specify which gateway to start, use the Amazon Resource Name (ARN) of the gateway in your
	 * request.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function start_gateway($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('StartGateway', $opt);
	}

	/**
	 * This operation updates the bandwidth rate limits of a gateway. You can update both the upload
	 * and download bandwidth rate limit or specify only one of the two. If you don't set a bandwidth
	 * rate limit, the existing rate limit remains.
	 *  
	 * By default, a gateway's bandwidth rate limits are not set. If you don't set any limit, the
	 * gateway does not have any limitations on its bandwidth usage and could potentially use the
	 * maximum available bandwidth.
	 *  
	 * To specify which gateway to update, use the Amazon Resource Name (ARN) of the gateway in your
	 * request.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>AverageUploadRateLimitInBitsPerSec</code> - <code>long</code> - Optional - The average upload bandwidth rate limit in bits per second.</li>
	 * 	<li><code>AverageDownloadRateLimitInBitsPerSec</code> - <code>long</code> - Optional - The average download bandwidth rate limit in bits per second.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_bandwidth_rate_limit($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('UpdateBandwidthRateLimit', $opt);
	}

	/**
	 * This operation updates the Challenge-Handshake Authentication Protocol (CHAP) credentials for a
	 * specified iSCSI target. By default, a gateway does not have CHAP enabled; however, for added
	 * security, you might use it.
	 * 
	 * <p class="important"></p> 
	 * When you update CHAP credentials, all existing connections on the target are closed and
	 * initiators must reconnect with the new credentials.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>TargetARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the iSCSI volume target. Use the <code>DescribeStorediSCSIVolumes</code> operation to return to retrieve the TargetARN for specified VolumeARN.</li>
	 * 	<li><code>SecretToAuthenticateInitiator</code> - <code>string</code> - Required - The secret key that the initiator (e.g. Windows client) must provide to participate in mutual CHAP with the target.</li>
	 * 	<li><code>InitiatorName</code> - <code>string</code> - Required - The iSCSI initiator that connects to the target. [Constraints: The value must be between 1 and 255 characters, and must match the following regular expression pattern: <code>[0-9a-z:.-]+</code>]</li>
	 * 	<li><code>SecretToAuthenticateTarget</code> - <code>string</code> - Optional - The secret key that the target must provide to participate in mutual CHAP with the initiator (e.g. Windows client).</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_chap_credentials($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('UpdateChapCredentials', $opt);
	}

	/**
	 * This operation updates a gateway's metadata, which includes the gateway's name and time zone.
	 * To specify which gateway to update, use the Amazon Resource Name (ARN) of the gateway in your
	 * request.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>GatewayName</code> - <code>string</code> - Optional - A unique identifier for your gateway. This name becomes part of the gateway Amazon Resources Name (ARN) which is what you use as an input to other operations. [Constraints: The value must be between 2 and 255 characters, and must match the following regular expression pattern: <code>^[ -\.0-\[\]-~]*[!-\.0-\[\]-~][ -\.0-\[\]-~]*$</code>]</li>
	 * 	<li><code>GatewayTimezone</code> - <code>string</code> - Optional - One of the <code>GatewayTimezone</code> values that represents the time zone for your gateway. The time zone is used, for example, when a time stamp is given to a snapshot. [Allowed values: <code>GMT-12:00</code>, <code>GMT-11:00</code>, <code>GMT-10:00</code>, <code>GMT-9:00</code>, <code>GMT-8:00</code>, <code>GMT-7:00</code>, <code>GMT-6:00</code>, <code>GMT-5:00</code>, <code>GMT-4:00</code>, <code>GMT-3:30</code>, <code>GMT-3:00</code>, <code>GMT-2:00</code>, <code>GMT-1:00</code>, <code>GMT</code>, <code>GMT+1:00</code>, <code>GMT+2:00</code>, <code>GMT+3:00</code>, <code>GMT+3:30</code>, <code>GMT+4:00</code>, <code>GMT+4:30</code>, <code>GMT+5:00</code>, <code>GMT+5:30</code>, <code>GMT+5:45</code>, <code>GMT+6:00</code>, <code>GMT+7:00</code>, <code>GMT+8:00</code>, <code>GMT+9:00</code>, <code>GMT+9:30</code>, <code>GMT+10:00</code>, <code>GMT+11:00</code>, <code>GMT+12:00</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_gateway_information($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('UpdateGatewayInformation', $opt);
	}

	/**
	 * This operation updates the gateway virtual machine (VM) software. The request immediately
	 * triggers the software update.
	 * 
	 * <p class="note">
	 * When you make this request, you get a <code>200 OK</code> success response immediately.
	 * However, it might take some time for the update to complete. You can call
	 * <code>DescribeGatewayInformation</code> to verify the gateway is in the
	 * <code>STATE_RUNNING</code> state.
	 * </p>
	 * <p class="important">
	 * A software update forces a system restart of your gateway. You can minimize the chance of any
	 * disruption to your applications by increasing your iSCSI Initiators' timeouts. For more
	 * information about increasing iSCSI Initiator timeouts for Windows and Linux, see <a href=
	 * "http://docs.amazonwebservices.com/storagegateway/latest/userguide/ConfiguringiSCSIClientInitiatorWindowsClient.html#CustomizeWindowsiSCSISettings">
	 * Customizing Your Windows iSCSI Settings</a> and <a href=
	 * "http://docs.amazonwebservices.com/storagegateway/latest/userguide/ConfiguringiSCSIClientInitiatorRedHatClient.html#CustomizeLinuxiSCSISettings">
	 * Customizing Your Linux iSCSI Settings</a>, respectively.
	 * </p>
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_gateway_software_now($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('UpdateGatewaySoftwareNow', $opt);
	}

	/**
	 * This operation updates a gateway's weekly maintenance start time information, including day and
	 * time of the week. The maintenance time is the time in your gateway's time zone.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GatewayARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the gateway. Use the <code>ListGateways</code> operation to return a list of gateways for your account and region.</li>
	 * 	<li><code>HourOfDay</code> - <code>integer</code> - Required - The hour component of the maintenance start time represented as <emphasis>hh</emphasis>, where<em>hh</em> is the hour (00 to 23). The hour of the day is in the time zone of the gateway.</li>
	 * 	<li><code>MinuteOfHour</code> - <code>integer</code> - Required - The minute component of the maintenance start time represented as <em>mm</em>, where <em>mm</em> is the minute (00 to 59). The minute of the hour is in the time zone of the gateway.</li>
	 * 	<li><code>DayOfWeek</code> - <code>integer</code> - Required - The maintenance start time day of the week.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_maintenance_start_time($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('UpdateMaintenanceStartTime', $opt);
	}

	/**
	 * This operation updates a snapshot schedule configured for a gateway volume.
	 *  
	 * The default snapshot schedule for volume is once every 24 hours, starting at the creation time
	 * of the volume. You can use this API to change the shapshot schedule configured for the volume.
	 *  
	 * In the request you must identify the gateway volume whose snapshot schedule you want to update,
	 * and the schedule information, including when you want the snapshot to begin on a day and the
	 * frequency (in hours) of snapshots.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VolumeARN</code> - <code>string</code> - Required - The Amazon Resource Name (ARN) of the volume. Use the <code>ListVolumes</code> operation to return a list of gateway volumes.</li>
	 * 	<li><code>StartAt</code> - <code>integer</code> - Required - The hour of the day at which the snapshot schedule begins represented as <em>hh</em>, where <em>hh</em> is the hour (0 to 23). The hour of the day is in the time zone of the gateway.</li>
	 * 	<li><code>RecurrenceInHours</code> - <code>integer</code> - Required - Frequency of snapshots. Specify the number of hours between snapshots.</li>
	 * 	<li><code>Description</code> - <code>string</code> - Optional - Optional description of the snapshot that overwrites the existing description.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_snapshot_schedule($opt = null)
	{
		if (!$opt) $opt = array();
		
		return $this->authenticate('UpdateSnapshotSchedule', $opt);
	}
}


/*%******************************************************************************************%*/
// EXCEPTIONS

class StorageGateway_Exception extends Exception {}


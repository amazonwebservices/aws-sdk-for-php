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
 * The AWS Security Token Service is a web service that enables you to request temporary,
 * limited-privilege credentials for AWS Identity and Access Management (IAM) users or for users
 * that you authenticate (federated users). This guide provides descriptions of the AWS Security
 * Token Service API.
 *  
 * For more detailed information about using this service, go to <a href=
 * "http://docs.amazonwebservices.com/IAM/latest/UsingSTS/Welcome.html" target="_blank">Using
 * Temporary Security Credentials</a>.
 *  
 * For information about setting up signatures and authorization through the API, go to <a href=
 * "http://docs.amazonwebservices.com/general/latest/gr/signing_aws_api_requests.html" target=
 * "_blank">Signing AWS API Requests</a> in the <em>AWS General Reference</em>. For general
 * information about the Query API, go to <a href=
 * "http://docs.amazonwebservices.com/IAM/latest/UserGuide/IAM_UsingQueryAPI.html" target=
 * "_blank">Making Query Requests</a> in <em>Using IAM</em>. For information about using security
 * tokens with other AWS products, go to <a href=
 * "http://docs.amazonwebservices.com/IAM/latest/UsingSTS/UsingTokens.html">Using Temporary
 * Security Credentials to Access AWS</a> in <em>Using Temporary Security Credentials</em>.
 *  
 * If you're new to AWS and need additional technical information about a specific AWS product,
 * you can find the product'stechnical documentation at <a href=
 * "http://aws.amazon.com/documentation/" target=
 * "_blank">http://aws.amazon.com/documentation/</a>.
 *  
 * We will refer to Amazon Identity and Access Management using the abbreviated form IAM. All
 * copyrights and legal protections still apply.
 *
 * @version 2013.01.14
 * @license See the included NOTICE.md file for complete information.
 * @copyright See the included NOTICE.md file for complete information.
 * @link http://aws.amazon.com/sts/ Amazon Secure Token Service
 * @link http://aws.amazon.com/sts/documentation/ Amazon Secure Token Service documentation
 */
class AmazonSTS extends CFRuntime
{
	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = 'sts.amazonaws.com';

	/**
	 * Specify the queue URL for the United States East (Northern Virginia) Region.
	 */
	const REGION_VIRGINIA = self::REGION_US_E1;

	/**
	 * Specify the queue URL for the United States GovCloud Region.
	 */
	const REGION_US_GOV1 = 'sts.us-gov-west-1.amazonaws.com';

	/**
	 * Default service endpoint.
	 */
	const DEFAULT_URL = self::REGION_US_E1;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of <AmazonSTS>.
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
		$this->api_version = '2011-06-15';
		$this->hostname = self::DEFAULT_URL;
		$this->auth_class = 'AuthV4Query';

		return parent::__construct($options);
	}


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * This allows you to explicitly sets the region for the service to use.
	 *
	 * @param string $region (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_GOV1>.
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
	 * The <code>AssumeRole</code> action returns a set of temporary security credentials that you can
	 * use to access resources that are defined in the role's policy. The returned credentials consist
	 * of an Access Key ID, a Secret Access Key, and a security token.
	 *  
	 * <strong>Important:</strong> Only IAM users can assume a role. If you use AWS account
	 * credentials to call AssumeRole, access is denied.
	 *  
	 * The credentials are valid for the duration that you specified when calling
	 * <code>AssumeRole</code>, which can be from 15 minutes to 1 hour.
	 *  
	 * When you assume a role, you have the privileges that are defined in the role. You can further
	 * restrict the privileges by passing a policy when calling <code>AssumeRole</code>.
	 *  
	 * To assume a role, you must be an IAM user from a trusted entity and have permission to call
	 * <code>AssumeRole</code>. Trusted entites are defined when the IAM role is created. Permission
	 * to call <code>AssumeRole</code> is defined in your or your group's IAM policy.
	 *
	 * @param string $role_arn (Required) The Amazon Resource Name (ARN) of the role that the caller is assuming.
	 * @param string $role_session_name (Required) An identifier for the assumed role session. The session name is included as part of the <code>AssumedRoleUser</code>. [Constraints: The value must be between 2 and 32 characters, and must match the following regular expression pattern: <code>[\w+=,.@-]*</code>]
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Policy</code> - <code>string</code> - Optional - A supplemental policy that can be associated with the temporary security credentials. The caller can restrict the permissions that are available on the role's temporary security credentials to maintain the least amount of privileges. When a service call is made with the temporary security credentials, both the role's permission policy and supplemental policy are checked. For more information about how permissions work in the context of temporary credentials, see <a href="http://docs.amazonwebservices.com/IAM/latest/UserGuide/TokenPermissions.html" target="_blank">Controlling Permissions in Temporary Credentials</a>. [Constraints: The value must be between 1 and 2048 characters, and must match the following regular expression pattern: <code>[\u0009\u000A\u000D\u0020-\u00FF]+</code>]</li>
	 * 	<li><code>DurationSeconds</code> - <code>integer</code> - Optional - The duration, in seconds, of the role session. The value can range from 900 seconds (15 minutes) to 3600 seconds (1 hour). By default, the value is set to 3600 seconds (1 hour).</li>
	 * 	<li><code>ExternalId</code> - <code>string</code> - Optional - A unique identifier that is generated by a third party for each of their customers. For each role that the third party can assume, they should instruct their customers to create a role with the external ID that was generated by the third party. Each time the third party assumes the role, they must pass the customer's correct external ID. The external ID is useful in order to help third parties bind a role to the customer who created it. For more information about the external ID, see <a href="http://docs.amazonwebservices.com/STS/latest/UsingSTS/sts-delegating-externalid.html" target="_blank">About the External ID</a> in <em>Using Temporary Security Credentials</em>. [Constraints: The value must be between 2 and 96 characters, and must match the following regular expression pattern: <code>[\w+=,.@:-]*</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function assume_role($role_arn, $role_session_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['RoleArn'] = $role_arn;
		$opt['RoleSessionName'] = $role_session_name;
		
		return $this->authenticate('AssumeRole', $opt);
	}

	/**
	 * The GetFederationToken action returns a set of temporary credentials for a federated user with
	 * the user name and policy specified in the request. The credentials consist of an Access Key ID,
	 * a Secret Access Key, and a security token. Credentials created by IAM users are valid for the
	 * specified duration, between 15 minutes and 36 hours; credentials created using account
	 * credentials have a maximum duration of one hour.
	 *  
	 * The federated user who holds these credentials has any permissions allowed by the intersection
	 * of the specified policy and any resource or user policies that apply to the caller of the
	 * GetFederationToken API, and any resource policies that apply to the federated user's Amazon
	 * Resource Name (ARN). For more information about how token permissions work, see <a href=
	 * "http://docs.amazonwebservices.com/IAM/latest/UserGuide/TokenPermissions.html" target=
	 * "_blank">Controlling Permissions in Temporary Credentials</a> in <em>Using IAM</em>. For
	 * information about using GetFederationToken to create temporary credentials, see <a href=
	 * "http://docs.amazonwebservices.com/IAM/latest/UserGuide/CreatingFedTokens.html" target=
	 * "_blank">Creating Temporary Credentials to Enable Access for Federated Users</a> in <em>Using
	 * IAM</em>.
	 *
	 * @param string $name (Required) The name of the federated user associated with the credentials. For information about limitations on user names, go to <a href="http://docs.amazonwebservices.com/IAM/latest/UserGuide/LimitationsOnEntities.html">Limitations on IAM Entities</a> in <em>Using IAM</em>. [Constraints: The value must be between 2 and 32 characters, and must match the following regular expression pattern: <code>[\w+=,.@-]*</code>]
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Policy</code> - <code>string</code> - Optional - A policy specifying the permissions to associate with the credentials. The caller can delegate their own permissions by specifying a policy, and both policies will be checked when a service call is made. For more information about how permissions work in the context of temporary credentials, see <a href="http://docs.amazonwebservices.com/IAM/latest/UserGuide/TokenPermissions.html" target="_blank">Controlling Permissions in Temporary Credentials</a> in <em>Using IAM</em>. [Constraints: The value must be between 1 and 2048 characters, and must match the following regular expression pattern: <code>[\u0009\u000A\u000D\u0020-\u00FF]+</code>]</li>
	 * 	<li><code>DurationSeconds</code> - <code>integer</code> - Optional - The duration, in seconds, that the session should last. Acceptable durations for federation sessions range from 900s (15 minutes) to 129600s (36 hours), with 43200s (12 hours) as the default. Sessions for AWS account owners are restricted to a maximum of 3600s (one hour). If the duration is longer than one hour, the session for AWS account owners defaults to one hour.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_federation_token($name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Name'] = $name;
		
		return $this->authenticate('GetFederationToken', $opt);
	}

	/**
	 * The GetSessionToken action returns a set of temporary credentials for an AWS account or IAM
	 * user. The credentials consist of an Access Key ID, a Secret Access Key, and a security token.
	 * These credentials are valid for the specified duration only. The session duration for IAM users
	 * can be between 15 minutes and 36 hours, with a default of 12 hours. The session duration for
	 * AWS account owners is restricted to a maximum of one hour. Providing the AWS Multi-Factor
	 * Authentication (MFA) device serial number and the token code is optional.
	 *  
	 * For more information about using GetSessionToken to create temporary credentials, go to
	 * 	<a href="http://docs.amazonwebservices.com/IAM/latest/UserGuide/CreatingSessionTokens.html"
	 * target="_blank">Creating Temporary Credentials to Enable Access for IAM Users</a> in <em>Using
	 * IAM</em>.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DurationSeconds</code> - <code>integer</code> - Optional - The duration, in seconds, that the credentials should remain valid. Acceptable durations for IAM user sessions range from 900s (15 minutes) to 129600s (36 hours), with 43200s (12 hours) as the default. Sessions for AWS account owners are restricted to a maximum of 3600s (one hour). If the duration is longer than one hour, the session for AWS account owners defaults to one hour.</li>
	 * 	<li><code>SerialNumber</code> - <code>string</code> - Optional - The identification number of the MFA device for the user. If the IAM user has a policy requiring MFA authentication (or is in a group requiring MFA authentication) to access resources, provide the device value here. The value is in the <strong>Security Credentials</strong> tab of the user's details pane in the IAM console. If the IAM user has an active MFA device, the details pane displays a <strong>Multi-Factor Authentication Device</strong> value. The value is either for a virtual device, such as <code>arn:aws:iam::123456789012:mfa/user</code>, or it is the device serial number for a hardware device (usually the number from the back of the device), such as <code>GAHT12345678</code>. For more information, see <a href="http://docs.amazonwebservices.com/IAM/latest/UserGuide/Using_ManagingMFA.html" target="_blank">Using Multi-Factor Authentication (MFA) Devices with AWS</a> in <em>Using IAM</em>. [Constraints: The value must be between 9 and 256 characters, and must match the following regular expression pattern: <code>[\w+=/:,.@-]*</code>]</li>
	 * 	<li><code>TokenCode</code> - <code>string</code> - Optional - The value provided by the MFA device. If the user has an access policy requiring an MFA code (or is in a group requiring an MFA code), provide the value here to get permission to resources as specified in the access policy. If MFA authentication is required, and the user does not provide a code when requesting a set of temporary security credentials, the user will receive an "access denied" response when requesting resources that require MFA authentication. For more information, see <a href="http://docs.amazonwebservices.com/IAM/latest/UserGuide/Using_ManagingMFA.html" target="_blank">Using Multi-Factor Authentication (MFA) Devices with AWS</a> in <em>Using IAM</em>. [Constraints: The value must be between 6 and 6 characters, and must match the following regular expression pattern: <code>[\d]*</code>]</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_session_token($opt = null)
	{
		if (!$opt) $opt = array();
				
		return $this->authenticate('GetSessionToken', $opt);
	}
}


/*%******************************************************************************************%*/
// EXCEPTIONS

class STS_Exception extends Exception {}

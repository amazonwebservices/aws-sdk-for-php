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
 * File: AmazonIAM
 * 	 *
 * 	AWS Identity and Access Management (IAM) is a web service that enables Amazon Web Services (AWS)
 * 	customers to manage users and user permissions under their AWS account. This is the AWS Identity and
 * 	Access Management API Reference. This guide describes who should read this guide and other resources
 * 	related to IAM. Use of this guide assumes you are familiar with the following:
 *
 * 	- Basic understanding of web services (for information, go to W3 Schools Web Services Tutorial at
 * 	ttp://www.w3schools.com/webservices/default.asp](http://www.w3schools.com/webservices/default.asp)).
 *
 * 	- XML (for information, go to W3 Schools XML Tutorial at
 * 	[http://www.w3schools.com/xml/default.asp](http://www.w3schools.com/xml/default.asp)).
 *
 * 	- JSON (for information, go to [http://json.org](http://json.org))
 *
 * 	- The specific AWS products you are using or plan to use (e.g., Amazon Elastic Compute Cloud (Amazon
 * 	EC2), Amazon Simple Storage Service (Amazon S3), etc.)
 *
 * 	If you're new to AWS and need additional technical information about a specific AWS product, you
 * 	can find the product's technical documentation at
 * 	[http://aws.amazon.com/documentation/](http://aws.amazon.com/documentation/). We will refer to
 * 	Amazon AWS Identity and Access Management using the the abbreviated form IAM; all copyrights and
 * 	legal protections still apply.
 *
 * Version:
 * 	Tue Nov 09 21:01:38 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon Identity and Access Management Service](http://aws.amazon.com/iam/)
 * 	[Amazon Identity and Access Management Service documentation](http://aws.amazon.com/documentation/iam/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: IAM_Exception
 * 	Default IAM Exception.
 */
class IAM_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonIAM
 * 	Container for all service-related methods.
 */
class AmazonIAM extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'iam.amazonaws.com';



	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonIAM>.
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
		$this->api_version = '2010-05-08';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new IAM_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new IAM_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: list_groups()
	 * 	Lists the groups that have the specified path prefix. You can paginate the results using the
	 * 	`MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	PathPrefix - _string_ (Optional) The path prefix for filtering the results. For example: `/division_abc/subdivision_xyz/`, which would get all groups whose path starts with `/division_abc/subdivision_xyz/`. This parameter is optional. If it is not included, it defaults to /, listing all groups.
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of groups you want in the response. If there are additional groups beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_groups($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListGroups', $opt, $this->hostname);
	}

	/**
	 * Method: delete_access_key()
	 * 	Deletes the access key associated with the specified user. If the `UserName` field is not specified,
	 * 	the UserName is determined implicitly based on the AWS Access Key ID used to sign the request.
	 * 	Because this action works for access keys under the account, this API can be used to manage root
	 * 	credentials even if the account has no associated users.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$access_key_id - _string_ (Required) The Access Key ID for the Access Key ID and Secret Access Key you want to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) Name of the user whose key you want to delete.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_access_key($access_key_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AccessKeyId'] = $access_key_id;

		return $this->authenticate('DeleteAccessKey', $opt, $this->hostname);
	}

	/**
	 * Method: list_signing_certificates()
	 * 	Returns information about the signing certificates associated with the specified user. If there are
	 * 	none, the action returns an empty list. Although each user is limited to a small number of signing
	 * 	certificates, you can still paginate the results using the `MaxItems` and `Marker` parameters. If
	 * 	the `UserName` field is not specified, the UserName is determined implicitly based on the AWS Access
	 * 	Key ID used to sign the request. Because this action works for access keys under the account, this
	 * 	API can be used to manage root credentials even if the account has no associated users.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) The name of the user.
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of certificate IDs you want in the response. If there are additional certificate IDs beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_signing_certificates($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListSigningCertificates', $opt, $this->hostname);
	}

	/**
	 * Method: upload_signing_certificate()
	 * 	Uploads an X.509 signing certificate and associates it with the specified user. Some AWS services
	 * 	use X.509 signing certificates to validate requests that are signed with a corresponding private
	 * 	key. When you upload the certificate, its default status is Active. If the `UserName` field is not
	 * 	specified, the UserName is determined implicitly based on the AWS Access Key ID used to sign the
	 * 	request. Because this action works for access keys under the account, this API can be used to manage
	 * 	root credentials even if the account has no associated users. Because the body of a X.509
	 * 	certificate can be large, you should use POST rather than GET when calling
	 * 	`UploadSigningCertificate`. For more information, see Using the Query API in the [AWS Identity and
	 * 	Access Management User Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$certificate_body - _string_ (Required) The contents of the signing certificate.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) Name of the user the signing certificate is for.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function upload_signing_certificate($certificate_body, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['CertificateBody'] = $certificate_body;

		return $this->authenticate('UploadSigningCertificate', $opt, $this->hostname);
	}

	/**
	 * Method: delete_user_policy()
	 * 	Deletes the specified policy associated with the specified user.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user the policy is associated with.
	 *	$policy_name - _string_ (Required) Name of the policy document to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_user_policy($user_name, $policy_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;
		$opt['PolicyName'] = $policy_name;

		return $this->authenticate('DeleteUserPolicy', $opt, $this->hostname);
	}

	/**
	 * Method: put_user_policy()
	 * 	Adds (or updates) a policy document associated with the specified user. For information about how to
	 * 	write a policy, refer to the [AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/). For information about limits on the number of policies
	 * 	you can associate with a user, see Limitations on AWS IAM Entities in the [AWS Identity and Access
	 * 	Management User Guide](http://aws.amazon.com/documentation/). Because policy documents can be large,
	 * 	you should use POST rather than GET when calling `PutUserPolicy`. For more information, see Using
	 * 	the Query API in the [AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user to associate the policy with.
	 *	$policy_name - _string_ (Required) Name of the policy document.
	 *	$policy_document - _string_ (Required) The policy document.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function put_user_policy($user_name, $policy_name, $policy_document, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;
		$opt['PolicyName'] = $policy_name;
		$opt['PolicyDocument'] = $policy_document;

		return $this->authenticate('PutUserPolicy', $opt, $this->hostname);
	}

	/**
	 * Method: get_user_policy()
	 * 	Retrieves the specified policy document for the specified user. The returned policy is URL-encoded
	 * 	according to RFC 3986. For more information about RFC 3986, go to
	 * 	http://www.faqs.org/rfcs/rfc3986.html.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user that the policy is associated with.
	 *	$policy_name - _string_ (Required) Name of the policy document to get.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_user_policy($user_name, $policy_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;
		$opt['PolicyName'] = $policy_name;

		return $this->authenticate('GetUserPolicy', $opt, $this->hostname);
	}

	/**
	 * Method: update_login_profile()
	 * 	Updates the login profile for the specified user. Use this API to change the user's password.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user whose login profile you want to update.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Password - _string_ (Optional) The new password for the user.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_login_profile($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('UpdateLoginProfile', $opt, $this->hostname);
	}

	/**
	 * Method: update_user()
	 * 	Updates the name and/or the path of the specified user. You should understand the implications of
	 * 	changing a user's path or name. For more information, see Renaming Users and Groups in the [AWS
	 * 	Identity and Access Management User Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user to update. If you're changing the name of the user, this is the original name.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	NewPath - _string_ (Optional) New path for the user. Include this only if you're changing the user's path.
	 *	NewUserName - _string_ (Optional) New name for the user. Include this only if you're changing the user's name.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_user($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('UpdateUser', $opt, $this->hostname);
	}

	/**
	 * Method: delete_login_profile()
	 * 	Deletes the login profile for the specified user, which terminates the user's ability to access AWS
	 * 	services through the IAM login page. Deleting a user's login profile does not prevent a user from
	 * 	accessing IAM through the command line interface or the API. To prevent a user from accessing IAM
	 * 	through the command line interface or the API you must either make the access key inactive or delete
	 * 	it. For more information about making keys inactive or deleting them, see UpdateAccessKey and
	 * 	DeleteAccessKey.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user whose login profile you want to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_login_profile($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('DeleteLoginProfile', $opt, $this->hostname);
	}

	/**
	 * Method: update_signing_certificate()
	 * 	Changes the status of the specified signing certificate from active to disabled, or vice versa. This
	 * 	action can be used to disable a user's signing certificate as part of a certificate rotation
	 * 	workflow. If the `UserName` field is not specified, the UserName is determined implicitly based on
	 * 	the AWS Access Key ID used to sign the request. Because this action works for access keys under the
	 * 	account, this API can be used to manage root credentials even if the account has no associated
	 * 	users. For information about rotating certificates, see Managing Keys and Certificates in the [AWS
	 * 	Identity and Access Management User Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$certificate_id - _string_ (Required) The ID of the signing certificate you want to update.
	 *	$status - _string_ (Required) The status you want to assign to the certificate. `Active` means the certificate can be used for API calls to AWS, while `Inactive` means the certificate cannot be used. [Allowed values: `Active`, `Inactive`]
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) Name of the user the signing certificate belongs to.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_signing_certificate($certificate_id, $status, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['CertificateId'] = $certificate_id;
		$opt['Status'] = $status;

		return $this->authenticate('UpdateSigningCertificate', $opt, $this->hostname);
	}

	/**
	 * Method: list_users()
	 * 	Lists the users that have the specified path prefix. If there are none, the action returns an empty
	 * 	list. You can paginate the results using the `MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	PathPrefix - _string_ (Optional) The path prefix for filtering the results. For example: `/division_abc/subdivision_xyz/`, which would get all users whose path starts with `/division_abc/subdivision_xyz/`. This parameter is optional. If it is not included, it defaults to /, listing all users.
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of users you want in the response. If there are additional users beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_users($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListUsers', $opt, $this->hostname);
	}

	/**
	 * Method: delete_group_policy()
	 * 	Deletes the specified policy that is associated with the specified group.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group the policy is associated with.
	 *	$policy_name - _string_ (Required) Name of the policy document to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_group_policy($group_name, $policy_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;
		$opt['PolicyName'] = $policy_name;

		return $this->authenticate('DeleteGroupPolicy', $opt, $this->hostname);
	}

	/**
	 * Method: update_group()
	 * 	Updates the name and/or the path of the specified group. You should understand the implications of
	 * 	changing a group's path or name. For more information, see Renaming Users and Groups in the [AWS
	 * 	Identity and Access Management User Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group to update. If you're changing the name of the group, this is the original name.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	NewPath - _string_ (Optional) New path for the group. Only include this if changing the group's path.
	 *	NewGroupName - _string_ (Optional) New name for the group. Only include this if changing the group's name.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_group($group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;

		return $this->authenticate('UpdateGroup', $opt, $this->hostname);
	}

	/**
	 * Method: put_group_policy()
	 * 	Adds (or updates) a policy document associated with the specified group. For information about how
	 * 	to write a policy, refer to the [AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/). For information about limits on the number of policies
	 * 	you can associate with a group, see Limitations on AWS IAM Entities in the [AWS Identity and Access
	 * 	Management User Guide](http://aws.amazon.com/documentation/). Because policy documents can be large,
	 * 	you should use POST rather than GET when calling `PutGroupPolicy`. For more information, see Using
	 * 	the Query API in the [ AWS Identity and Access Management User Guide](http://aws.amazon.com/docu/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group to associate the policy with.
	 *	$policy_name - _string_ (Required) Name of the policy document.
	 *	$policy_document - _string_ (Required) The policy document.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function put_group_policy($group_name, $policy_name, $policy_document, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;
		$opt['PolicyName'] = $policy_name;
		$opt['PolicyDocument'] = $policy_document;

		return $this->authenticate('PutGroupPolicy', $opt, $this->hostname);
	}

	/**
	 * Method: create_user()
	 * 	Creates a new user for your account. For information about limitations on the number of users you
	 * 	can create, see Limitations on AWS IAM Entities in the [AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user to create.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Path - _string_ (Optional) The user's path. For more information about paths, see Identifiers for Users and Groups in the AWS AWS Identity and Access Management User Guide. This parameter is optional. If it is not included, it defaults to /.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_user($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('CreateUser', $opt, $this->hostname);
	}

	/**
	 * Method: delete_signing_certificate()
	 * 	Deletes the specified signing certificate associated with the specified user. If the `UserName`
	 * 	field is not specified, the UserName is determined implicitly based on the AWS Access Key ID used to
	 * 	sign the request. Because this action works for access keys under the account, this API can be used
	 * 	to manage root credentials even if the account has no associated users.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$certificate_id - _string_ (Required) ID of the signing certificate to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) Name of the user the signing certificate belongs to.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_signing_certificate($certificate_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['CertificateId'] = $certificate_id;

		return $this->authenticate('DeleteSigningCertificate', $opt, $this->hostname);
	}

	/**
	 * Method: enable_mfa_device()
	 * 	Enables the specified MFA device and associates it with the specified user. Once enabled, the MFA
	 * 	device is required for every subsequent login by the user associated with the device.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user for whom you want to enable the MFA device.
	 *	$serial_number - _string_ (Required) The serial number which uniquely identifies the MFA device.
	 *	$authentication_code1 - _string_ (Required) An authentication code emitted by the device.
	 *	$authentication_code2 - _string_ (Required) A subsequent authentication code emitted by the device.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function enable_mfa_device($user_name, $serial_number, $authentication_code1, $authentication_code2, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;
		$opt['SerialNumber'] = $serial_number;
		$opt['AuthenticationCode1'] = $authentication_code1;
		$opt['AuthenticationCode2'] = $authentication_code2;

		return $this->authenticate('EnableMFADevice', $opt, $this->hostname);
	}

	/**
	 * Method: list_user_policies()
	 * 	Lists the names of the policies associated with the specified user. If there are none, the action
	 * 	returns an empty list. You can paginate the results using the `MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) The name of the user to list policies for.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of policy names you want in the response. If there are additional policy names beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_user_policies($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('ListUserPolicies', $opt, $this->hostname);
	}

	/**
	 * Method: list_access_keys()
	 * 	Returns information about the Access Key IDs associated with the specified user. If there are none,
	 * 	the action returns an empty list. Although each user is limited to a small number of keys, you can
	 * 	still paginate the results using the `MaxItems` and `Marker` parameters. If the `UserName` field is
	 * 	not specified, the UserName is determined implicitly based on the AWS Access Key ID used to sign the
	 * 	request. Because this action works for access keys under the account, this API can be used to manage
	 * 	root credentials even if the account has no associated users. To ensure the security of your
	 * 	account, the secret access key is accesible only during key and user creation.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) Name of the user.
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of keys you want in the response. If there are additional keys beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_access_keys($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListAccessKeys', $opt, $this->hostname);
	}

	/**
	 * Method: get_login_profile()
	 * 	Retrieves the login profile for the specified user.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user whose login profile you want to retrieve.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_login_profile($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('GetLoginProfile', $opt, $this->hostname);
	}

	/**
	 * Method: list_groups_for_user()
	 * 	Lists the groups the specified user belongs to. You can paginate the results using the `MaxItems`
	 * 	and `Marker` parameters.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) The name of the user to list groups for.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of groups you want in the response. If there are additional groups beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_groups_for_user($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('ListGroupsForUser', $opt, $this->hostname);
	}

	/**
	 * Method: create_group()
	 * 	Creates a new group. For information about the number of groups you can create, see Limitations on
	 * 	AWS IAM Entities in the [ AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group to create. Do not include the path in this value.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Path - _string_ (Optional) The path to the group. For more information about paths, see Identifiers for Users and Groups in the AWS Identity and Access Management User Guide. This parameter is optional. If it is not included, it defaults to /.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_group($group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;

		return $this->authenticate('CreateGroup', $opt, $this->hostname);
	}

	/**
	 * Method: delete_user()
	 * 	Deletes the specified user. The user must not belong to any groups, have any keys or signing
	 * 	certificates, or have any attached policies.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_user($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('DeleteUser', $opt, $this->hostname);
	}

	/**
	 * Method: get_group_policy()
	 * 	Retrieves the specified policy document for the specified group. The returned policy is URL-encoded
	 * 	according to RFC 3986. For more information about RFC 3986, go to
	 * 	http://www.faqs.org/rfcs/rfc3986.html.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group the policy is associated with.
	 *	$policy_name - _string_ (Required) Name of the policy document to get.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_group_policy($group_name, $policy_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;
		$opt['PolicyName'] = $policy_name;

		return $this->authenticate('GetGroupPolicy', $opt, $this->hostname);
	}

	/**
	 * Method: deactivate_mfa_device()
	 * 	Deactivates the specified MFA device and removes it from association with the user for which it was
	 * 	originally enabled.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user whose MFA device you want to deactivate.
	 *	$serial_number - _string_ (Required) The serial number that uniquely identifies the MFA device.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function deactivate_mfa_device($user_name, $serial_number, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;
		$opt['SerialNumber'] = $serial_number;

		return $this->authenticate('DeactivateMFADevice', $opt, $this->hostname);
	}

	/**
	 * Method: remove_user_from_group()
	 * 	Removes the specified user from the specified group.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group to update.
	 *	$user_name - _string_ (Required) Name of the user to remove.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function remove_user_from_group($group_name, $user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;
		$opt['UserName'] = $user_name;

		return $this->authenticate('RemoveUserFromGroup', $opt, $this->hostname);
	}

	/**
	 * Method: list_group_policies()
	 * 	Lists the names of the policies associated with the specified group. If there are none, the action
	 * 	returns an empty list. You can paginate the results using the `MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) The name of the group to list policies for.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of policy names you want in the response. If there are additional policy names beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_group_policies($group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;

		return $this->authenticate('ListGroupPolicies', $opt, $this->hostname);
	}

	/**
	 * Method: create_login_profile()
	 * 	Creates a login profile for the specified user, giving the user the ability to access AWS services
	 * 	such as the AWS Management Console. For more information about login profiles, see Managing Login
	 * 	Profiles and MFA Devices in the [AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user to create a login profile for.
	 *	$password - _string_ (Required) The new password for the user.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_login_profile($user_name, $password, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;
		$opt['Password'] = $password;

		return $this->authenticate('CreateLoginProfile', $opt, $this->hostname);
	}

	/**
	 * Method: create_access_key()
	 * 	Creates a new AWS Secret Access Key and corresponding AWS Access Key ID for the specified user. The
	 * 	default status for new keys is Active. If the `UserName` field is not specified, the UserName is
	 * 	determined implicitly based on the AWS Access Key ID used to sign the request. Because this action
	 * 	works for access keys under the account, this API can be used to manage root credentials even if the
	 * 	account has no associated users. For information about limits on the number of keys you can create,
	 * 	see Limitations on AWS IAM Entities in the [AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/). To ensure the security of your account, the secret
	 * 	access key is accesible only during key and user creation. You must save the key (for example, in a
	 * 	text file) if you want to be able to access it again. If a secret key is lost, you can delete the
	 * 	access keys for the associated user and then create new keys.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) The user that the new key will belong to.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_access_key($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('CreateAccessKey', $opt, $this->hostname);
	}

	/**
	 * Method: get_user()
	 * 	Retrieves information about the specified user, including the user's path, GUID, and ARN. If the
	 * 	`UserName` field is not specified, UserName is determined implicitly based on the AWS Access Key ID
	 * 	used to sign the request.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) Name of the user to get information about. This parameter is optional. If it is not included, it defaults to the user making the request.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_user($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('GetUser', $opt, $this->hostname);
	}

	/**
	 * Method: resync_mfa_device()
	 * 	Synchronizes the specified MFA device with AWS servers.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user whose MFA device you want to resynchronize.
	 *	$serial_number - _string_ (Required) Serial number which uniquely identifies the MFA device.
	 *	$authentication_code1 - _string_ (Required) An authentication code emitted by the device.
	 *	$authentication_code2 - _string_ (Required) A subsequent authentication code emitted by the device.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function resync_mfa_device($user_name, $serial_number, $authentication_code1, $authentication_code2, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;
		$opt['SerialNumber'] = $serial_number;
		$opt['AuthenticationCode1'] = $authentication_code1;
		$opt['AuthenticationCode2'] = $authentication_code2;

		return $this->authenticate('ResyncMFADevice', $opt, $this->hostname);
	}

	/**
	 * Method: list_mfa_devices()
	 * 	Lists the MFA devices associated with the specified user. You can paginate the results using the
	 * 	`MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$user_name - _string_ (Required) Name of the user whose MFA devices you want to list.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of keys you want in the response. If there are additional keys beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_mfa_devices($user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['UserName'] = $user_name;

		return $this->authenticate('ListMFADevices', $opt, $this->hostname);
	}

	/**
	 * Method: update_access_key()
	 * 	Changes the status of the specified access key from Active to Inactive, or vice versa. This action
	 * 	can be used to disable a user's key as part of a key rotation workflow. If the `UserName` field is
	 * 	not specified, the UserName is determined implicitly based on the AWS Access Key ID used to sign the
	 * 	request. Because this action works for access keys under the account, this API can be used to manage
	 * 	root credentials even if the account has no associated users. For information about rotating keys,
	 * 	see Managing Keys and Certificates in the [AWS Identity and Access Management User
	 * 	Guide](http://aws.amazon.com/documentation/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$access_key_id - _string_ (Required) The Access Key ID of the Secret Access Key you want to update.
	 *	$status - _string_ (Required) The status you want to assign to the Secret Access Key. `Active` means the key can be used for API calls to AWS, while `Inactive` means the key cannot be used. [Allowed values: `Active`, `Inactive`]
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	UserName - _string_ (Optional) Name of the user whose key you want to update.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_access_key($access_key_id, $status, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['AccessKeyId'] = $access_key_id;
		$opt['Status'] = $status;

		return $this->authenticate('UpdateAccessKey', $opt, $this->hostname);
	}

	/**
	 * Method: add_user_to_group()
	 * 	Adds the specified user to the specified group.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group to update.
	 *	$user_name - _string_ (Required) Name of the user to add.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_user_to_group($group_name, $user_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;
		$opt['UserName'] = $user_name;

		return $this->authenticate('AddUserToGroup', $opt, $this->hostname);
	}

	/**
	 * Method: get_group()
	 * 	Returns a list of users that are in the specified group. You can paginate the results using the
	 * 	`MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Marker - _string_ (Optional) Use this only when paginating results, and only in a follow-up request after you've received a response where the results are truncated. Set this to the value of the `Marker` element in the response you just received.
	 *	MaxItems - _integer_ (Optional) Use this only when paginating results to indicate the maximum number of users you want in the response. If there are additional users beyond the maximum you specify, the `IsTruncated` response element is `true`.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_group($group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;

		return $this->authenticate('GetGroup', $opt, $this->hostname);
	}

	/**
	 * Method: delete_group()
	 * 	Deletes the specified group. The group must not contain any users or have any attached policies.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$group_name - _string_ (Required) Name of the group to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_group($group_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;

		return $this->authenticate('DeleteGroup', $opt, $this->hostname);
	}
}


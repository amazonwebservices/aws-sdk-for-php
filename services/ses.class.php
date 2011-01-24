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
 * File: AmazonSES
 * 	 *
 * 	This is the API Reference for Amazon Simple Email Service (Amazon SES). This documentation is
 * 	intended to be used in conjunction with the Amazon SES Getting Started Guide and the Amazon SES
 * 	Developer Guide.
 *
 * 	For specific details on how to construct a service request, please consult the Amazon SES Developer
 * 	Guide.
 *
 * Version:
 * 	Mon Jan 24 14:54:19 PST 2011
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon Simple Email Service](http://aws.amazon.com/ses/)
 * 	[Amazon Simple Email Service documentation](http://aws.amazon.com/documentation/ses/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: Email_Exception
 * 	Default Email Exception.
 */
class Email_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonSES
 * 	Container for all service-related methods.
 */
class AmazonSES extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'email.us-east-1.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = self::DEFAULT_URL;

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'email.us-west-1.amazonaws.com';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'email.eu-west-1.amazonaws.com';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'email.ap-southeast-1.amazonaws.com';


	/*%******************************************************************************************%*/
	// PROPERTIES

	/**
	 * Property: authenticate
	 * 	The authentication method to use (defaults to <authenticate_v3()>).
	 */
	public $authenticate = 'authenticate_v3';


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

	/**
	 * Method: disable_ssl()
	 * 	Throws an error because SSL is required for the Amazon Email Service.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	void
	 */
	public function disable_ssl()
	{
		throw new Email_Exception('SSL/HTTPS is REQUIRED for Amazon Email Service and cannot be disabled.');
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonEmail>.
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
			throw new Email_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new Email_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: get_send_quota()
	 * 	Returns the user's current activity limits.
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
	public function get_send_quota($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('GetSendQuota', $opt, $this->hostname, 3);
	}

	/**
	 * Method: list_verified_email_addresses()
	 * 	Returns a list containing all of the email addresses that have been verified.
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
	public function list_verified_email_addresses($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListVerifiedEmailAddresses', $opt, $this->hostname, 3);
	}

	/**
	 * Method: get_send_statistics()
	 * 	Returns the user's sending statistics. The result is a list of data points, representing the last
	 * 	two weeks of sending activity.
	 *
	 * 	Each data point in the list contains statistics for a 15-minute interval.
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
	public function get_send_statistics($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('GetSendStatistics', $opt, $this->hostname, 3);
	}

	/**
	 * Method: send_email()
	 * 	Composes an email message, based on input data, and then immediately queues the message for sending.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$source - _string_ (Required) The sender's email address.
	 *	$destination - _ComplexType_ (Required) The destination for this email, composed of To:, From:, and CC: fields. A required ComplexType is a set of key-value pairs which must be set by passing an associative array with certain entries as keys. See below for a list.
	 *	$message - _ComplexType_ (Required) The message to be sent. A required ComplexType is a set of key-value pairs which must be set by passing an associative array with certain entries as keys. See below for a list.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $destination parameter:
	 *	ToAddresses - _string_|_array_ (Optional) The To: field(s) of the message. Pass a string for a single value, or an indexed array for multiple values.
	 *	CcAddresses - _string_|_array_ (Optional) The CC: field(s) of the message. Pass a string for a single value, or an indexed array for multiple values.
	 *	BccAddresses - _string_|_array_ (Optional) The BCC: field(s) of the message. Pass a string for a single value, or an indexed array for multiple values.
	 *
	 * Keys for the $message parameter:
	 *	Subject.Data - _string_ (Required) The textual data of the content.
	 *	Subject.Charset - _string_ (Optional) The character set of the content.
	 *	Body.Text.Data - _string_ (Required) The textual data of the content.
	 *	Body.Text.Charset - _string_ (Optional) The character set of the content.
	 *	Body.Html.Data - _string_ (Required) The textual data of the content.
	 *	Body.Html.Charset - _string_ (Optional) The character set of the content.
	 *
	 * Keys for the $opt parameter:
	 *	ReplyToAddresses - _string_|_array_ (Optional) The reply-to email address(es) for the message. If the recipient replies to the message, each reply-to address will receive the reply. Pass a string for a single value, or an indexed array for multiple values.
	 *	ReturnPath - _string_ (Optional) The email address to which bounce notifications are to be forwarded. If the message cannot be delivered to the recipient, then an error message will be returned from the recipient's ISP; this message will then be forwarded to the email address specified by the ReturnPath parameter.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function send_email($source, $destination, $message, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Source'] = $source;

		// Collapse these list values for the required parameter
		if (isset($destination['ToAddresses']))
		{
			$destination['ToAddresses'] = CFComplexType::map(array(
				'member' => (is_array($destination['ToAddresses']) ? $destination['ToAddresses'] : array($destination['ToAddresses']))
			));
		}

		// Collapse these list values for the required parameter
		if (isset($destination['CcAddresses']))
		{
			$destination['CcAddresses'] = CFComplexType::map(array(
				'member' => (is_array($destination['CcAddresses']) ? $destination['CcAddresses'] : array($destination['CcAddresses']))
			));
		}

		// Collapse these list values for the required parameter
		if (isset($destination['BccAddresses']))
		{
			$destination['BccAddresses'] = CFComplexType::map(array(
				'member' => (is_array($destination['BccAddresses']) ? $destination['BccAddresses'] : array($destination['BccAddresses']))
			));
		}

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'Destination' => (is_array($destination) ? $destination : array($destination))
		), 'member'));

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'Message' => (is_array($message) ? $message : array($message))
		), 'member'));

		// Optional parameter
		if (isset($opt['ReplyToAddresses']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ReplyToAddresses' => (is_array($opt['ReplyToAddresses']) ? $opt['ReplyToAddresses'] : array($opt['ReplyToAddresses']))
			), 'member'));
			unset($opt['ReplyToAddresses']);
		}

		return $this->authenticate('SendEmail', $opt, $this->hostname, 3);
	}

	/**
	 * Method: delete_verified_email_address()
	 * 	Deletes the specified email address from the list of verified addresses.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$email_address - _string_ (Required) An email address to be removed from the list of verified addreses.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_verified_email_address($email_address, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['EmailAddress'] = $email_address;

		return $this->authenticate('DeleteVerifiedEmailAddress', $opt, $this->hostname, 3);
	}

	/**
	 * Method: verify_email_address()
	 * 	Begins the process of email address verification. This action causes a confirmation email message to
	 * 	be sent to the specified address.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$email_address - _string_ (Required) The email address to be verified.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function verify_email_address($email_address, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['EmailAddress'] = $email_address;

		return $this->authenticate('VerifyEmailAddress', $opt, $this->hostname, 3);
	}

	/**
	 * Method: send_raw_email()
	 * 	Sends an email message, with header and content specified by the client. The SendRawEmail action is
	 * 	useful for sending multipart MIME emails, with attachments or inline content.
	 *
	 * 	The raw text of the message must comply with Internet email standards; otherwise, the message
	 * 	cannot be sent.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$raw_message - _ComplexType_ (Required) The raw text of the message. The client is responsible for ensuring the following: Message must contain a header and a body, separated by a blank line.; All required header fields must be present.; Each part of a multipart MIME message must be formatted properly.; MIME content types must be among those supported by Amazon SES. Refer to the Amazon SES Developer Guide for more details. ; Content must be base64-encoded, if MIME requires it.. A required ComplexType is a set of key-value pairs which must be set by passing an associative array with certain entries as keys. See below for a list.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $raw_message parameter:
	 *	Data - _blob_ (Required) The raw data of the message. The client must ensure that the message format complies with Internet email standards surrounding email header fields, MIME types, MIME encoding, and base64 encoding (if necessary).
	 *
	 * Keys for the $opt parameter:
	 *	Source - _string_ (Optional) The sender's email address.
	 *	Destinations - _string_|_array_ (Optional) A list of destinations for the message. Pass a string for a single value, or an indexed array for multiple values.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function send_raw_email($raw_message, $opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['Destinations']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Destinations' => (is_array($opt['Destinations']) ? $opt['Destinations'] : array($opt['Destinations']))
			), 'member'));
			unset($opt['Destinations']);
		}

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'RawMessage' => (is_array($raw_message) ? $raw_message : array($raw_message))
		), 'member'));

		return $this->authenticate('SendRawEmail', $opt, $this->hostname, 3);
	}
}


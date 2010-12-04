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
 * File: AmazonSNS
 *
 *
 * Version:
 * 	Fri Dec 03 16:27:54 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon Simple Notification Service](http://aws.amazon.com/sns/)
 * 	[Amazon Simple Notification Service documentation](http://aws.amazon.com/documentation/sns/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: SNS_Exception
 * 	Default SNS Exception.
 */
class SNS_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonSNS
 * 	Container for all service-related methods.
 */
class AmazonSNS extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'sns.us-east-1.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = self::DEFAULT_URL;

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'sns.us-west-1.amazonaws.com';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'sns.eu-west-1.amazonaws.com';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'sns.ap-southeast-1.amazonaws.com';


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
	// CONVENIENCE METHODS

	/**
	 * Method: get_topic_list()
	 * 	Gets a simple list of Topic ARNs.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the names against.
	 *
	 * Returns:
	 * 	_array_ A list of Topic ARNs.
	 *
	 * See Also:
	 * 	[Perl-Compatible Regular Expression (PCRE) Docs](http://php.net/pcre)
	 */
	public function get_topic_list($pcre = null)
	{
		if ($this->use_batch_flow)
		{
			throw new SNS_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		// Get a list of topics.
		$list = $this->list_topics();
		if ($list = $list->body->TopicArn())
		{
			$list = $list->map_string($pcre);
			return $list;
		}

		return array();
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonSNS>.
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
		$this->api_version = '2010-03-31';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new SNS_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new SNS_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: confirm_subscription()
	 * 	The ConfirmSubscription action verifies an endpoint owner's intent to receive messages by validating
	 * 	the token sent to the endpoint by an earlier Subscribe action. If the token is valid, the action
	 * 	creates a new subscription and returns its Amazon Resource Name (ARN). This call requires an AWS
	 * 	signature only when the AuthenticateOnUnsubscribe flag is set to "true".
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of the topic for which you wish to confirm a subscription.
	 *	$token - _string_ (Required) Short-lived token sent to an endpoint during the Subscribe action.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	AuthenticateOnUnsubscribe - _string_ (Optional) Indicates that you want to disable unauthenticated unsubsciption of the subscription. If parameter is present in the request, the request has an AWS signature, and the value of this parameter is true, only the topic owner and the subscription owner will be permitted to unsubscribe the endopint, and the Unsubscribe action will require AWS authentication.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function confirm_subscription($topic_arn, $token, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;
		$opt['Token'] = $token;

		return $this->authenticate('ConfirmSubscription', $opt, $this->hostname);
	}

	/**
	 * Method: get_topic_attributes()
	 * 	The GetTopicAttribtues action returns all of the properties of a topic customers have created. Topic
	 * 	properties returned might differ based on the authorization of the user.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of the topic whose properties you want to get.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_topic_attributes($topic_arn, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;

		return $this->authenticate('GetTopicAttributes', $opt, $this->hostname);
	}

	/**
	 * Method: subscribe()
	 * 	The Subscribe action prepares to subscribe an endpoint by sending the endpoint a confirmation
	 * 	message. To actually create a subscription, the endpoint owner must call the ConfirmSubscription
	 * 	action with the token from the confirmation message. Confirmation tokens are valid for twenty-four
	 * 	hours.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of topic you want to subscribe to.
	 *	$protocol - _string_ (Required) The protocol you want to use. Supported protocols include: http -- delivery of JSON-encoded message via HTTP POST; https -- delivery of JSON-encoded message via HTTPS POST; email -- delivery of message via SMTP; email-json -- delivery of JSON-encoded message via SMTP; sqs -- delivery of JSON-encoded message to an Amazon SQS queue.
	 *	$endpoint - _string_ (Required) The endpoint that you want to receive notifications. Endpoints vary by protocol: For the http protocol, the endpoint is an URL beginning with "http://"; For the https protocol, the endpoint is a URL beginning with "https://"; For the email protocol, the endpoint is an e-mail address; For the email-json protocol, the endpoint is an e-mail address; For the sqs protocol, the endpoint is the ARN of an Amazon SQS queue.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function subscribe($topic_arn, $protocol, $endpoint, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;
		$opt['Protocol'] = $protocol;
		$opt['Endpoint'] = $endpoint;

		return $this->authenticate('Subscribe', $opt, $this->hostname);
	}

	/**
	 * Method: set_topic_attributes()
	 * 	The SetTopicAttributes action allows a topic owner to set an attribute of the topic to a new value.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of the topic to modify.
	 *	$attribute_name - _string_ (Required) The name of the attribute you want to set. Only a subset of the topic's attributes are mutable.
	 *	$attribute_value - _string_ (Required) The new value for the attribute.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function set_topic_attributes($topic_arn, $attribute_name, $attribute_value, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;
		$opt['AttributeName'] = $attribute_name;
		$opt['AttributeValue'] = $attribute_value;

		return $this->authenticate('SetTopicAttributes', $opt, $this->hostname);
	}

	/**
	 * Method: delete_topic()
	 * 	The DeleteTopic action deletes a topic and all its subscriptions. Deleting a topic might prevent
	 * 	some messages previously sent to the topic from being delivered to subscribers. This action is
	 * 	idempotent, so deleting a topic that does not exist will not result in an error.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of the topic you want to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_topic($topic_arn, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;

		return $this->authenticate('DeleteTopic', $opt, $this->hostname);
	}

	/**
	 * Method: remove_permission()
	 * 	The RemovePermission action removes a statement from a topic's access control policy.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of the topic whose access control policy you wish to modify.
	 *	$label - _string_ (Required) The unique label of the statement you want to remove.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function remove_permission($topic_arn, $label, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;
		$opt['Label'] = $label;

		return $this->authenticate('RemovePermission', $opt, $this->hostname);
	}

	/**
	 * Method: list_subscriptions()
	 * 	The ListSubscriptions action returns a list of the requester's subscriptions. Each call returns a
	 * 	limited list of subscriptions. If there are more subscriptions, a NextToken is also returned. Use
	 * 	the NextToken parameter in a new ListSubscriptions call to get further results.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	NextToken - _string_ (Optional) Token returned by the previous ListSubscriptions request.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_subscriptions($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListSubscriptions', $opt, $this->hostname);
	}

	/**
	 * Method: add_permission()
	 * 	The AddPermission action adds a statement to a topic's access control policy, granting access for
	 * 	the specified AWS accounts to the specified actions.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of the topic whose access control policy you wish to modify.
	 *	$label - _string_ (Required) A unique identifier for the new policy statement.
	 *	$account_id - _string_|_array_ (Required) The AWS account IDs of the users (principals) who will be given access to the specified actions. The users must have AWS accounts, but do not need to be signed up for this service. Pass a string for a single value, or an indexed array for multiple values.
	 *	$action_name - _string_|_array_ (Required) The action you want to allow for the specified principal(s). Pass a string for a single value, or an indexed array for multiple values.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function add_permission($topic_arn, $label, $account_id, $action_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;
		$opt['Label'] = $label;

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'AWSAccountId' => (is_array($account_id) ? $account_id : array($account_id))
		), 'member'));

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'ActionName' => (is_array($action_name) ? $action_name : array($action_name))
		), 'member'));

		return $this->authenticate('AddPermission', $opt, $this->hostname);
	}

	/**
	 * Method: create_topic()
	 * 	The CreateTopic action creates a topic to which notifications can be published. Users can create at
	 * 	most 25 topics. This action is idempotent, so if the requester already owns a topic with the
	 * 	specified name, that topic's ARN will be returned without creating a new topic.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$name - _string_ (Required) The name of the topic you want to create. Constraints: Topic names must be made up of only uppercase and lowercase ASCII letters, numbers, and hyphens, and must be between 1 and 256 characters long.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_topic($name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Name'] = $name;

		return $this->authenticate('CreateTopic', $opt, $this->hostname);
	}

	/**
	 * Method: list_topics()
	 * 	The ListTopics action returns a list of the requester's topics. Each call returns a limited list of
	 * 	topics. If there are more topics, a NextToken is also returned. Use the NextToken parameter in a new
	 * 	ListTopics call to get further results.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	NextToken - _string_ (Optional) Token returned by the previous ListTopics request.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_topics($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListTopics', $opt, $this->hostname);
	}

	/**
	 * Method: unsubscribe()
	 * 	The Unsubscribe action deletes a subscription. If the subscription requires authentication for
	 * 	deletion, only the owner of the subscription or the its topic's owner can unsubscribe, and an AWS
	 * 	signature is required. If the Unsubscribe call does not require authentication and the requester is
	 * 	not the subscription owner, a final cancellation message is delivered to the endpoint, so that the
	 * 	endpoint owner can easily resubscribe to the topic if the Unsubscribe request was unintended.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$subscription_arn - _string_ (Required) The ARN of the subscription to be deleted.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function unsubscribe($subscription_arn, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['SubscriptionArn'] = $subscription_arn;

		return $this->authenticate('Unsubscribe', $opt, $this->hostname);
	}

	/**
	 * Method: list_subscriptions_by_topic()
	 * 	The ListSubscriptionsByTopic action returns a list of the subscriptions to a specific topic. Each
	 * 	call returns a limited list of subscriptions. If there are more subscriptions, a NextToken is also
	 * 	returned. Use the NextToken parameter in a new ListSubscriptionsByTopic call to get further results.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The ARN of the topic for which you wish to find subscriptions.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	NextToken - _string_ (Optional) Token returned by the previous ListSubscriptionsByTopic request.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_subscriptions_by_topic($topic_arn, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;

		return $this->authenticate('ListSubscriptionsByTopic', $opt, $this->hostname);
	}

	/**
	 * Method: publish()
	 * 	The Publish action sends a message to all of a topic's subscribed endpoints. When a messageId is
	 * 	returned, the message has been saved and Amazon SNS will attempt to deliver it to the topic's
	 * 	subscribers shortly. The format of the outgoing message to each subscribed endpoint depends on the
	 * 	notification protocol selected.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$topic_arn - _string_ (Required) The topic you want to publish to.
	 *	$message - _string_ (Required) The message you want to send to the topic. Constraints: Messages must be UTF-8 encoded strings at most 8 KB in size (8192 bytes, not 8192 characters).
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	Subject - _string_ (Optional) Optional parameter to be used as the "Subject" line of when the message is delivered to e-mail endpoints. This field will also be included, if present, in the standard JSON messages delivered to other endpoints. Constraints: Subjects must be ASCII text that begins with a letter, number or punctuation mark; must not include line breaks or control characters; and must be less than 100 characters long.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function publish($topic_arn, $message, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['TopicArn'] = $topic_arn;
		$opt['Message'] = $message;

		return $this->authenticate('Publish', $opt, $this->hostname);
	}
}


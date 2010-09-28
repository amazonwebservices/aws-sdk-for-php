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
 * File: CFPolicy
 * 	Contains methods used for signing policy JSON documents.
 *
 * Version:
 * 	2010.08.31
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[PHP Developer Center](http://aws.amazon.com/php/)
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CFPolicy
 * 	Namespace for methods used for generating policy documents.
 */
class CFPolicy
{
	/**
	 * Property: auth
	 * 	Stores the object that contains the authentication credentials.
	 */
	public $auth;

	/**
	 * Property: json_policy
	 * 	Stores the policy object that we're working with.
	 */
	public $json_policy;

	/**
	 * Method: __construct()
	 * 	Constructs the object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$auth - _object_ (Required) An instance of any authenticated AWS object (e.g. `AmazonEC2`, `AmazonS3`).
	 * 	$policy - _string_|_array_ (Required) The associative array representing the S3 policy to use, or a string of JSON content.
	 *
	 * Returns:
	 * 	`$this`
	 *
	 * See Also:
	 * 	- [S3 Policies](http://docs.amazonwebservices.com/AmazonS3/2006-03-01/dev/index.html?HTTPPOSTForms.html)
	 * 	- [Access Policy Language](http://docs.amazonwebservices.com/AmazonS3/latest/dev/index.html?AccessPolicyLanguage.html)
	 */
	public function __construct($auth, $policy)
	{
		$this->auth = $auth;

		if (is_array($policy)) // We received an associative array...
		{
			$this->json_policy = json_encode($policy);
		}
		else // We received a valid, parseable JSON string...
		{
			$this->json_policy = json_encode(json_decode($policy, true));
		}

		return $this;
	}

	/**
	 * Method: get_key()
	 * 	Get the key from the authenticated instance.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	string The key from the authenticated instance.
	 */
	public function get_key()
	{
		return $this->auth->key;
	}

	/**
	 * Method: get_policy()
	 * 	Base64-encodes the JSON string.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	string The Base64-encoded version of the JSON string.
	 */
	public function get_policy()
	{
		return base64_encode($this->json_policy);
	}

	/**
	 * Method: get_json()
	 * 	Gets the JSON string with the whitespace removed.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	string The JSON string without extraneous whitespace.
	 */
	public function get_json()
	{
		return $this->json_policy;
	}

	/**
	 * Method: get_policy_signature()
	 * 	Gets the JSON string with the whitespace removed.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	string The Base64-encoded, signed JSON string.
	 */
	public function get_policy_signature()
	{
		return base64_encode(hash_hmac('sha1', $this->get_policy(), $this->auth->secret_key));
	}

	/**
	 * Method: decode_policy()
	 * 	Decode a policy that was returned from the service.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	string The Base64-encoded, signed JSON string.
	 */
	public static function decode_policy($response)
	{
		return json_decode(urldecode($response), true);
	}
}

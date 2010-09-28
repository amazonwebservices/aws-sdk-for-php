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
 * File: CFRequest
 * 	Wrapper for RequestCore with enhanced functionality.
 *
 * Version:
 * 	2010.07.30
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
 * Class: CFRequest
 * 	Wrapper for RequestCore with enhanced functionality.
 */
class CFRequest extends RequestCore
{
	/**
	 * Property: request_class
	 * 	The default class to use for HTTP Requests (defaults to <CFRequest>).
	 */
	public $request_class = 'CFRequest';

	/**
	 * Property: response_class
	 * 	The default class to use for HTTP Responses (defaults to <CFResponse>).
	 */
	public $response_class = 'CFResponse';


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$url - _string_ (Optional) The URL to request or service endpoint to query.
	 * 	$proxy - _string_ (Optional) The faux-url to use for proxy settings. Takes the following format: `proxy://user:pass@hostname:port`
	 * 	$helpers - _array_ (Optional) An associative array of classnames to use for request, and response functionality. Gets passed in automatically by the calling class.
	 *
	 * Returns:
	 * 	`$this`
	 */
	public function __construct($url = null, $proxy = null, $helpers = null)
	{
		parent::__construct($url, $proxy, $helpers);

		// Standard settings for all requests
		$this->add_header('Expect', '100-continue');
		$this->set_useragent(CFRUNTIME_USERAGENT);

		return $this;
	}
}

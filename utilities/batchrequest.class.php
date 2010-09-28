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
 * File: CFBatchRequest
 * 	Handle batch request queues.
 *
 * Version:
 * 	2010.08.09
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[PHP Developer Center](http://aws.amazon.com/php/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: CFBatchRequest
 * 	Default CFBatchRequest Exception.
 */
class CFBatchRequest_Exception extends Exception {}


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CFBatchRequest
 * 	Handle batch request queues.
 */
class CFBatchRequest extends CFRuntime
{
	/**
	 * Property: queue
	 * 	Stores the cURL handles that are to be processed.
	 */
	public $queue;

	/**
	 * Property: limit
	 * 	Stores the size of the request window.
	 */
	public $limit;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$limit - _integer_ (Optional) The size of the request window. Defaults to unlimited.
	 *
	 * Returns:
	 * 	boolean FALSE if no valid values are set, otherwise TRUE.
	 */
	public function __construct($limit = null)
	{
		$this->queue = array();
		$this->limit = $limit ? $limit : -1;
		return $this;
	}

	/**
	 * Method: add()
	 * 	Adds a new cURL handle to the queue.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$handle - _resource_ (Required) A cURL resource to add to the queue.
	 *
	 * Returns:
	 * 	`$this`
	 */
	public function add($handle)
	{
		$this->queue[] = $handle;
		return $this;
	}

	/**
	 * Method: send()
	 * 	Sends the batch request queue.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_array_ An indexed array of <CFResponse> objects.
	 */
	public function send($opt = null)
	{
		$http = new $this->request_class();

		// Make the request
		$response = $http->send_multi_request($this->queue, array(
			'limit' => $this->limit
		));

		return $response;
	}
}

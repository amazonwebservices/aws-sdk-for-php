<?php
/*
 * Copyright 2010-2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *	http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */


/*%******************************************************************************************%*/
// INTERFACE

/**
 * The interface implemented by all signing classes.
 *
 * @version 2011.11.22
 * @license See the included NOTICE.md file for more information.
 * @copyright See the included NOTICE.md file for more information.
 * @link http://aws.amazon.com/php/ PHP Developer Center
 */
interface Signable
{
	/**
	 * Constructs a new instance of the implementing class.
	 *
	 * @param string $endpoint (Required) The endpoint to direct the request to.
	 * @param string $operation (Required) The operation to execute as a result of this request.
	 * @param array $payload (Required) The options to use as part of the payload in the request.
	 * @param CFCredential $credentials (Required) The credentials to use for signing and making requests.
	 * @return void
	 */
	public function __construct($endpoint, $operation, $payload, CFCredential $credentials);

	/**
	 * Generates a cURL handle with all of the required authentication bits set.
	 *
	 * @return resource A cURL handle ready for executing.
	 */
	public function authenticate();
}

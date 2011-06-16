#!/usr/bin/php
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

/*
	PREREQUISITES:
	In order to run this sample, I'll assume a few things:

	* You already have a valid Amazon Web Services developer account, and are
	  signed up to use Amazon Route 53 <http://aws.amazon.com/route53/>.

	* You already understand the fundamentals of object-oriented PHP.

	* You've verified that your PHP environment passes the SDK Compatibility Test.

	* You've already added your credentials to your config.inc.php file, as per the
	  instructions in the Getting Started Guide.

	TO RUN:
	* Run this file on your web server by loading it in your browser, OR...
	* Run this file from the command line with `php cli-r53_list_rrset.php`.
*/

/*%******************************************************************************************%*/
// SETUP

	// Enable full-blown error reporting. http://twitter.com/rasmus/status/7448448829
	error_reporting(-1);

	// Set HTML headers
	header("Content-type: text/html; charset=utf-8");

	// Include the SDK
	require_once '../../sdk.class.php';
	
/*%******************************************************************************************%*/
// LIST RESOURCE RECORD SETS

	$route53 = new AmazonRoute53();
	
	// You should replace this with a real Zone ID
	$zone_id = 'Z1PA6795UKMFR9';
	
	// Possible options. Reference: http://docs.amazonwebservices.com/Route53/latest/APIReference/API_ListResourceRecordSets.html
	$opt = array(
		'Name' => 'example.com',
		'Type' => 'NS',
		'Identifier' => 'SetIdentifier',
		'MaxItems' => 10 // default: 100
	);
	
	// Send request!
	$response = $route53->list_rrset($zone_id); // Pass only the zone ID
	
	// Display
	print_r($response);

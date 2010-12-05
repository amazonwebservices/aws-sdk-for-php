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
 * File: CFManifest
 * 	Provides information about the SDK.
 *
 * Version:
 * 	2010.11.22
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
 * Class: CFManifest
 * 	Provides information about the SDK.
 */
class CFManifest
{
	/**
	 * Method: json()
	 * 	Takes a JSON object as a string to convert to a YAML manifest.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$json - _string_ (Required) A JSON object.
	 *
	 * Returns:
	 * 	_string_ A YAML manifest document.
	 */
	public static function json($json)
	{
		$map = json_decode($json, true);
		return sfYaml::dump($map);
	}

	/**
	 * Method: map()
	 * 	Takes an associative array to convert to a YAML manifest.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$map - _array_ (Required) An associative array.
	 *
	 * Returns:
	 * 	_string_ A YAML manifest document.
	 */
	public static function map($map)
	{
		return sfYaml::dump($map);
	}
}

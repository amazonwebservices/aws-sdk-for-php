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
 * File: CFInfo
 * 	Provides information about the SDK.
 *
 * Version:
 * 	2010.10.01
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
 * Class: CFInfo
 * 	Provides information about the SDK.
 */
class CFInfo
{
	/**
	 * Method: api_support()
	 * 	Gets information about the web service APIs that the SDK supports.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_array_ An associative array containing service classes and API versions.
	 */
	public static function api_support()
	{
		$existing_classes = get_declared_classes();

		foreach (glob(dirname(dirname(__FILE__)) . '/services/*.class.php') as $file)
		{
			include $file;
		}

		$with_sdk_classes = get_declared_classes();
		$new_classes = array_diff($with_sdk_classes, $existing_classes);
		$filtered_classes = array();
		$collect = array();

		foreach ($new_classes as $class)
		{
			if (strpos($class, 'Amazon') !== false)
			{
				$filtered_classes[] = $class;
			}
		}

		$filtered_classes = array_values($filtered_classes);

		foreach ($filtered_classes as $class)
		{
			$obj = new $class();
			$collect[get_class($obj)] = $obj->api_version;
			unset($obj);
		}

		return $collect;
	}
}

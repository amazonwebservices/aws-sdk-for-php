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
 * File: CFComplexType
 * 	Contains methods used for converting array, JSON, and YAML data into query string keys.
 *
 * Version:
 * 	2010.08.12
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
 * Class: CFComplexType
 * 	Namespace for static methods used for configuration across services.
 */
class CFComplexType
{
	/**
	 * Method: json()
	 * 	Takes a JSON object, as a string, to convert to query string keys.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$json - _string_ (Required) A JSON object.
	 *
	 * Returns:
	 * 	array The option group parameters to merge into `$opt`.
	 */
	public static function json($json, $default_key = '')
	{
		return self::option_group(json_decode($json, true), $default_key);
	}

	/**
	 * Method: yaml()
	 * 	Takes a YAML object, as a string, to convert to query string keys.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$yaml - _string_ (Required) A YAML object.
	 *
	 * Returns:
	 * 	array The option group parameters to merge into `$opt`.
	 */
	public static function yaml($yaml, $default_key = '')
	{
		return self::option_group(sfYaml::load($yaml), $default_key);
	}

	/**
	 * Method: map()
	 * 	Takes an associative array to convert to query string keys.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$map - _array_ (Required) An associative array.
	 *
	 * Returns:
	 * 	array The option group parameters to merge into `$opt`.
	 */
	public static function map($map, $default_key = '')
	{
		return self::option_group($map, $default_key);
	}

	/**
	 * Method: option_group()
	 * 	A private method that is used by <json()>, <yaml()> and <map()>.
	 *
	 * Access:
	 * 	private
	 *
	 * Parameters:
	 * 	$data - _string_|_array_ (Required) The data to iterate over.
	 * 	$key - _string_ (Optional) The default key to use when the value for `$data` is a string. Also used internally for keeping track of the key during recursion. Defaults to an empty string.
	 * 	$out - _array_ (Optional) INTERNAL ONLY. The array that contains the calculated values up to this point.
	 *
	 * Return:
	 * 	_array_ An array of keys that can be passed to the internal `$opt` variable.
	 */
	private static function option_group($data, $key = '', &$out = array())
	{
		$reset = $key;

		if (is_array($data))
		{
			foreach ($data as $k => $v)
			{
				// Avoid 0-based indexes.
				if (is_int($k))
				{
					$k = $k + 1;
				}

				$key .= (($key === '') ? $k : '.' . $k);

				if (is_array($v))
				{
					self::option_group($v, $key, $out);
				}
				else
				{
					$out[$key] = $v;
				}

				$key = $reset;
			}
		}
		else
		{
			$out[$key] = $data;
		}

		return $out;
	}
}

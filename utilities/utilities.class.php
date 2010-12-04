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
 * File: CFUtilities
 * 	Utilities for connecting to, and working with, AWS.
 *
 * Version:
 * 	2010.09.30
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
 * Class: CFUtilities
 * 	Container for all utility-related methods.
 */
class CFUtilities
{

	/*%******************************************************************************************%*/
	// CONSTANTS

	/**
	 * Constant: DATE_FORMAT_RFC2616
	 * 	Define the RFC 2616-compliant date format.
	 */
	const DATE_FORMAT_RFC2616 = 'D, d M Y H:i:s \G\M\T';

	/**
	 * Constant: DATE_FORMAT_ISO8601
	 * 	Define the ISO-8601-compliant date format.
	 */
	const DATE_FORMAT_ISO8601 = 'Y-m-d\TH:i:s\Z';

	/**
	 * Constant: DATE_FORMAT_MYSQL
	 * 	Define the MySQL-compliant date format.
	 */
	const DATE_FORMAT_MYSQL = 'Y-m-d H:i:s';


	/*%******************************************************************************************%*/
	// METHODS

	/**
	 * Method: __construct()
	 * 	The constructor.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	<CFUtilities> object
	 */
	public function __construct()
	{
		return $this;
	}

	/**
	 * Method: konst()
	 * 	Retrieves the value of a class constant, while avoiding the `T_PAAMAYIM_NEKUDOTAYIM` error. Misspelled because `const` is a reserved word.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$class - _object_ (Required) An instance of the class containing the constant.
	 * 	$const - _string_ (Required) The name of the constant to retrieve.
	 *
	 * Returns:
	 * 	_mixed_ The value of the class constant.
	 */
	public function konst($class, $const)
	{
		if (is_string($class))
		{
			$ref = new ReflectionClass($class);
		}
		else
		{
			$ref = new ReflectionObject($class);
		}

		return $ref->getConstant($const);
	}

	/**
	 * Method: hex_to_base64()
	 *   Convert a HEX value to Base64.
	 *
	 * Access:
	 *   public
	 *
	 * Parameters:
	 *   $str - _string_ (Required) Value to convert.
	 *
	 * Returns:
	 *   _string_ Base64-encoded string.
	 */
	public function hex_to_base64($str)
	{
		$raw = '';

		for ($i = 0; $i < strlen($str); $i += 2)
		{
			$raw .= chr(hexdec(substr($str, $i, 2)));
		}

		return base64_encode($raw);
	}

	/**
	 * Method: to_query_string()
	 * 	Convert an associative array into a query string.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$array - _array_ (Required) Array to convert.
	 *
	 * Returns:
	 * 	_string_ URL-friendly query string.
	 */
	public function to_query_string($array)
	{
		$temp = array();

		foreach ($array as $key => $value)
		{
			$temp[] = rawurlencode($key) . '=' . rawurlencode($value);
		}

		return implode('&', $temp);
	}

	/**
	 * Method: to_signable_string()
	 * 	Convert an associative array into a sign-able string.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$array - _array_ (Required) Array to convert.
	 *
	 * Returns:
	 * 	_string_ URL-friendly sign-able string.
	 */
	public function to_signable_string($array)
	{
		$t = array();

		foreach ($array as $k => $v)
		{
			$t[] = $this->encode_signature2($k) . '=' . $this->encode_signature2($v);
		}

		return implode('&', $t);
	}

	/**
	 * Method: encode_signature2()
	 * 	Encode the value according to RFC 3986.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$string - _string_ (Required) String to convert
	 *
	 * Returns:
	 * 	_string_ URL-friendly sign-able string.
	 */
	public function encode_signature2($string)
	{
		$string = rawurlencode($string);
		return str_replace('%7E', '~', $string);
	}

	/**
	 * Method: query_to_array()
	 * 	Convert a query string into an associative array. Multiple, identical keys will become an indexed array.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$qs - _string_ (Required) Query string to convert.
	 *
	 * Returns:
	 * 	_array_ Associative array of keys and values.
	 */
	public function query_to_array($qs)
	{
		$query = explode('&', $qs);
		$data = array();

		foreach ($query as $q)
		{
			$q = explode('=', $q);

			if (isset($data[$q[0]]) && is_array($data[$q[0]]))
			{
				$data[$q[0]][] = urldecode($q[1]);
			}
			else if (isset($data[$q[0]]) && !is_array($data[$q[0]]))
			{
				$data[$q[0]] = array($data[$q[0]]);
				$data[$q[0]][] = urldecode($q[1]);
			}
			else
			{
				$data[urldecode($q[0])] = urldecode($q[1]);
			}
		}
		return $data;
	}

	/**
	 * Method: size_readable()
	 * 	Return human readable file sizes.
	 *
	 * Author:
	 * 	Aidan Lister <aidan@php.net>
	 * 	Ryan Parman <ryan@getcloudfusion.com>
	 *
	 * Access:
	 * 	public
	 *
	 * License:
	 * 	[PHP License](http://www.php.net/license/3_01.txt)
	 *
	 * Parameters:
	 * 	$size - _integer_ (Required) Filesize in bytes.
	 * 	$unit - _string_ (Optional) The maximum unit to use. Defaults to the largest appropriate unit.
	 * 	$default - _string_ (Optional) The format for the return string. Defaults to '%01.2f %s'
	 *
	 * Returns:
	 * 	_string_ The human-readable file size.
	 *
	 * See Also:
	 * 	Original Function - http://aidanlister.com/repos/v/function.size_readable.php
	 */
	public function size_readable($size, $unit = null, $default = null)
	{
		// Units
		$sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB');
		$mod = 1024;
		$ii = count($sizes) - 1;

		// Max unit
		$unit = array_search((string) $unit, $sizes);
		if ($unit === null || $unit === false)
		{
			$unit = $ii;
		}

		// Return string
		if ($default === null)
		{
			$default = '%01.2f %s';
		}

		// Loop
		$i = 0;
		while ($unit != $i && $size >= 1024 && $i < $ii)
		{
			$size /= $mod;
			$i++;
		}

		return sprintf($default, $size, $sizes[$i]);
	}

	/**
	 * Method: time_hms()
	 * 	Convert a number of seconds into Hours:Minutes:Seconds.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$seconds - _integer_ (Required) The number of seconds to convert.
	 *
	 * Returns:
	 * 	_string_ The formatted time.
	 */
	public function time_hms($seconds)
	{
		$time = '';

		// First pass
		$hours = (int) ($seconds / 3600);
		$seconds = $seconds % 3600;
		$minutes = (int) ($seconds / 60);
		$seconds = $seconds % 60;

		// Cleanup
		$time .= ($hours) ? $hours . ':' : '';
		$time .= ($minutes < 10 && $hours > 0) ? '0' . $minutes : $minutes;
		$time .= ':';
		$time .= ($seconds < 10) ? '0' . $seconds : $seconds;

		return $time;
	}

	/**
	 * Method: try_these()
	 * 	Returns the first value that is set. Based on [Try.these()](http://api.prototypejs.org/language/try/these/) from [Prototype](http://prototypejs.org).
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$attrs - _array_ (Required) The attributes to test, as strings. Intended for testing properties of the $base object, but also works with variables if you place an @ symbol at the beginning of the command.
	 * 	$base - _object_ (Optional) The base object to use, if any.
	 * 	$default - _mixed_ (Optional) What to return if there are no matches. Defaults to null.
	 *
	 * Returns:
	 * 	_mixed_ Either a matching property of a given object, _boolean_ false, or any other data type you might choose.
	 */
	public function try_these($attrs, $base = null, $default = null)
	{
		if ($base)
		{
			foreach ($attrs as $attr)
			{
				if (isset($base->$attr))
				{
					return $base->$attr;
				}
			}
		}
		else
		{
			foreach ($attrs as $attr)
			{
				if (isset($attr))
				{
					return $attr;
				}
			}
		}

		return $default;
	}

	/**
	 * Method: json_encode()
	 * 	Can be removed once all calls are updated.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$obj - _mixed_ (Required) The PHP object to convert into a JSON string.
	 *
	 * Returns:
	 * 	_string_ A JSON string.
	 */
	public function json_encode($obj)
	{
		return json_encode($obj);
	}

	/**
	 * Method: convert_response_to_array()
	 * 	Converts a SimpleXML response to an array structure.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$response - _ResponseCore_ (Required) A response value.
	 *
	 * Returns:
	 * 	_array_ The response value as a standard, multi-dimensional array.
	 *
	 * Requires:
	 * 	PHP 5.2
	 */
	public function convert_response_to_array(ResponseCore $response)
	{
		return json_decode(json_encode($response), true);
	}

	/**
	 * Method: convert_date_to_iso8601()
	 * 	Checks to see if a date stamp is ISO-8601 formatted, and if not, makes it so.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$datestamp - _string_ (Required) A date stamp, or a string that can be parsed into a date stamp.
	 *
	 * Returns:
	 * 	_string_ An ISO-8601 formatted date stamp.
	 */
	public function convert_date_to_iso8601($datestamp)
	{
		if (!preg_match('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}((\+|-)\d{2}:\d{2}|Z)/m', $datestamp))
		{
			return gmdate(self::DATE_FORMAT_ISO8601, strtotime($datestamp));
		}

		return $datestamp;
	}

	/**
	 * Method: is_base64()
	 * 	Determines whether the data is Base64 encoded or not.
	 *
	 * Access:
	 * 	public
	 *
	 * License:
	 * 	[PHP License](http://us.php.net/manual/en/function.base64-decode.php#81425)
	 *
	 * Parameters:
	 * 	$s - _string_ (Required) The string to test.
	 *
	 * Returns:
	 * 	_boolean_ Whether the string is Base64 encoded or not.
	 */
	public function is_base64($s)
	{
		return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
	}

	/**
	 * Method: decode_uhex()
	 * 	Decodes \uXXXX entities into their real unicode character equivalents.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$s - _string_ (Required) The string to decode.
	 *
	 * Returns:
	 * 	_string_ The decoded string.
	 */
	public function decode_uhex($s)
	{
		preg_match_all('/\\\u([0-9a-f]{4})/i', $s, $matches);
		$matches = $matches[count($matches) - 1];
		$map = array();

		foreach ($matches as $match)
		{
			if (!isset($map[$match]))
			{
				$map['\u' . $match] = html_entity_decode('&#' . hexdec($match) . ';', ENT_NOQUOTES, 'UTF-8');
			}
		}

		return str_replace(array_keys($map), $map, $s);
	}

	/**
	 * Method: generate_guid()
	 * 	Generates a random GUID.
	 *
	 * Author:
	 * 	Alix Axel <http://www.php.net/manual/en/function.com-create-guid.php#99425>
	 *
	 * License:
	 * 	[PHP License](http://www.php.net/license/3_01.txt)
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_string_ A random GUID.
	 */
	public function generate_guid()
	{
	    return sprintf(
			'%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(16384, 20479),
			mt_rand(32768, 49151),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535)
		);
	}
}

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
 * File: CFArray
 * 	Wrapper for ArrayObject.
 *
 * Version:
 * 	2010.08.18
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
 * Class: CFArray
 * 	Wrapper for ArrayObject.
 */
class CFArray extends ArrayObject
{
	/**
	 * Method: __construct()
	 * 	The constructor.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$input - _mixed_ (Required) The input parameter accepts an array or an Object.
	 * 	$flags - _int_ (Optional) Flags to control the behavior of the ArrayObject object. Defaults to `ArrayObject::STD_PROP_LIST`.
	 * 	$iterator_class - _string_ (Optional) Specify the class that will be used for iteration of the `ArrayObject` object. `ArrayIterator` is the default class used.
	 *
	 * Returns:
	 * 	_mixed_ Either an array of matches, or a single <CFSimpleXML> element.
	 */
	public function __construct($input, $flags = self::STD_PROP_LIST, $iterator_class = 'ArrayIterator')
	{
		return parent::__construct($input, $flags, $iterator_class);
	}

	/**
	 * Method: __toString()
	 * 	Handles how the object is rendered when cast as a string.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_string_ Array
	 */
	public function __toString()
	{
		return 'Array';
	}

	/**
	 * Method: map_integer()
	 * 	Maps each element in the CFArray object as an integer.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_array_ The contents of the CFArray object mapped as integers.
	 */
	public function map_integer()
	{
		return array_map('intval', $this->getArrayCopy());
	}

	/**
	 * Method: map_string()
	 * 	Maps each element in the CFArray object as a string.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the names against.
	 *
	 * Returns:
	 * 	_array_ The contents of the CFArray object mapped as strings. If there are no results, the method will return an empty array.
	 */
	public function map_string($pcre = null)
	{
		$list = array_map('strval', $this->getArrayCopy());

		if ($pcre)
		{
			foreach ($list as $item)
			{
				$dlist[] = preg_match($pcre, $item) ? $item : null;
			}

			$list = array_values(array_filter($dlist));
		}

		return $list;
	}

	/**
	 * Method: areOK()
	 * 	Verifies that _all_ responses were successful. A single failed request will cause <areOK()> to return false. Equivalent to <CFResponse::isOK()>, except it applies to all responses.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether _all_ requests were successful or not.
	 */
	public function areOK()
	{
		$dlist = array();
		$list = $this->getArrayCopy();

		foreach ($list as $response)
		{
			if ($response instanceof CFResponse)
			{
				$dlist[] = $response->isOK();
			}
		}

		return (array_search(false, $dlist, true) !== false) ? false : true;
	}
}

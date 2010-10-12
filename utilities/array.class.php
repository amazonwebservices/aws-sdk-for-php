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
 * 	2010.10.03
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[PHP Developer Center](http://aws.amazon.com/php/)
 * 	[ArrayObject](http://php.net/ArrayObject)
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

	/**
	 * Method: each()
	 * 	Iterates over a <CFArray> object, and executes a function for each matched element.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$callback - _string_ (Required) The callback function to execute. PHP 5.3 or newer can use an anonymous function.
	 * 	$bind - _mixed_ (Optional) A variable from the calling scope to pass-by-reference into the local scope of the callback function.
	 *
	 * Returns:
	 * 	_CFArray_ The original <CFArray> object.
	 */
	public function each($callback, &$bind = null)
	{
		$items = $this->getArrayCopy();
		$max = count($items);

		for ($i = 0; $i < $max; $i++)
		{
			$callback($items[$i], $i, $bind);
		}

		return $this;
	}

	/**
	 * Method: map()
	 * 	Passes each element in the current <CFArray> object through a function, and produces a new <CFArray> object containing the return values.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$callback - _string_ (Required) The callback function to execute. PHP 5.3 or newer can use an anonymous function.
	 * 	$bind - _mixed_ (Optional) A variable from the calling scope to pass-by-reference into the local scope of the callback function.
	 *
	 * Returns:
	 * 	_CFArray_ A new <CFArray> object containing the return values.
	 */
	public function map($callback, &$bind = null)
	{
		$items = $this->getArrayCopy();
		$max = count($items);
		$collect = array();

		for ($i = 0; $i < $max; $i++)
		{
			$collect[] = $callback($items[$i], $i, $bind);
		}

		return new CFArray($collect);
	}

	/**
	 * Method: reduce()
	 * 	Reduces the list of nodes by passing each value in the current <CFArray> object through a function. The node will be removed if the function returns `false`.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$callback - _string_ (Required) The callback function to execute. PHP 5.3 or newer can use an anonymous function.
	 * 	$bind - _mixed_ (Optional) A variable from the calling scope to pass-by-reference into the local scope of the callback function.
	 *
	 * Returns:
	 * 	_CFArray_ A new <CFArray> object containing the return values.
	 */
	public function reduce($callback, &$bind = null)
	{
		$items = $this->getArrayCopy();
		$max = count($items);
		$collect = array();

		for ($i = 0; $i < $max; $i++)
		{
			if ($callback($items[$i], $i, $bind) !== false)
			{
				$collect[] = $items[$i];
			}
		}

		return new CFArray($collect);
	}

	/**
	 * Method: first()
	 * 	Gets the first result in the array.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_mixed_ The first result in the <CFArray> object. Returns `false` if there are no items in the array.
	 */
	public function first()
	{
		$items = $this->getArrayCopy();
		return count($items) ? $items[0] : false;
	}

	/**
	 * Method: last()
	 * 	Gets the last result in the array.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_mixed_ The last result in the <CFArray> object. Returns `false` if there are no items in the array.
	 */
	public function last()
	{
		$items = $this->getArrayCopy();
		$last = count($items) - 1;
		return count($items) ? $items[$last] : false;
	}
}

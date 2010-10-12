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
 * File: CFSimpleXML
 * 	Wrapper for SimpleXMLElement.
 *
 * Version:
 * 	2010.10.03
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[PHP Developer Center](http://aws.amazon.com/php/)
 * 	[SimpleXML](http://php.net/SimpleXML)
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CFSimpleXML
 * 	Wrapper for SimpleXMLIterator.
 */
class CFSimpleXML extends SimpleXMLIterator
{
	/**
	 * Property: xml_ns
	 * 	Stores the namespace name to use in XPath queries.
	 */
	public $xml_ns;

	/**
	 * Property: xml_ns_url
	 * 	Stores the namespace URI to use in XPath queries.
	 */
	public $xml_ns_url;

	/**
	 * Method: __call()
	 * 	Catches requests made to methods that don't exist. Specifically, looks for child nodes via XPath.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$name - _string_ (Required) The name of the method.
	 * 	$arguments - _array_ (Required) The arguments passed to the method.
	 *
	 * Returns:
	 * 	_mixed_ Either an array of matches, or a single <CFSimpleXML> element.
	 */
	public function __call($name, $arguments)
	{
		// Remap $this
		$self = $this;

		// Re-base the XML
		$self = new CFSimpleXML($self->asXML());

		// Determine XPath query
		$self->xpath_expression = '//' . $name;

		// Get the results and augment with CFArray
		$results = $self->xpath($self->xpath_expression);
		if (!count($results)) return false;
		$results = new CFArray($results);

		// If an integer was passed, return only that result
		if (isset($arguments[0]) && is_int($arguments[0]))
		{
			if (isset($results[$arguments[0]]))
			{
				return $results[$arguments[0]];
			}

			return false;
		}

		return $results;
	}

	/**
	 * Method: query()
	 * 	Wraps the results of an XPath query in a <CFArray> object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$expr - _string_ (Required) The XPath expression to use to query the XML response.
	 *
	 * Returns:
	 * 	_CFArray_ A <CFArray> object containing the results of the XPath query.
	 */
	public function query($expr)
	{
		return new CFArray($this->xpath($expr));
	}

	/**
	 * Method: parent()
	 * 	Gets the parent or a preferred ancestor of the current element.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$node - _string_ (Optional) Name of the ancestor element to match and return.
	 *
	 * Returns:
	 * 	_CFSimpleXML_ A <CFSimpleXML> object containing the requested node.
	 */
	public function parent($node = null)
	{
		if ($node)
		{
			$parents = $this->xpath('ancestor-or-self::' . $node);
		}
		else
		{
			$parents = $this->xpath('parent::*');
		}

		return $parents[0];
	}

	/**
	 * Method: stringify()
	 * 	Gets the current XML node as a true string.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_string_ The current XML node as a true string.
	 */
	public function stringify()
	{
		return (string) $this;
	}

	/**
	 * Method: is()
	 * 	Whether or not the current node exactly matches the compared value.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether or not the current node exactly matches the compared value.
	 */
	public function is($value)
	{
		return ((string) $this === $value);
	}

	/**
	 * Method: contains()
	 * 	Whether or not the current node contains the compared value.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether or not the current node contains the compared value.
	 */
	public function contains($value)
	{
		return (stripos((string) $this, $value) !== false);
	}
}

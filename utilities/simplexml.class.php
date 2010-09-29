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
 * 	2010.08.06
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
 * Class: CFSimpleXML
 * 	Wrapper for SimpleXMLElement.
 */
class CFSimpleXML extends SimpleXMLElement
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

		// If the namespace hasn't yet been determined...
		if (!$self->xml_ns_url)
		{
			$namespaces = $self->getDocNamespaces();

			if (isset($namespaces['']))
			{
				$self->xml_ns = 'ns:';
				$self->xml_ns_url = $namespaces[''];
				$self->registerXPathNamespace('ns', $self->xml_ns_url);
			}
		}

		// Determine XPath query
		$self->xpath_expression = '//' . $self->xml_ns . $name;

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
}

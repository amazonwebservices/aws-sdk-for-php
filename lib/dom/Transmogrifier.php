<?php
/**
 * Copyright (c) 2010-2012 [Ryan Parman](http://ryanparman.com)
 * Copyright (c) 2012 Amazon.com, Inc. or its affiliates.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * <http://www.opensource.org/licenses/mit-license.php>
 */


/**
 * Magically transmogrifies arrays into XML documents.
 */
class Transmogrifier
{
	/******************************************************************************/
	// CONSTANTS

	const ATTRIBUTES = '__attributes__';
	const CONTENT    = '__content__';


	/******************************************************************************/
	// PUBLIC METHODS

	/**
	 * Public method for converting an array into an XML DOMDocument object.
	 *
	 * @param  array  $source      The source array to convert into an XML document.
	 * @param  string $rootTagName The name to assign to the root element of the XML document. The default value is "root".
	 * @return string              The XML document as a string.
	 */
	public static function to_dom(array $source, $rootTagName = 'root')
	{
		$document = new DOMDocument();

		// Generate the document
		$root = $document->createElement('root');
		$root->appendChild(self::create_dom_element_from_array($source, 'member', $document));
		$document->appendChild($root);

		// Cleanup duplicated notes
		self::cleanup($document);

		return $document;
	}

	/**
	 * Public method for converting an array into an XML document.
	 *
	 * @param  array  $source      The source array to convert into an XML document.
	 * @param  string $rootTagName The name to assign to the root element of the XML document. The default value is "root".
	 * @return string              The XML document as a string.
	 */
	public static function to_xml(array $source, $rootTagName = 'root')
	{
		$document = self::to_dom($source, $rootTagName);

		// Output the content
		$document->formatOutput = true;
		return $document->saveXML();
	}


	/******************************************************************************/
	// WORKER METHODS

	/**
	 * Recursively iterates over each child of the array to produce an XML structure.
	 *
	 * @param  mixed               $source   The content node that is being evaluated.
	 * @param  string              $tagName  The name of the current element.
	 * @param  DOMDocument         $document The parent-most DOMDocument element that we're writing to.
	 * @return DOMDocumentFragment           A DOM document fragment that can be appended to a parent DOM element.
	 */
	protected static function create_dom_element_from_array($source, $tagName, DOMDocument $document, $parent = null)
	{
		// Create a document fragment to hold the elements
		$fragment = $document->createDocumentFragment();

		if (is_numeric($tagName))
		{
			$tagName = $parent->tagName;
		}

		if (is_array($source))
		{
			// Indexed array
			if (self::is_list($source))
			{
				// Loop through each entry in the array
				foreach ($source as $key => $value)
				{
					// Create a new element where the name is the array key
					$element = $document->createElement($tagName);
					$fragment->appendChild($element);

					// Recurse
					$fragment_with_children = self::create_dom_element_from_array($value, $tagName, $document, $element);

					// Verify the fragment has children before appending it
					if ($fragment_with_children->hasChildNodes())
					{
						$element->appendChild($fragment_with_children);
					}

					// Figure out which nodes need to be removed
					if ($parent && $parent->tagName === $tagName)
					{
						$parent->setAttribute('remove', true);
					}
				}
			}

			// Associative array
			elseif (self::is_hash($source))
			{
				// Loop through each entry in the array
				foreach ($source as $key => $value)
				{
					// Handle custom attributes
					if ($key === self::ATTRIBUTES)
					{
						foreach ($value as $attributeName => $attributeValue)
						{
							$parent->setAttribute($attributeName, $attributeValue);
						}
					}

					// Handle content nodes
					elseif ($key === self::CONTENT)
					{
						$parent->appendChild($document->createCDATASection($value));
					}

					else
					{
						// Create a new element where the name is the array key
						$element = $document->createElement($key);
						$fragment->appendChild($element);

						// Recurse
						$fragment_with_children = self::create_dom_element_from_array($value, $key, $document, $element);

						// Verify the fragment has children before appending it
						if ($fragment_with_children->hasChildNodes())
						{
							$element->appendChild($fragment_with_children);
						}
					}
				}
			}
		}

		// Content node
		else
		{
			$fragment->appendChild(self::handle_content($source, $document, $parent));
		}

		return $fragment;
	}

	/**
	 * Handle nodes that are only content.
	 *
	 * @param  mixed               $content  The content node to handle.
	 * @param  DOMDocument         $document The parent-most DOMDocument element that we're writing to.
	 * @param  DOMElement          $element  The parent node of the content to mark as encoded.
	 * @return DOMDocumentFragment           A DOM document fragment that can be appended to a parent DOM element.
	 */
	protected static function handle_content($content, DOMDocument $document, DOMElement $element)
	{
		$fragment = $document->createDocumentFragment();

		// boolean
		if (is_bool($content))
		{
			$fragment->appendChild(
				$document->createCDATASection(
					($content ? 'true' : 'false')
				)
			);
		}

		// numbers
		elseif (is_numeric($content))
		{
			$fragment->appendChild(
				$document->createTextNode($content)
			);
		}

		// strings?
		else
		{
			// Handle NULL bytes
			if (strpos($content, "\0") !== false)
			{
				$content = 'json_encoded::' . json_encode($content);
				$element->setAttribute('encoded', 'json');
			}

			$fragment->appendChild(
				$document->createCDATASection($content)
			);
		}

		return $fragment;
	}

	/**
	 * Clean-up the duplicate nodes caused by not being able to reference
	 * grandparent nodes during the recursion flow.
	 *
	 * @param  DOMDocument $document The XML document to clean-up.
	 * @return DOMDocument           The original XML document.
	 */
	protected static function cleanup(DOMDocument $document)
	{
		// Find matches
		$xpath = new DOMXPath($document);
		$entries = $xpath->query('//*[@remove]');

		// Loop through matches and find each node with a "remove" attribute
		foreach ($entries as $entry)
		{
			// Grab a reference to this so that it doesn't dynamically move on us
			$next_sibling = $entry->nextSibling;

			// Look through each child node and add it to the parent node
			while ($entry->childNodes->length > 0)
			{
				// If there's a next sibling, let's insert before it
				if ($next_sibling)
				{
					$entry->parentNode->insertBefore($entry->childNodes->item(0), $next_sibling);
				}

				// Otherwise, just add it to the end
				else
				{
					$entry->parentNode->appendChild($entry->childNodes->item(0));
				}
			}

			// If there aren't any more child nodes, remove the entry
			if (!$entry->hasChildNodes())
			{
				$entry->parentNode->removeChild($entry);
			}
		}
	}


	/******************************************************************************/
	// UTILITY METHODS

	/**
	 * Method that checks to see if the array is indexed.
	 *
	 * @param  array   $array The array to test.
	 * @return boolean        Whether or not the array is indexed. A value of true means that the array is indexed. A value of false means that the array is associative.
	 */
	protected static function is_list(array $array)
	{
		foreach ($array as $key => $value)
		{
			// If any keys are non-numeric...
			if (!is_numeric($key))
			{
				// Then this is not a list
				return false;
			}
		}

		return true;
	}

	/**
	 * Method that checks to see if the array is associative.
	 *
	 * @param  array   $array The array to test.
	 * @return boolean        Whether or not the array is associative. A value of true means that the array is associative. A value of false means that the array is indexed.
	 */
	protected static function is_hash(array $array)
	{
		foreach ($array as $key => $value)
		{
			// If any keys are non-numeric...
			if (!is_numeric($key))
			{
				// Then this is a hash
				return true;
			}
		}

		return false;
	}
}

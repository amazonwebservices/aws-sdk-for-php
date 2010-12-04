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
 * File: AmazonSDB
 * 	Amazon SimpleDB is a web service providing the core database functions of data indexing and querying
 * 	in the cloud. By offloading the time and effort associated with building and operating a web-scale
 * 	database, SimpleDB provides developers the freedom to focus on application development.
 *
 * 	A traditional, clustered relational database requires a sizable upfront capital outlay, is complex
 * 	to design, and often requires extensive and repetitive database administration. Amazon SimpleDB is
 * 	dramatically simpler, requiring no schema, automatically indexing your data and providing a simple
 * 	API for storage and access. This approach eliminates the administrative burden of data modeling,
 * 	index maintenance, and performance tuning. Developers gain access to this functionality within
 * 	Amazon's proven computing environment, are able to scale instantly, and pay only for what they use.
 *
 * 	Visit [http://aws.amazon.com/simpledb/](http://aws.amazon.com/simpledb/) for more information.
 *
 * Version:
 * 	Fri Dec 03 16:27:22 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon SimpleDB](http://aws.amazon.com/simpledb/)
 * 	[Amazon SimpleDB documentation](http://aws.amazon.com/documentation/simpledb/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: SDB_Exception
 * 	Default SDB Exception.
 */
class SDB_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonSDB
 * 	Container for all service-related methods.
 */
class AmazonSDB extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'sdb.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = self::DEFAULT_URL;

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'sdb.us-west-1.amazonaws.com';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'sdb.eu-west-1.amazonaws.com';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'sdb.ap-southeast-1.amazonaws.com';


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * Method: set_region()
	 * 	This allows you to explicitly sets the region for the service to use.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$region - _string_ (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_W1>, <REGION_EU_W1>, or <REGION_APAC_SE1>.
	 *
	 * Returns:
	 * 	`$this`
	 */
	public function set_region($region)
	{
		$this->set_hostname($region);
		return $this;
	}

	/*%******************************************************************************************%*/
	// CONVENIENCE METHODS

	/**
	 * Method: get_domain_list()
	 * 	ONLY lists the domains, as an array, on the SimpleDB account.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the names against.
	 *
	 * Returns:
	 * 	_array_ The list of matching queue names. If there are no results, the method will return an empty array.
	 *
	 * See Also:
	 * 	[Perl-Compatible Regular Expression (PCRE) Docs](http://php.net/pcre)
	 */
	public function get_domain_list($pcre = null)
	{
		if ($this->use_batch_flow)
		{
			throw new SDB_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		// Get a list of domains.
		$list = $this->list_domains();
		if ($list = $list->body->DomainName())
		{
			$list = $list->map_string($pcre);
			return $list;
		}

		return array();
	}

	/**
	 * Method: remap_batch_items_for_complextype()
	 * 	Remaps the custom item-key-value format used by Batch* operations to the more common ComplexList format. Internal use only.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$items - _array_ (Required) The item-key-value format passed by <batch_put_attributes()> and <batch_delete_attributes()>.
	 * 	$replace - _boolean_|_array_ (Optional) The `$replace` value passed by <batch_put_attributes()> and <batch_delete_attributes()>.
	 *
	 * Returns:
	 * 	_array_ A <CFComplexType>-compatible mapping of parameters.
	 */
	public static function remap_batch_items_for_complextype($items, $replace = false)
	{
		$map = array(
			'Item' => array()
		);

		foreach ($items as $key => $value)
		{
			$node = array();
			$node['ItemName'] = $key;

			if (is_array($value))
			{
				$node['Attribute'] = array();

				foreach ($value as $k => $v)
				{
					$v = is_array($v) ? $v : array($v);

					foreach ($v as $vv)
					{
						$n = array();
						$n['Name'] = $k;
						$n['Value'] = $vv;

						if (
							$replace === (boolean) true ||
							(isset($replace[$key]) && array_search($k, $replace[$key], true) !== false)
						)
						{
							$n['Replace'] = 'true';
						}

						$node['Attribute'][] = $n;
					}
				}
			}

			$map['Item'][] = $node;
		}

		return $map;
	}

	/**
	 * Method: remap_batch_items_for_complextype()
	 * 	Remaps the custom item-key-value format used by Batch* operations to the more common ComplexList format. Internal use only.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$keys - _array_ (Required) The key-value format passed by <put_attributes()>.
	 * 	$replace - _boolean_|_array_ (Optional) The `$replace` value passed by <batch_put_attributes()> and <batch_delete_attributes()>.
	 *
	 * Returns:
	 * 	_array_ A <CFComplexType>-compatible mapping of parameters.
	 */
	public static function remap_attribute_items_for_complextype($keys, $replace = false)
	{
		$map = array(
			'Attribute' => array()
		);

		foreach ($keys as $k => $v)
		{
			$v = is_array($v) ? $v : array($v);

			foreach ($v as $vv)
			{
				$n = array();
				$n['Name'] = $k;
				$n['Value'] = $vv;

				if (
					$replace === (boolean) true ||
					(is_array($replace) && array_search($k, $replace, true) !== false)
				)
				{
					$n['Replace'] = 'true';
				}

				$map['Attribute'][] = $n;
			}
		}

		return $map;
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonSDB>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$key - _string_ (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * 	$secret_key - _string_ (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 *
	 * Returns:
	 * 	_boolean_ false if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->api_version = '2009-04-15';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new SDB_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new SDB_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: select()
	 * 	The `Select` operation returns a set of attributes for `ItemNames` that match the select expression.
	 * 	`Select` is similar to the standard SQL SELECT statement.
	 *
	 * 	The total size of the response cannot exceed 1 MB in total size. Amazon SimpleDB automatically
	 * 	adjusts the number of items returned per page to enforce this limit. For example, if the client asks
	 * 	to retrieve 2500 items, but each individual item is 10 kB in size, the system returns 100 items and
	 * 	an appropriate `NextToken` so the client can access the next page of results.
	 *
	 * 	For information on how to construct select expressions, see Using Select to Create Amazon SimpleDB
	 * 	Queries in the Developer Guide.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$select_expression - _string_ (Required) The expression used to query the domain.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	NextToken - _string_ (Optional) A string informing Amazon SimpleDB where to start the next list of `ItemNames`.
	 *	ConsistentRead - _boolean_ (Optional) Determines whether or not strong consistency should be enforced when data is read from SimpleDB. If `true`, any data previously written to SimpleDB will be returned. Otherwise, results will be consistent eventually, and the client may not see data that was written immediately before your read.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function select($select_expression, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['SelectExpression'] = $select_expression;

		return $this->authenticate('Select', $opt, $this->hostname);
	}

	/**
	 * Method: put_attributes()
	 * 	The PutAttributes operation creates or replaces attributes in an item.
	 *
	 * 	A single item can have the attributes { "first_name", "first_value" } and { "first_name", second_value" }. However,
	 * 	it cannot have two attribute instances where both the attribute name and attribute value are the same. Optionally,
	 * 	the requestor can supply the Replace parameter for each individual attribute. Setting this value to true causes the
	 * 	new attribute value to replace the existing attribute value(s).
	 *
	 * 	For example, if an item has the attributes { 'a', '1' }, { 'b', '2'} and { 'b', '3' } and the requestor calls
	 * 	PutAttributes using the attributes { 'b', '4' } with the Replace parameter set to true, the final attributes of the
	 * 	item are changed to { 'a', '1' } and { 'b', '4' }, which replaces the previous values of the 'b' attribute with the
	 * 	new value.
	 *
	 * 	Using PutAttributes to replace attribute values that do not exist will not result in an error
	 * 	response.
	 *
	 * 	You cannot specify an empty string as an attribute name.
	 *
	 * 	Because Amazon SimpleDB makes multiple copies of your data and uses an eventual consistency update
	 * 	model, an immediate GetAttributes or Select request (read) immediately after a DeleteAttributes
	 * 	request (write) might not return the updated data.
	 *
	 * 	The following limitations are enforced for this operation:
	 *
	 * 	- 256 total attribute name-value pairs per item
	 * 	- One billion attributes per domain
	 * 	- 10 GB of total user data storage per domain
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$domain_name - _string_ (Required) The domain name to use for storing data.
	 * 	$item_name - _string_ (Required) The name of the base item which will contain the series of keypairs.
	 * 	$keypairs - _ComplexType_ (Required) Associative array of parameters which are treated as key-value and key-multivalue pairs (i.e. a key can have one or more values; think tags).
	 * 	$replace - _boolean_|_array_ (Optional) Whether to replace a key-value pair if a matching key already exists. Supports either a boolean (which affects ALL key-value pairs) or an indexed array of key names (which affects only the keys specified). Defaults to boolean false.
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $keypairs parameter:
	 * 	key1.x - _string_ (Required) This value can be any key and any value that you want to store.
	 * 	key2.x - _string_ (Optional) This value can be any key and any value that you want to store.
	 *
	 * Keys for the $opt parameter:
	 * 	Expected - _ComplexType_ (Optional) The update condition which, if specified, determines if the specified attributes will be updated or not. The update condition must be satisfied in order for this request to be processed and the attributes to be updated. A ComplexType can be set two ways: by setting each individual `Expected` subtype (documented next), or by passing a nested associative array with the following `Expected`-prefixed entries as keys.
	 * 	Expected.Name - _string_ (Optional) The name of the attribute involved in the condition.
	 * 	Expected.Value - _string_ (Optional) The value of an attribute. This value can only be specified when the exists parameter is equal to true.
	 * 	Expected.Exists - _boolean_ (Optional) True if the specified attribute must exist with the specified value in order for this update condition to be satisfied, otherwise false if the specified attribute should not exist in order for this update condition to be satisfied.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function put_attributes($domain_name, $item_name, $keypairs, $replace = null, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;
		$opt['ItemName'] = $item_name;

		$opt = array_merge($opt, CFComplexType::map(
			self::remap_attribute_items_for_complextype($keypairs, $replace)
		));

		if (isset($opt['Expected']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Expected' => $opt['Expected']
			)));
			unset($opt['Expected']);
		}

		return $this->authenticate('PutAttributes', $opt, $this->hostname);
	}

	/**
	 * Method: batch_delete_attributes()
	 * 	Performs multiple DeleteAttributes operations in a single call, which reduces round trips and latencies.
	 * 	This enables Amazon SimpleDB to optimize requests, which generally yields better throughput.
	 *
	 * 	If you specify BatchDeleteAttributes without attributes or values, all the attributes for the item are
	 * 	deleted. BatchDeleteAttributes is an idempotent operation; running it multiple times on the same item
	 * 	or attribute doesn't result in an error. The BatchDeleteAttributes operation succeeds or fails in its
	 * 	entirety. There are no partial deletes.
	 *
	 * 	You can execute multiple BatchDeleteAttributes operations and other operations in parallel. However,
	 * 	large numbers of concurrent BatchDeleteAttributes calls can result in Service Unavailable (503) responses.
	 * 	This operation does not support conditions using Expected.X.Name, Expected.X.Value, or Expected.X.Exists.
	 *
	 * 	The following limitations are enforced for this operation:
	 *
	 * 	- 1 MB request size
	 * 	- 25 item limit per BatchDeleteAttributes operation
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$domain_name - _string_ (Required) The name of the domain in which the attributes are being deleted.
	 * 	$item_keypairs - _ComplexType_ (Required) Associative array of parameters which are treated as item-key-value and item-key-multivalue pairs (i.e. a key can have one or more values; think tags).
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $item_keypairs parameter:
	 * 	item1.key1.x - _string_ (Required) This value can be any key and any value that you want to delete.
	 * 	item1.key2.x - _string_ (Optional) This value can be any key and any value that you want to delete.
	 *
	 * Keys for the $opt parameter:
	 *	Item.x.ItemName - _string_ (Optional) This is the parameter format supported by the web service API. This is the item name to use.
	 *	Item.x.Attribute.y.AlternateNameEncoding - _string_ (Optional) This is the parameter format supported by the web service API. This is the alternate name encoding to use.
	 *	Item.x.Attribute.y.AlternateValueEncoding - _string_ (Optional) This is the parameter format supported by the web service API. This is the alternate value encoding to use.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function batch_delete_attributes($domain_name, $item_keypairs, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;

		$opt = array_merge($opt, CFComplexType::map(
			self::remap_batch_items_for_complextype($item_keypairs)
		));

		if (isset($opt['Item']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Item' => $opt['Item']
			)));
			unset($opt['Item']);
		}

		return $this->authenticate('BatchDeleteAttributes', $opt, $this->hostname);
	}

	/**
	 * Method: delete_domain()
	 * 	The `DeleteDomain` operation deletes a domain. Any items (and their attributes) in the domain are
	 * 	deleted as well. The `DeleteDomain` operation might take 10 or more seconds to complete. Running
	 * 	`DeleteDomain` on a domain that does not exist or running the function multiple times using the same
	 * 	domain name will not result in an error response.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$domain_name - _string_ (Required) The name of the domain to delete.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_domain($domain_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;

		return $this->authenticate('DeleteDomain', $opt, $this->hostname);
	}

	/**
	 * Method: create_domain()
	 * 	The `CreateDomain` operation creates a new domain. The domain name should be unique among the
	 * 	domains associated with the Access Key ID provided in the request. The `CreateDomain` operation may
	 * 	take 10 or more seconds to complete. CreateDomain is an idempotent operation; running it multiple
	 * 	times using the same domain name will not result in an error response.
	 *
	 * 	The client can create up to 100 domains per account.
	 *
	 * 	If the client requires additional domains, go to [
	 * 	n.com/contact-us/simpledb-limit-request/](http://aws.amazon.com/contact-us/simpledb-limit-request/).
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$domain_name - _string_ (Required) The name of the domain to create. The name can range between 3 and 255 characters and can contain the following characters: a-z, A-Z, 0-9, '_', '-', and '.'.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_domain($domain_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;

		return $this->authenticate('CreateDomain', $opt, $this->hostname);
	}

	/**
	 * Method: delete_attributes()
	 * 	Deletes one or more attributes associated with the item. If all attributes of an item are deleted,
	 * 	the item is deleted.
	 *
	 * 	If you specify DeleteAttributes without attributes or values, all the attributes for the item are
	 * 	deleted.
	 *
	 * 	DeleteAttributes is an idempotent operation; running it multiple times on the same item or
	 * 	attribute does not result in an error response.
	 *
	 * 	Because Amazon SimpleDB makes multiple copies of your data and uses an eventual consistency update
	 * 	model, performing a GetAttributes or Select request (read) immediately after a DeleteAttributes or
	 * 	PutAttributes request (write) might not return the updated data.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$domain_name - _string_ (Required) The name of the domain in which to perform the operation.
	 * 	$item_name - _string_ (Required) The name of the item. Similar to rows on a spreadsheet, items represent individual objects that contain one or more value-attribute pairs.
	 * 	$attributes - _ComplexList_ (Optional) Similar to columns on a spreadsheet, attributes represent categories of data that can be assigned to items. A **required** ComplexList is an indexed array of ComplexTypes -- each of which must be set by passing a nested associative array with the following `Attribute`-prefixed entries as keys. `x`/`y`/`z` should be integers, starting at `1`. If you only have a single `Name` or `Name-Value` set, you can pass a single array which will be assumed to be index 0. Passing only the `Name` will delete the entire name. Passing the `Name` & `Value` will only delete that specific value under the attribute name (for multi-value keys).
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $attributes parameter:
	 * 	Name - _string_ (Required) Attribute Name.
	 * 	Value - _string_ (Optional) Attribute Value.
	 * 	AlternateNameEncoding - _string_ (Optional)
	 * 	AlternateValueEncoding - _string_ (Optional)
	 *
	 * Keys for the $opt parameter:
	 * 	Expected - _ComplexType_ (Optional) The update condition which, if specified, determines if the specified attributes will be deleted or not. The update condition must be satisfied in order for this request to be processed and the attributes to be deleted. A ComplexType can be set two ways: by setting each individual `Expected` subtype (documented next), or by passing a nested associative array with the following `Expected`-prefixed entries as keys.
	 * 	Expected.Name - _string_ (Optional) The name of the attribute involved in the condition.
	 * 	Expected.Value - _string_ (Optional) The value of an attribute. This value can only be specified when the exists parameter is equal to true.
	 * 	Expected.Exists - _boolean_ (Optional) True if the specified attribute must exist with the specified value in order for this update condition to be satisfied, otherwise false if the specified attribute should not exist in order for this update condition to be satisfied.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_attributes($domain_name, $item_name, $attributes = null, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;
		$opt['ItemName'] = $item_name;

		if ($attributes)
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Attribute' => (is_array($attributes) ? $attributes : array($attributes))
			)));
		}

		if (isset($opt['Expected']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Expected' => $opt['Expected']
			)));
			unset($opt['Expected']);
		}

		return $this->authenticate('DeleteAttributes', $opt, $this->hostname);
	}

	/**
	 * Method: list_domains()
	 * 	The `ListDomains` operation lists all domains associated with the Access Key ID. It returns domain
	 * 	names up to the limit set by [MaxNumberOfDomains](#MaxNumberOfDomains). A [NextToken](#NextToken) is
	 * 	returned if there are more than `MaxNumberOfDomains` domains. Calling `ListDomains` successive times
	 * 	with the `NextToken` provided by the operation returns up to `MaxNumberOfDomains` more domain names
	 * 	with each successive operation call.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	MaxNumberOfDomains - _integer_ (Optional) The maximum number of domain names you want returned. The range is 1 to 100. The default setting is 100.
	 *	NextToken - _string_ (Optional) A string informing Amazon SimpleDB where to start the next list of domain names.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_domains($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListDomains', $opt, $this->hostname);
	}

	/**
	 * Method: get_attributes()
	 * 	Returns all of the attributes associated with the item. Optionally, the attributes returned can be
	 * 	limited to one or more specified attribute name parameters.
	 *
	 * 	If the item does not exist on the replica that was accessed for this operation, an empty set is
	 * 	returned. The system does not return an error as it cannot guarantee the item does not exist on
	 * 	other replicas.
	 *
	 * 	If you specify GetAttributes without any attribute names, all the attributes for the item are
	 * 	returned.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$domain_name - _string_ (Required) The name of the domain in which to perform the operation.
	 * 	$item_name - _string_ (Required) The name of the base item which will contain the series of keypairs.
	 * 	$attribute_name - _string_|_array_ (Optional) The names of the attributes. Pass a string for a single value, or an indexed array for multiple values..
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	ConsistentRead - _boolean_ (Optional) True if strong consistency should be enforced when data is read from SimpleDB, meaning that any data previously written to SimpleDB will be returned. Without specifying this parameter, results will be eventually consistent, and you may not see data that was written immediately before your read.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_attributes($domain_name, $item_name, $attribute_name = null, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;
		$opt['ItemName'] = $item_name;

		if ($attribute_name)
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'AttributeName' => (is_array($attribute_name) ? $attribute_name : array($attribute_name))
			)));
		}

		return $this->authenticate('GetAttributes', $opt, $this->hostname);
	}

	/**
	 * Method: batch_put_attributes()
	 * 	The BatchPutAttributes operation creates or replaces attributes within one or more items.
	 *
	 * 	Attributes are uniquely identified within an item by their name/value combination. For example, a single item can
	 * 	have the attributes { "first_name", "first_value" } and {"first_name", "second_value" }. However, it cannot have two
	 * 	attribute instances where both the item attribute name and item attribute value are the same.
	 *
	 * 	Optionally, the requester can supply the Replace parameter for each individual value. Setting this value to true will
	 * 	cause the new attribute value to replace the existing attribute value(s). For example, if an item I has the attributes
	 * 	{ 'a', '1' }, { 'b', '2'} and { 'b', '3' } and the requester does a BatchPutAttributes of {'I', 'b', '4' } with the
	 * 	Replace parameter set to true, the final attributes of the item will be { 'a', '1' } and { 'b', '4' }, replacing the
	 * 	previous values of the 'b' attribute with the new value. You cannot specify an empty string as an item or attribute name.
	 *
	 * 	The BatchPutAttributes operation succeeds or fails in its entirety. There are no partial puts. You can execute multiple
	 * 	BatchPutAttributes operations and other operations in parallel. However, large numbers of concurrent BatchPutAttributes
	 * 	calls can result in Service Unavailable (503) responses. The following limitations are enforced for this operation:
	 *
	 * 	- 256 attribute name-value pairs per item
	 * 	- 1 MB request size
	 * 	- 1 billion attributes per domain
	 * 	- 10 GB of total user data storage per domain
	 * 	- 25 item limit per BatchPutAttributes operation
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$domain_name - _string_ (Required) The domain name to use for storing data.
	 * 	$item_keypairs - _ComplexType_ (Required) Associative array of parameters which are treated as item-key-value and item-key-multivalue pairs (i.e. a key can have one or more values; think tags).
	 * 	$replace - _boolean_|_array_ (Optional) Whether to replace a key-value pair if a matching key already exists. Supports either a boolean (which affects ALL key-value pairs) or an indexed array of key names (which affects only the keys specified). Defaults to boolean false.
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $item_keypairs parameter:
	 * 	item1.key1.x - _string_ (Required) This value can be any key and any value that you want to store.
	 * 	item1.key2.x - _string_ (Optional) This value can be any key and any value that you want to store.
	 *
	 * Keys for the $opt parameter:
	 *	Item.x.ItemName - _string_ (Optional) This is the parameter format supported by the web service API. This is the item name to use.
	 *	Item.x.Attribute.y.Name - _string_ (Optional) This is the parameter format supported by the web service API. This is the attribute name (key) to use.
	 *	Item.x.Attribute.y.Value - _string_ (Optional) This is the parameter format supported by the web service API. This is the attribute value to use.
	 *	Item.x.Attribute.y.Replace - _string_ (Optional) This is the parameter format supported by the web service API. This is the attribute replacement status.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function batch_put_attributes($domain_name, $item_keypairs, $replace = null, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;

		$opt = array_merge($opt, CFComplexType::map(
			self::remap_batch_items_for_complextype($item_keypairs, $replace)
		));

		if (isset($opt['Item']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Item' => $opt['Item']
			)));
			unset($opt['Item']);
		}

		return $this->authenticate('BatchPutAttributes', $opt, $this->hostname);
	}

	/**
	 * Method: domain_metadata()
	 * 	Returns information about the domain, including when the domain was created, the number of items and
	 * 	attributes in the domain, and the size of the attribute names and values.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$domain_name - _string_ (Required) The name of the domain for which to display the metadata of.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function domain_metadata($domain_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DomainName'] = $domain_name;

		return $this->authenticate('DomainMetadata', $opt, $this->hostname);
	}
}


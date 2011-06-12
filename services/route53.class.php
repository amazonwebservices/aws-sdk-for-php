<?php
/*
 * Copyright 2010-2011 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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

/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Default Route 53 Exception.
 */
class Route53_Exception extends Exception {}

/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Amazon Route 53 is a highly available and scalable Domain Name System (DNS) web service.
 * It is designed to give developers and businesses an extremely reliable and cost effective way 
 * to route end users to Internet applications by translating human readable names 
 * like www.example.com into the numeric IP addresses like 192.0.2.1 that computers use to connect to each other. 
 *
 * @version 2011.06.10
 * @license See the included NOTICE.md file for more information.
 * @copyright See the included NOTICE.md file for more information.
 * @link http://aws.amazon.com/route53/ Amazon Route 53
 * @link http://aws.amazon.com/documentation/route53/ Amazon Route 53 documentation
 */
class AmazonRoute53 extends CFRuntime
{
	/**
	 * Specify the default queue URL.
	 */
	const DEFAULT_URL = 'route53.amazonaws.com';

	/**
	 * The Pending status.
	 */
	const STATUS_PENDING = 'Pending';

	/**
	 * The InSync status.
	 */
	const STATUS_INSYNC = 'InSync';
	
	/**
	 * The base content to use for generating XML.
	 */
	var $base_xml;

	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of this class.
	 *
	 * @param string $key (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * @param string $secret_key (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 * @return boolean A value of <code>false</code> if no valid values are set, otherwise <code>true</code>.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->api_version = '2011-05-05';
		$this->hostname = self::DEFAULT_URL;

		$this->base_xml = '<?xml version="1.0" encoding="UTF-8"?><%s xmlns="https://route53.amazonaws.com/doc/' . $this->api_version . '/"></%1$s>';

		if (!$key && !defined('AWS_KEY'))
		{
			throw new Route53_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new Route53_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}

	/*%******************************************************************************************%*/
	// AUTHENTICATION

	/**
	 * Authenticates a connection to Amazon Route 53. This method should not be used directly unless
	 * you're writing custom methods for this class.
	 *
	 * @param string $method (Required) The HTTP method to use to connect. Accepts <code>GET</code>, <code>POST</code>, and <code>DELETE</code>
	 * @param string $path (Required) The endpoint path to make requests to.
	 * @param array $opt (Optional) An associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * @param string $xml (Optional) The XML body content to send along in the request.
	 * @param integer $redirects (Do Not Use) Used internally by this function.
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/DeveloperGuide/RESTAuthentication.html Authentication
	 */
	public function authenticate($method = 'GET', $path = null, $opt = null, $xml = null, $redirects = 0)
	{
		if (!$opt) $opt = array();
		$querystring = null;

		$method_arguments = func_get_args();
		$headers = array();
		$signed_headers = array();
		
		// Use the caching flow to determine if we need to do a round-trip to the server.
		if ($this->use_cache_flow)
		{
			// Generate an identifier specific to this particular set of arguments.
			$cache_id = $this->key . '_' . get_class($this) . '_' . $method . sha1($path) . '_' . sha1(serialize($method_arguments));

			// Instantiate the appropriate caching object.
			$this->cache_object = new $this->cache_class($cache_id, $this->cache_location, $this->cache_expires, $this->cache_compress);

			if ($this->delete_cache)
			{
				$this->use_cache_flow = false;
				$this->delete_cache = false;
				return $this->cache_object->delete();
			}

			// Invoke the cache callback function to determine whether to pull data from the cache or make a fresh request.
			$data = $this->cache_object->response_manager(array($this, 'cache_callback'), $method_arguments);

			// Parse the XML body
			$data = $this->parse_callback($data);

			// End!
			return $data;
		}

		// Generate query string
		if (isset($opt['query_string']) && count($opt['query_string']))
		{
			$querystring = '?' . $this->util->to_query_string($opt['query_string']);
		}

		// Gather information to pass along to other classes.
		$helpers = array(
			'utilities' => $this->utilities_class,
			'request' => $this->request_class,
			'response' => $this->response_class,
		);

		// Compose the endpoint URL.
		$request_url = 'https://' . $this->hostname . '/' . $this->api_version;
		$request_url .= ($path) ? $path : '';
		$request_url .= ($querystring) ? $querystring : '';
		
		// Compose the request.
		$request = new $this->request_class($request_url, $this->proxy, $helpers);
		$request->set_method($method);
		
		// Prepare the string to sign. Route 53 requires the time stamp in the request to be within 5 minutes of the AWS system time. See fetch_date method. 
		$date = $this->fetch_date();
		$string_to_sign = $date;
		
		// Build headers
		$headers['Host'] = $this->hostname;
		
		// Add configuration XML if we have it.
		if ($xml)
		{
			$request->add_header('Content-Length', strlen($xml));
			$request->add_header('Content-Type', 'application/xml');
			$request->set_body($xml);
			
			$headers['Content-Length'] = strlen($xml);
			$headers['Content-Type'] = 'application/xml';
		}
		
		// Pass along registered stream callbacks
		if ($this->registered_streaming_read_callback)
		{
			$request->register_streaming_read_callback($this->registered_streaming_read_callback);
		}

		if ($this->registered_streaming_write_callback)
		{
			$request->register_streaming_write_callback($this->registered_streaming_write_callback);
		}

		$signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->secret_key, true));
		
		// X-Amzn-Authorization, required header by Route 53. http://docs.amazonwebservices.com/Route53/latest/APIReference/index.html?Headers.html
		$headers['X-Amzn-Authorization'] = 'AWS3' . ($this->use_ssl ? '-HTTPS' : '')
			. ' AWSAccessKeyId=' . $this->key
			. ',Algorithm=HmacSHA1'
			. ',Signature=' . $signature;
			
		$request->add_header('X-Amzn-Authorization', $headers['X-Amzn-Authorization']);

		// Required by Route 53
		$request->add_header('x-amz-date', $date);
		$request->add_header('Date', $date);
		
		// Update RequestCore settings
		$request->request_class = $this->request_class;
		$request->response_class = $this->response_class;
		$request->ssl_verification = $this->ssl_verification;
		
		$curlopts = array();

		// Set custom CURLOPT settings
		if (is_array($opt) && isset($opt['curlopts']))
		{
			$curlopts = $opt['curlopts'];
			unset($opt['curlopts']);
		}

		// Debug mode
		if ($this->debug_mode)
		{
			$curlopts[CURLOPT_VERBOSE] = true;
		}

		if (count($curlopts))
		{
			$request->set_curlopts($curlopts);
		}

		// Manage the (newer) batch request API or the (older) returnCurlHandle setting.
		if ($this->use_batch_flow)
		{
			$handle = $request->prep_request();
			$this->batch_object->add($handle);
			$this->use_batch_flow = false;

			return $handle;
		}
		elseif (isset($opt['returnCurlHandle']) && $opt['returnCurlHandle'] == (bool) true)
		{
			return $request->prep_request();
		}

		// Send!
		$request->send_request();

		// Prepare the response.
		$headers = $request->get_response_header();
		if ($xml) $headers['x-aws-body'] = $xml;

		$data =  new $this->response_class($headers, $this->parse_callback($request->get_response_body()), $request->get_response_code());

		// Was it Amazon's fault the request failed? Retry the request until we reach $max_retries.
		if ((integer) $request->get_response_code() === 500 || (integer) $request->get_response_code() === 503)
		{
			if ($redirects <= $this->max_retries)
			{
				// Exponential backoff
				$delay = (integer) (pow(4, $redirects) * 100000);
				usleep($delay);
				$data = $this->authenticate($method, $path, $opt, $xml, ++$redirects);
			}
		}

		return $data;
	}

	/**
	 * When caching is enabled, this method fires the request to the server, and the response is cached.
	 * Accepts identical parameters as <authenticate()>. You should never call this method directly—it is
	 * used internally by the caching system.
	 *
	 * @param string $method (Required) The HTTP method to use to connect. Accepts <code>GET</code>, <code>POST</code>, and <code>DELETE</code>
	 * @param string $path (Required) The endpoint path to make requests to.
	 * @param array $opt (Optional) An associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * @param string $xml (Optional) The XML body content to send along in the request.
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function cache_callback($method = 'GET', $path = null, $opt = null, $xml = null)	
	{
		// Disable the cache flow since it's already been handled.
		$this->use_cache_flow = false;

		// Make the request
		$response = $this->authenticate($method, $path, $opt, $xml);

		if (isset($response->body) && ($response->body instanceof SimpleXMLElement))
		{
			$response->body = $response->body->asXML();
		}

		return $response;
	}

	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * Overrides the <CFRuntime::disable_ssl()> method from the base class. SSL is required for Route 53.
	 *
	 * @return void
	 */
	public function disable_ssl()
	{
		throw new Route53_Exception('SSL/HTTPS is REQUIRED for Amazon Route 53 and cannot be disabled.');
	}

	/*%******************************************************************************************%*/
	// GENERATE XML

	/**
	 * Generates the hosted zone XML configuration used with <create_hosted_zone()>
	 *
	 * @param string $name (Required) The name of the domain. This must be a fully-specified domain that ends with a period as the last label indication. If you omit the final period, Amazon Route 53 assumes the domain is relative to the root. This is the name you have registered with your DNS registrar. You should ask your registrar to set the authoritative name servers for your domain so they are the same as the set of NameServers returned in DelegationSet.
	 * @param string $caller_reference (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * @param array $keypairs (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Comment</code> - <code>string</code> - Optional - Any comments you want to include about the hosted zone.</li></ul>
	 * @return string An XML document.
	 */
	public function generate_hosted_zone_xml($name, $caller_reference, $keypairs = null)
	{
		// Default, empty XML
		$xml = simplexml_load_string(sprintf($this->base_xml, ('CreateHostedZoneRequest')));
		
		// Domain name
		$xml->addChild('Name', $name);

		// Caller reference
		$xml->addChild('CallerReference', $caller_reference);
		
		// Comment
		if (isset($keypairs['Comment']))
		{
			$hosted_zone_config = $xml->addChild('HostedZoneConfig');
			$hosted_zone_config->addChild('Comment', $keypairs['Comment']);
		}		
		
		return $xml->asXML();
	}
	
	/**
	 * Generates the ChangeResourceRecordSets XML used with <change_rrset()>
	 *
	 * @param array $keypairs (Required) An associative array of parameters that can have the following keys: <ul>
	 *	<li><code>Comment</code> - <code>string</code> - Optional - Any comments you want to include about the change.</li>
	 *	<li><code>Changes</code> - <code>array</code> - Required - Information about the changes to make to the record sets (key can have one or more values).<ul>
	 *		<li><code>Action</code> - <code>string</code> - Required - The action to perform. Valid values: CREATE | DELETE.</li>
	 *		<li><code>ResourceRecordSet</code> - <code>array</code> - Required - Information about the resource record set to create or delete.<ul>
	 *			<li><code>Name</code> - <code>string</code> - Required - The name of the domain you want to perform the action on.</li>
	 *			<li><code>Type</code> - <code>string</code> - Required - The DNS record type.</li>
	 *			<li><code>TTL</code> - <code>string</code> - Optional - The resource record cache time to live (TTL), in seconds.</li>
	 *			<li><code>ResourceRecords</code> - <code>array</code> - Optional - Information about the resource records to act upon.<ul>
	 *				<li><code>ResourceRecord</code> - <code>array</code> - Required - Information specific to the resource record.<ul>
	 *					<li><code>Value</code> - <code>string</code> - Required - The current or new DNS record value, not to exceed 4,000 characters. In the case of a DELETE action, if the current value does not match the actual value, an error is returned.</li>
	 *				</ul></li>
	 *			</ul></li>
	 *			<li><code>AliasTarget</code> - <code>array</code> - Optional - Alias resource record sets only: Information about the domain to which you are redirecting traffic.<ul>
	 *				<li><code>HostedZoneId</code> - <code>string</code> - Required - Alias resource record sets only: The ID of the hosted zone that contains the Elastic Load Balancing domain to which you want to reroute traffic.</li>
	 *				<li><code>DNSName</code> - <code>string</code> - Required - Alias resource record sets only: The Elastic Load Balancing domain to which you want to reroute traffic.</li>
	 *			</ul></li>
	 *			<li><code>SetIdentifier</code> - <code>string</code> - Optional - Weighted resource record sets only: An identifier that differentiates among multiple resource record sets that have the same combination of DNS name and type.</li>
	 *			<li><code>Weight</code> - <code>integer</code> - Optional - Weighted resource record sets only: Among resource record sets that have the same combination of DNS name and type, a value that determines what portion of traffic for the current resource record set is routed to the associated location.</li>
	 *		</ul></li>
	 *	</ul></li></ul>
	 * @return string An XML document.
	 */
	public function generate_change_rrset_xml($keypairs = null)
	{
		// Default, empty XML
		$xml = simplexml_load_string(sprintf($this->base_xml, ('ChangeResourceRecordSetsRequest')));
		$change_batch = $xml->addChild('ChangeBatch');
		
		// Comment
		if (isset($keypairs['Comment']))
		{
			$change_batch->addChild('Comment', $keypairs['Comment']);
		}
		
		// Changes
		if (isset($keypairs['Changes']))
		{
			$changes_xml = $change_batch->addChild('Changes');
			
			foreach ($keypairs['Changes'] as $changes)
			{
				$change_xml = $changes_xml->addChild('Change');
				
				// Traverse recursively and add XML childs
				$this->traverse_xml_add($change_xml, $changes);
			}
		}		
		
		return $xml->asXML();
	}
	
	/*%******************************************************************************************%*/
	// HOSTED ZONE

	/**
	 * Creates a new Amazon Route 53 hosted zone.
	 *
	 * @param string $name (Required) The name of the domain. This must be a fully-specified domain that ends with a period as the last label indication. If you omit the final period, Amazon Route 53 assumes the domain is relative to the root. This is the name you have registered with your DNS registrar. You should ask your registrar to set the authoritative name servers for your domain so they are the same as the set of NameServers returned in DelegationSet.
	 * @param string $caller_reference (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * @param array $keypairs (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Comment</code> - <code>string</code> - Optional - Any comments you want to include about the hosted zone.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/APIReference/API_CreateHostedZone.html POST CreateHostedZone 
	 */
	public function create_hosted_zone($name, $caller_reference, $keypairs = null)
	{
		if (!$keypairs) $keypairs = array();

		$xml = $this->generate_hosted_zone_xml($name, $caller_reference, $keypairs);
		$path = '/hostedzone';

		return $this->authenticate('POST', $path, null, $xml);
	}

	/**
	 * Gets hosted zone information for the specified zone ID.
	 *
	 * @param string $zone_ID (Required) The hosted zone ID.
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/APIReference/API_GetHostedZone.html GET GetHostedZone
	 */
	public function get_hosted_zone($zone_ID = null)	
	{
		if (!$zone_ID)
		{
			throw new Route53_Exception('Hosted zone ID parameter is REQUIRED.');
		}
		
		$path = '/hostedzone/' . trim($zone_ID);

		return $this->authenticate('GET', $path);
	}

	/**
	 * Deletes hosted zone.
	 *
	 * @param string $zone_ID (Required) The hosted zone ID.
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/APIReference/API_DeleteHostedZone.html DELETE DeleteHostedZone
	 */
	public function delete_hosted_zone($zone_ID = null)	
	{
		if (!$zone_ID)
		{
			throw new Route53_Exception('Hosted zone ID parameter is REQUIRED.');
		}
		
		$path = '/hostedzone/' . trim($zone_ID);

		return $this->authenticate('DELETE', $path);
	}

	/**
	 * Gets the list of hosted zones.
	 *
	 * @param string $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Marker</code> - <code>string</code> - Optional - Indicates where to begin in your list of hosted zones. The results include hosted zones in the list that occur after the marker.</li>
	 * 	<li><code>MaxItems</code> - <code>string</code> - Optional - The maximum number of hosted zones to be included in the response body.</li>
	 * </ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/APIReference/API_ListHostedZones.html GET ListHostedZones
	 */
	public function list_hosted_zone($opt = null)
	{
		if (!$opt) $opt = array();
		$opt['query_string'] = array();

		// Pass these to the query string
		foreach (array('Marker', 'MaxItems') as $option)
		{
			if (isset($opt[$option]))
			{
				$opt['query_string'][strtolower($option)] = $opt[$option];
			}
		}

		$path = '/hostedzone';

		return $this->authenticate('GET', $path, $opt);
	}

	/*%******************************************************************************************%*/
	// RESOURCE RECORD SETS

	/**
	 * Creates or change authoritative DNS information.
	 *
	 * @param string $zone_ID (Required) The hosted zone ID.
	 * @param array $keypairs (Required) An associative array of parameters that can have the following keys: <ul>
	 *	<li><code>Comment</code> - <code>string</code> - Optional - Any comments you want to include about the change.</li>
	 *	<li><code>Changes</code> - <code>array</code> - Required - Information about the changes to make to the record sets (key can have one or more values).<ul>
	 *		<li><code>Action</code> - <code>string</code> - Required - The action to perform. Valid values: CREATE | DELETE.</li>
	 *		<li><code>ResourceRecordSet</code> - <code>array</code> - Required - Information about the resource record set to create or delete.<ul>
	 *			<li><code>Name</code> - <code>string</code> - Required - The name of the domain you want to perform the action on.</li>
	 *			<li><code>Type</code> - <code>string</code> - Required - The DNS record type.</li>
	 *			<li><code>TTL</code> - <code>string</code> - Optional - The resource record cache time to live (TTL), in seconds.</li>
	 *			<li><code>ResourceRecords</code> - <code>array</code> - Optional - Information about the resource records to act upon.<ul>
	 *				<li><code>ResourceRecord</code> - <code>array</code> - Required - Information specific to the resource record.<ul>
	 *					<li><code>Value</code> - <code>string</code> - Required - The current or new DNS record value, not to exceed 4,000 characters. In the case of a DELETE action, if the current value does not match the actual value, an error is returned.</li>
	 *				</ul></li>
	 *			</ul></li>
	 *			<li><code>AliasTarget</code> - <code>array</code> - Optional - Alias resource record sets only: Information about the domain to which you are redirecting traffic.<ul>
	 *				<li><code>HostedZoneId</code> - <code>string</code> - Required - Alias resource record sets only: The ID of the hosted zone that contains the Elastic Load Balancing domain to which you want to reroute traffic.</li>
	 *				<li><code>DNSName</code> - <code>string</code> - Required - Alias resource record sets only: The Elastic Load Balancing domain to which you want to reroute traffic.</li>
	 *			</ul></li>
	 *			<li><code>SetIdentifier</code> - <code>string</code> - Optional - Weighted resource record sets only: An identifier that differentiates among multiple resource record sets that have the same combination of DNS name and type.</li>
	 *			<li><code>Weight</code> - <code>integer</code> - Optional - Weighted resource record sets only: Among resource record sets that have the same combination of DNS name and type, a value that determines what portion of traffic for the current resource record set is routed to the associated location.</li>
	 *		</ul></li>
	 *	</ul></li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/APIReference/API_ChangeResourceRecordSets.html POST ChangeResourceRecordSets 
	 */
	public function change_rrset($zone_ID = null, $keypairs = null)
	{
		if (!$keypairs) $keypairs = array();

		$xml = $this->generate_change_rrset_xml($keypairs);
		$path = '/hostedzone/' . trim($zone_ID) . '/rrset';
		
		return $this->authenticate('POST', $path, null, $xml);
	}

	/**
	 * Gets the list of resource record sets.
	 *
	 * @param string $zone_ID (Required) The hosted zone ID.
	 * @param string $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Name</code> - <code>string</code> - Optional - The first name in the lexicographic ordering of domain names to be retrieved in the response to the <code>ListResourceRecordSets</code> request.</li>
	 * 	<li><code>Type</code> - <code>string</code> - Optional - The type of resource record set to begin the record listing from.</li>
	 * 	<li><code>Identifier</code> - <code>string</code> - Optional - Weighted resource record sets only: If results were truncated for a given DNS name and type, the value of <code>SetIdentifier</code> for the next resource record set that has the current DNS name and type.</li>
	 * 	<li><code>Maxitems</code> - <code>string</code> - Optional - The maximum number of records you want in the response body.</li> 
	 * </ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/APIReference/API_ListResourceRecordSets.html GET ListResourceRecordSets
	 */
	public function list_rrset($zone_ID = null, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['query_string'] = array();

		// Pass these to the query string
		foreach (array('Name', 'Type', 'Identifier', 'MaxItems') as $option)
		{
			if (isset($opt[$option]))
			{
				$opt['query_string'][strtolower($option)] = $opt[$option];
			}
		}

		$path = '/hostedzone/' . trim($zone_ID) . '/rrset';

		return $this->authenticate('GET', $path, $opt);
	}
	
	/**
	 * Gets the current state of a change request. The state of a change is either PENDING or INSYNC.
	 *
	 * @param string $change_ID (Required) The request change ID.
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 * @link http://docs.amazonwebservices.com/Route53/latest/APIReference/API_GetChange.html GET GetChange
	 */
	public function get_change_status($change_ID = null)
	{
		$path = '/change/' . trim($change_ID);

		return $this->authenticate('GET', $path);
	}
	
	/*%******************************************************************************************%*/
	// HELPERS

	/**
	 * Traverse recursively through array (key-pairs) and add childs on the XML object.
	 *
	 * @param object $xml (Required) XML object.
	 * @param string $keypairs (Optional) An associative array.
	 * @return null
	 */
	private function traverse_xml_add($xml = null, $keypairs = null)
	{
		if (!isset($keypairs))
		{
			return;
		}
		
		foreach ($keypairs as $key => $value)
		{
			if (is_array($value))
			{
				$child_xml = $xml->addChild(((string) $key));
				$this->traverse_xml_add($child_xml, $value);
				unset($child_xml);
			} else {
				$xml->addChild(((string) $key), $value);
			}
		}
		
		return;
	}

	/**
	 * Try fetching AWS system time/date to be used as a string to sign for authentication. If failed, generate one, locally. 
	 *
	 * @return string datetime (RFC2616 format)
	 * @link http://docs.amazonwebservices.com/Route53/latest/DeveloperGuide/RESTAuthentication.html Authenticating REST Requests
	 */
	private function fetch_date()
	{
		// Compose the endpoint URL.
		$request_url = 'https://route53.amazonaws.com/date';
		
		// Compose the request.
		$request = new $this->request_class($request_url);
		$request->set_method('GET');

		// Send!
		$request->send_request();

		// Prepare the response.
		$headers = $request->get_response_header();

		$response = new $this->response_class($headers, $this->parse_callback($request->get_response_body()), $request->get_response_code());
		
		// Request failed? Generate one instead and adjust offset
		if ((integer) $request->get_response_code() === 500 || (integer) $request->get_response_code() === 503)
		{
			$current_time = time() + $this->adjust_offset;
			$date = gmdate(CFUtilities::DATE_FORMAT_RFC2616, $current_time);
		}
		else
		{
			$date = $response->header['date'];
		}
		
		return $date;
	}
	
}

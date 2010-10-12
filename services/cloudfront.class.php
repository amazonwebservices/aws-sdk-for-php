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
 * File: CloudFront
 * 	Amazon CloudFront is a web service for content delivery. It makes it easier for you to distribute content
 * 	to end users quickly, with low latency and high data transfer speeds.
 *
 * 	CloudFront delivers your content through a worldwide network of edge locations. End users are routed to
 * 	the nearest edge location, so content is delivered with the best possible performance. CloudFront works
 * 	seamlessly with the Amazon Simple Storage Service, which durably stores the original, definitive versions
 * 	of your files.
 *
 * Version:
 * 	2010.10.11
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[Amazon CloudFront](http://aws.amazon.com/cloudfront/)
 * 	[Amazon CloudFront documentation](http://aws.amazon.com/documentation/cloudfront/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: CloudFront_Exception
 * 	Default CloudFront Exception.
 */
class CloudFront_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonCloudFront
 * 	Container for all Amazon CloudFront-related methods. Inherits additional methods from CFRuntime.
 */
class AmazonCloudFront extends CFRuntime
{
	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'cloudfront.amazonaws.com';

	/**
	 * Constant: STATE_INPROGRESS
	 * 	The InProgress state.
	 */
	const STATE_INPROGRESS = 'InProgress';

	/**
	 * Constant: STATE_DEPLOYED
	 * 	The Deployed state.
	 */
	const STATE_DEPLOYED = 'Deployed';

	/**
	 * Property: base_standard_xml
	 * 	The base content to use for generating the DistributionConfig XML.
	 */
	var $base_xml;

	/**
	 * Property: domain
	 * 	The CloudFront distribution domain to use.
	 */
	var $domain;

	/**
	 * Property: key_pair_id
	 * 	The RSA key pair ID to use.
	 */
	var $key_pair_id;

	/**
	 * Property: private_key
	 * 	The RSA private key resource locator.
	 */
	var $private_key;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonCloudFront>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$key - _string_ (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * 	$secret_key - _string_ (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 *
	 * Returns:
	 * 	_boolean_ A value of `false` if no valid values are set, otherwise `true`.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->api_version = '2010-08-01';
		$this->hostname = self::DEFAULT_URL;

		$this->base_xml = '<?xml version="1.0" encoding="UTF-8"?><%s xmlns="http://cloudfront.amazonaws.com/doc/' . $this->api_version . '/"></%1$s>';

		if (!$key && !defined('AWS_KEY'))
		{
			throw new CloudFront_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new CloudFront_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		// Set a default key pair ID
		if (defined('AWS_CLOUDFRONT_KEYPAIR_ID'))
		{
			$this->key_pair_id = AWS_CLOUDFRONT_KEYPAIR_ID;
		}

		// Set a default private key
		if (defined('AWS_CLOUDFRONT_PRIVATE_KEY_PEM'))
		{
			$this->private_key = AWS_CLOUDFRONT_PRIVATE_KEY_PEM;
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// AUTHENTICATION

	/**
	 * Method: authenticate()
	 * 	Authenticates a connection to Amazon CloudFront. This method should not be used directly unless
	 * 	you're writing custom methods for this class.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$method - _string_ (Required) The HTTP method to use to connect. Accepts <HTTP_GET>, <HTTP_POST>, <HTTP_PUT>, <HTTP_DELETE>, and <HTTP_HEAD>.
	 * 	$path - _string_ (Optional) The endpoint path to make requests to.
	 * 	$opt - _array_ (Optional) An associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * 	$xml - _string_ (Optional) The XML body content to send along in the request.
	 * 	$etag - _string_ (Optional) The ETag value to pass along with the If-Match HTTP header.
	 * 	$redirects - _integer_ (Do Not Use) Used internally by this function on occasions when Amazon S3 returns a redirect code and it needs to call itself recursively.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[Authentication](http://docs.amazonwebservices.com/AmazonCloudFront/latest/DeveloperGuide/RESTAuthentication.html)
	 */
	public function authenticate($method = 'GET', $path = null, $opt = null, $xml = null, $etag = null, $redirects = 0)
	{
		if (!$opt) $opt = array();
		$querystring = null;

		$method_arguments = func_get_args();

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

		// Update RequestCore settings
		$request->request_class = $this->request_class;
		$request->response_class = $this->response_class;

		// Enable debug headers
		if ($this->debug_mode)
		{
			$request->set_curlopts(array(
				CURLOPT_VERBOSE => true
			));
		}

		// Generate required headers.
		$request->set_method($method);
		$canonical_date = gmdate($this->util->konst($this->util, 'DATE_FORMAT_RFC2616'));
		$request->add_header('x-amz-date', $canonical_date);
		$signature = base64_encode(hash_hmac('sha1', $canonical_date, $this->secret_key, true));
		$request->add_header('Authorization', 'AWS ' . $this->key . ':' . $signature);

		// Add configuration XML if we have it.
		if ($xml)
		{
			$request->add_header('Content-Length', strlen($xml));
			$request->add_header('Content-Type', 'application/xml');
			$request->set_body($xml);
		}

		// Set If-Match: ETag header if we have one.
		if ($etag)
		{
			$request->add_header('If-Match', $etag);
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
				$data = $this->authenticate($method, $path, $opt, $xml, $etag, ++$redirects);
			}
		}

		return $data;
	}

	/**
	 * Method: cache_callback()
	 * 	When caching is enabled, this method fires the request to the server, and the response is cached.
	 * 	Accepts identical parameters as <authenticate()>. You should never call this method directly—it is
	 * 	used internally by the caching system.
	 *
	 * Access:
	 * 	public
 	 *
	 * Parameters:
	 * 	$method - _string_ (Required) The HTTP method to use to connect. Accepts <HTTP_GET>, <HTTP_POST>, <HTTP_PUT>, <HTTP_DELETE>, and <HTTP_HEAD>.
	 * 	$path - _string_ (Optional) The endpoint path to make requests to.
	 * 	$opt - _array_ (Optional) An associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * 	$xml - _string_ (Optional) The XML body content to send along in the request.
	 * 	$etag - _string_ (Optional) The ETag value to pass along with the If-Match HTTP header.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function cache_callback($method = 'GET', $path = null, $opt = null, $xml = null, $etag = null)
	{
		// Disable the cache flow since it's already been handled.
		$this->use_cache_flow = false;

		// Make the request
		$response = $this->authenticate($method, $path, $opt, $xml, $etag);

		if (isset($response->body) && ($response->body instanceof SimpleXMLElement))
		{
			$response->body = $response->body->asXML();
		}

		return $response;
	}


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * Method: set_keypair_id()
	 * 	Set the key ID of the RSA key pair being used.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$key_pair_id - _string_ (Required) The ID of the RSA key pair being used.
	 *
	 * Returns:
	 * 	`$this` A reference to the current instance.
	 */
	public function set_keypair_id($key_pair_id)
	{
		$this->key_pair_id = $key_pair_id;
		return $this;
	}

	/**
	 * Method: set_private_key()
	 * 	Set the private key resource locator being used.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 *	$private_key - _string_ (Optional) The contents of the RSA private key used to sign requests.
	 *
	 * Returns:
	 * 	`$this` A reference to the current instance.
	 */
	public function set_private_key($private_key)
	{
		$this->private_key = $private_key;
		return $this;
	}

	/**
	 * Method: disable_ssl()
	 * 	Overrides the <CFRuntime::disable_ssl()> method from the base class. SSL is required for CloudFront.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	void
	 */
	public function disable_ssl()
	{
		throw new CloudFront_Exception('SSL/HTTPS is REQUIRED for Amazon CloudFront and cannot be disabled.');
	}


	/*%******************************************************************************************%*/
	// GENERATE CONFIG XML

	/**
	 * Method: generate_config_xml()
	 * 	Generates the distribution configuration XML used with <create_distribution()> and
	 * 	<set_distribution_config()>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$origin - _string_ (Required) The source Amazon S3 bucket to use for the Amazon CloudFront distribution.
	 * 	$caller_reference - _string_ (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	CNAME - _string_|_array_ (Optional) A DNS CNAME to use to map to the Amazon CloudFront distribution. If setting more than one, use an indexed array. Supports 1-10 CNAMEs.
	 * 	Comment - _string_ (Optional) A comment to apply to the distribution. Cannot exceed 128 characters.
	 * 	DefaultRootObject - _string_ (Optional) The file to load when someone accesses the root of your Amazon CloudFront domain (e.g., `index.html`).
	 * 	Enabled - _string_ (Optional) A value of `true` enables the distribution. A value of `false` disables it. Defaults to `true`.
	 * 	Logging - _array_ (Optional) An array that contains two keys: `Bucket`, specifying where logs are written to, and `Prefix`, specifying a prefix to append to log file names.
	 * 	OriginAccessIdentity - _string_ (Optional) The origin access identity (OAI) associated with this distribution. Use the Identity ID from the OAI, not the `CanonicalId`.
	 * 	Streaming - _boolean_ (Optional) Whether or not this should be for a streaming distribution. A value of `true` will create a streaming distribution. A value of `false` will create a standard distribution. Defaults to `false`.
	 * 	TrustedSigners - _array_ (Optional) An array of AWS account numbers for users who are trusted signers. Explicity add the value `Self` to the array to add your own account as a trusted signer.
	 *
	 * Returns:
	 * 	_string_ An XML document to be used as the distribution configuration.
	 */
	public function generate_config_xml($origin, $caller_reference, $opt = null)
	{
		// Default, empty XML
		$xml = simplexml_load_string(sprintf($this->base_xml, (
			(isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'StreamingDistributionConfig' : 'DistributionConfig')
		));

		// Origin
		$xml->addChild('Origin', $origin . ((stripos($origin, '.s3.amazonaws.com') === false) ? '.s3.amazonaws.com' : ''));

		// CallerReference
		$xml->addChild('CallerReference', $caller_reference);

		// CNAME
		if (isset($opt['CNAME']))
		{
			if (is_array($opt['CNAME']))
			{
				foreach ($opt['CNAME'] as $cname)
				{
					$xml->addChild('CNAME', $cname);
				}
			}
			else
			{
				$xml->addChild('CNAME', $opt['CNAME']);
			}
		}

		// Comment
		if (isset($opt['Comment']))
		{
			$xml->addChild('Comment', $opt['Comment']);
		}

		// Enabled
		if (isset($opt['Enabled']))
		{
			$xml->addChild('Enabled', $opt['Enabled'] ? 'true' : 'false');
		}
		else
		{
			$xml->addChild('Enabled', 'true');
		}

		// Logging
		if (isset($opt['Logging']))
		{
			if (is_array($opt['Logging']))
			{
				$logging = $xml->addChild('Logging');
				$bucket_name = $opt['Logging']['Bucket'];

				// Origin
				$logging->addChild('Bucket', $bucket_name . (
					(stripos($bucket_name, '.s3.amazonaws.com') === false) ? '.s3.amazonaws.com' : ''
				));

				$logging->addChild('Prefix', $opt['Logging']['Prefix']);
			}
		}

		// Required Protocols
		if (isset($opt['RequiredProtocols']))
		{
			$required_protocols = $xml->addChild('RequiredProtocols');
			$required_protocols->addChild('Protocol', $opt['RequiredProtocols']);
		}

		// origin access identity
		if (isset($opt['OriginAccessIdentity']))
		{
			$xml->addChild('OriginAccessIdentity', 'origin-access-identity/cloudfront/' . $opt['OriginAccessIdentity']);
		}

		// Trusted Signers
		if (isset($opt['TrustedSigners']))
		{
			$trusted_signers = $xml->addChild('TrustedSigners');

			// Not an array? Convert to one.
			if (!is_array($opt['TrustedSigners']))
			{
				$opt['TrustedSigners'] = array($opt['TrustedSigners']);
			}

			// Handle 'Self' vs. everything else
			foreach ($opt['TrustedSigners'] as $signer)
			{
				if (strtolower($signer) === 'self')
				{
					$trusted_signers->addChild('Self');
				}
				else
				{
					$trusted_signers->addChild('AWSAccountNumber', $signer);
				}
			}
		}

		// DefaultRootObject
		if (isset($opt['DefaultRootObject']))
		{
			$xml->addChild('DefaultRootObject', $opt['DefaultRootObject']);
		}

		return $xml->asXML();
	}

	/**
	 * Method: update_config_xml()
	 * 	Updates an existing configuration XML document.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$xml - _CFSimpleXML_|_CFResponse_|_string_ (Required) The source configuration XML to make updates to. Can be the <CFSimpleXML> body of a <get_distribution_config()> response, the entire <CFResponse> of a <get_distribution_config()> response, or a string of XML generated by <generate_config_xml()> or <update_config_xml()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	CNAME - _string_|_array_ (Optional) The value or values to add to the existing list of CNAME values. If setting more than one, use an indexed array. Supports up to 10 CNAMEs.
	 * 	Comment - _string_ (Optional) A comment to apply to the distribution. Cannot exceed 128 characters.
	 * 	DefaultRootObject - _string_ (Optional) The file to load when someone accesses the root of your Amazon CloudFront domain (e.g., `index.html`).
	 * 	Enabled - _string_ (Optional) A value of `true` enables the distribution. A value of `false` disables it. Defaults to `true`.
	 * 	Logging - _array_ (Optional) An array that contains two keys: `Bucket`, specifying where logs are written to, and `Prefix`, specifying a prefix to append to log file names.
	 * 	OriginAccessIdentity - _string_ (Optional) The origin access identity (OAI) associated with this distribution. Use the Identity ID from the OAI, not the `CanonicalId`.
	 * 	TrustedSigners - _array_ (Optional) An array of AWS account numbers for users who are trusted signers. Explicity add the value `Self` to the array to add your own account as a trusted signer.
	 *
	 * Returns:
	 * 	_string_ XML document.
	 */
	public function update_config_xml($xml, $opt = null)
	{
		// If we receive a full CFResponse object, only use the body.
		if ($xml instanceof CFResponse)
		{
			$xml = $xml->body;
		}

		// If we received a string of XML, convert it into a CFSimpleXML object.
		if (is_string($xml))
		{
			$xml = simplexml_load_string($xml, $this->parser_class);
		}

		// Default, empty XML
		$update = simplexml_load_string(sprintf($this->base_xml, (
			(isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'StreamingDistributionConfig' : 'DistributionConfig')
		), $this->parser_class);

		// These can't change.
		$update->addChild('Origin', $xml->Origin);
		$update->addChild('CallerReference', $xml->CallerReference);

		// Add existing CNAME values
		if ($xml->CNAME)
		{
			$update->addChild('CNAME', $xml->CNAME);
		}

		// Add new CNAME values
		if (isset($opt['CNAME']))
		{
			if (is_array($opt['CNAME']))
			{
				foreach ($opt['CNAME'] as $cname)
				{
					$update->addChild('CNAME', $cname);
				}
			}
			else
			{
				$update->addChild('CNAME', $opt['CNAME']);
			}
		}

		// Comment
		if (isset($opt['Comment']))
		{
			$update->addChild('Comment', $opt['Comment']);
		}
		elseif (isset($xml->Comment))
		{
			$update->addChild('Comment', $xml->Comment);
		}

		// DefaultRootObject
		if (isset($opt['DefaultRootObject']))
		{
			$update->addChild('DefaultRootObject', $opt['DefaultRootObject']);
		}
		elseif (isset($xml->DefaultRootObject))
		{
			$update->addChild('DefaultRootObject', $xml->DefaultRootObject);
		}

		// Enabled
		if (isset($opt['Enabled']))
		{
			$update->addChild('Enabled', $opt['Enabled'] ? 'true' : 'false');
		}
		elseif (isset($xml->Enabled))
		{
			$update->addChild('Enabled', $xml->Enabled);
		}

		// Logging
		if (isset($opt['Logging']))
		{
			if (is_array($opt['Logging']))
			{
				$logging = $update->addChild('Logging');
				$bucket_name = $opt['Logging']['Bucket'];

				// Origin
				$logging->addChild('Bucket', $bucket_name . ((stripos($bucket_name, '.s3.amazonaws.com') === false) ? '.s3.amazonaws.com' : ''));

				$logging->addChild('Prefix', $opt['Logging']['Prefix']);
			}
		}
		elseif (isset($xml->Logging))
		{
			$logging = $update->addChild('Logging');
			$logging->addChild('Bucket', $xml->Logging->Bucket);
			$logging->addChild('Prefix', $xml->Logging->Prefix);
		}

		// origin access identity
		if (isset($opt['OriginAccessIdentity']))
		{
			$update->addChild('OriginAccessIdentity', 'origin-access-identity/cloudfront/' . $opt['OriginAccessIdentity']);
		}
		elseif (isset($xml->OriginAccessIdentity))
		{
			$update->addChild('OriginAccessIdentity', $xml->OriginAccessIdentity);
		}

		// Trusted Signers
		if (isset($opt['TrustedSigners']))
		{
			$trusted_signers = $update->addChild('TrustedSigners');

			// Not an array? Convert to one.
			if (!is_array($opt['TrustedSigners']))
			{
				$opt['TrustedSigners'] = array($opt['TrustedSigners']);
			}

			// Handle 'Self' vs. everything else
			foreach ($opt['TrustedSigners'] as $signer)
			{
				if (strtolower($signer) === 'self')
				{
					$trusted_signers->addChild('Self');
				}
				else
				{
					$trusted_signers->addChild('AWSAccountNumber', $signer);
				}
			}
		}
		elseif (isset($xml->TrustedSigners) && $xml->TrustedSigners->count())
		{
			$trusted_signers = $update->addChild('TrustedSigners');

			// Handle 'Self' vs. everything else
			foreach ($xml->TrustedSigners->children() as $signer_key => $signer_value)
			{
				if (strtolower((string) $signer_key) === 'self')
				{
					$trusted_signers->addChild('Self');
				}
				else
				{
					$trusted_signers->addChild('AWSAccountNumber', (string) $signer_value);
				}
			}
		}

		// Output
		return $update->asXML();
	}

	/**
	 * Method: remove_cname()
	 * 	Removes one or more CNAMEs from a `DistibutionConfig` XML document.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$xml - _CFSimpleXML_|_CFResponse_|_string_ (Required) The source DistributionConfig XML to make updates to. Can be the <CFSimpleXML> body of a <get_distribution_config()> response, the entire <CFResponse> of a <get_distribution_config()> response, or a string of XML generated by <generate_config_xml()> or <update_config_xml()>.
	 * 	$cname - _string_|_array_ (Optional) The value or values to remove from the existing list of CNAME values. To add a CNAME value, see <update_config_xml()>.
	 *
	 * Returns:
	 * 	_string_ XML document.
	 */
	public function remove_cname($xml, $cname)
	{
		// If we receive a full CFResponse object, only use the body.
		if ($xml instanceof CFResponse)
		{
			$xml = $xml->body;
		}

		// If we received a string of XML, convert it into a CFSimpleXML object.
		if (is_string($xml))
		{
			$xml = simplexml_load_string($xml);
		}

		// Let's make sure that we have CNAMEs to remove in the first place.
		if (isset($xml->CNAME))
		{
			// If we have an array of CNAME values...
			if (is_array($cname))
			{
				foreach ($cname as $cn)
				{
					for ($i = 0, $length = sizeof($xml->CNAME); $i < $length; $i++)
					{
						if ((string) $xml->CNAME[$i] == $cn)
						{
							unset($xml->CNAME[$i]);
							break;
						}
					}
				}
			}

			// If we only have one CNAME value...
			else
			{
				for ($i = 0, $length = sizeof($xml->CNAME); $i < $length; $i++)
				{
					if ((string) $xml->CNAME[$i] == $cname)
					{
						unset($xml->CNAME[$i]);
						break;
					}
				}
			}
		}

		return $xml->asXML();
	}

	/**
	 * Method: generate_oai_xml()
	 * 	Used to generate the origin access identity (OAI) Config XML used in <create_oai()>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$caller_reference - _string_ (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	Comment - _string_ (Optional) Replaces the existing value for "Comment". Cannot exceed 128 characters.
	 *
	 * Returns:
	 * 	_string_ An XML document to be used as the OAI configuration.
	 */
	public function generate_oai_xml($caller_reference, $opt = null)
	{
		// Default, empty XML
		$xml = simplexml_load_string(sprintf($this->base_xml, 'CloudFrontOriginAccessIdentityConfig'));

		// CallerReference
		$xml->addChild('CallerReference', $caller_reference);

		// Comment
		if (isset($opt['Comment']))
		{
			$xml->addChild('Comment', $opt['Comment']);
		}

		return $xml->asXML();
	}

	/**
	 * Method: update_oai_xml()
	 * 	Updates the origin access identity (OAI) configureation XML used in <create_oai()>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$xml - _CFSimpleXML_|_CFResponse_|_string_ (Required) The source configuration XML to make updates to. Can be the <CFSimpleXML> body of a <get_oai_config()> response, the entire <CFResponse> of a <get_oai_config()> response, or a string of XML generated by <generate_oai_xml()> or <update_oai_xml()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	Comment - _string_ (Optional) Replaces the existing value for "Comment". Cannot exceed 128 characters.
	 *
	 * Returns:
	 * 	_string_ XML document.
	 */
	public function update_oai_xml($xml, $opt = null)
	{
		// If we receive a full CFResponse object, only use the body.
		if ($xml instanceof CFResponse)
		{
			$xml = $xml->body;
		}

		// If we received a string of XML, convert it into a CFSimpleXML object.
		if (is_string($xml))
		{
			$xml = simplexml_load_string($xml, $this->parser_class);
		}

		// Update the comment, if we have one.
		if (isset($opt['Comment']) && isset($xml->Comment))
		{
			$xml->Comment = $opt['Comment'];
		}
		elseif (isset($opt['Comment']))
		{
			$xml->addChild('Comment', $opt['Comment']);
		}

		return $xml->asXML();
	}

	/**
	 * Method: generate_invalidation_xml()
	 * 	Generates the Invalidation Config XML used in <create_invalidation()>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$caller_reference - _string_ (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	Paths - _string_|_array_ (Optional) One or more paths to set for invalidation. Pass a string for a single value, or an indexed array for multiple values..
	 *
	 * Returns:
	 * 	_string_ An XML document to be used as the Invalidation configuration.
	 */
	public function generate_invalidation_xml($caller_reference, $opt = null)
	{
		// Default, empty XML
		$xml = simplexml_load_string(sprintf($this->base_xml, 'InvalidationBatch'));

		// CallerReference
		$xml->addChild('CallerReference', $caller_reference);

		// Paths
		if (isset($opt['Paths']))
		{
			$paths = is_array($opt['Paths']) ? $opt['Paths'] : array($opt['Paths']);

			foreach ($paths as $path)
			{
				$path = (substr($path, 0, 1) === '/') ? $path : ('/' . $path);
				$xml->addChild('Path', $path);
			}
		}

		return $xml->asXML();
	}


	/*%******************************************************************************************%*/
	// DISTRIBUTIONS

	/**
	 * Method: create_distribution()
	 * 	Creates an Amazon CloudFront distribution. You can have up to 100 distributions in the Amazon
	 * 	CloudFront system.
	 *
	 * 	For an Adobe Real-Time Messaging Protocol (RTMP) streaming distribution, set the `Streaming` option
	 * 	to true.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$origin - _string_ (Required) The source S3 bucket to use for the Amazon CloudFront distribution.
	 * 	$caller_reference - _string_ (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	CNAME - _string_|_array_ (Optional) A DNS CNAME to use to map to the Amazon CloudFront distribution. If setting more than one, use an indexed array. Supports 1-10 CNAMEs.
	 * 	Comment - _string_ (Optional) A comment to apply to the distribution. Cannot exceed 128 characters.
	 * 	DefaultRootObject - _string_ (Optional) The file to load when someone accesses the root of the Amazon CloudFront domain (e.g., `index.html`).
	 * 	Enabled - _string_ (Optional) A value of `true` will enable the distribution. A value of `false` will disable it. Defaults to `true`.
	 * 	OriginAccessIdentity - _string_ (Optional) The origin access identity (OAI) associated with this distribution. Use the Identity ID from the OAI, not the `CanonicalId`.
	 * 	Streaming - _boolean_ (Optional) Whether or not this should be for a streaming distribution. A value of `true` creates a streaming distribution. A value of `false` creates a standard distribution. Defaults to `false`.
	 * 	TrustedSigners - _array_ (Optional) An array of AWS account numbers for users who are trusted signers. Explicity add the value `Self` to the array to add your own account as a trusted signer.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [POST Distribution](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/CreateDistribution.html)
	 * 	- [POST Streaming Distribution](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/CreateStreamingDistribution.html)
	 */
	public function create_distribution($origin, $caller_reference, $opt = null)
	{
		if (!$opt) $opt = array();

		$xml = $this->generate_config_xml($origin, $caller_reference, $opt);
		$path = '/' . ((isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'streaming-distribution' : 'distribution');

		return $this->authenticate('POST', $path, $opt, $xml, null);
	}

	/**
	 * Method: list_distributions()
	 * 	Gets a list of distributions. By default, the list is returned as one result. If needed, paginate the
	 * 	list by specifying values for the `MaxItems` and `Marker` parameters.
	 *
	 * 	Standard distributions are listed separately from streaming distributions. For streaming distributions,
	 * 	set the `Streaming` option to true.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	Marker - _string_ (Optional) Use this setting when paginating results to indicate where in your list of distributions to begin. The results include distributions in the list that occur after the marker. To get the next page of results, set the `Marker` to the value of the `NextMarker` from the current page's response (which is also the ID of the last distribution on that page).
	 * 	MaxItems - _integer_ (Optional) The maximum number of distributions you want in the response body. Maximum of 100.
	 * 	Streaming - _boolean_ (Optional) Whether or not this should be for a streaming distribution. A value of `true` will create a streaming distribution. A value of `false` will create a standard distribution. Defaults to `false`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Distribution List](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/ListDistributions.html)
	 * 	- [GET Streaming Distribution List](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/ListStreamingDistributions.html)
	 */
	public function list_distributions($opt = null)
	{
		if (!$opt) $opt = array();
		$opt['query_string'] = array();

		// Pass these to the query string
		foreach (array('Marker', 'MaxItems') as $option)
		{
			if (isset($opt[$option]))
			{
				$opt['query_string'][$option] = $opt[$option];
			}
		}

		$path = '/' . ((isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'streaming-distribution' : 'distribution');

		return $this->authenticate('GET', $path, $opt, null, null);
	}

	/**
	 * Method: get_distribution_info()
	 * 	Gets distribution information for the specified distribution ID.
	 *
	 * 	Standard distributions are handled separately from streaming distributions. For streaming
	 * 	distributions, set the `Streaming` option to true.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_id - _string_ (Required) The distribution ID returned from <create_distribution()> or <list_distributions()>.
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	Streaming - _boolean_ (Optional) Whether or not this should be for a streaming distribution. A value of `true` will create a streaming distribution. A value of `false` will create a standard distribution. Defaults to `false`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Distribution](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/GetDistribution.html)
	 * 	- [GET Streaming Distribution](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/GetStreamingDistribution.html)
	 */
	public function get_distribution_info($distribution_id, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/' . ((isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'streaming-distribution' : 'distribution');
		$path .= '/' . $distribution_id;

		return $this->authenticate('GET', $path, $opt, null, null);
	}

	/**
	 * Method: delete_distribution()
	 * 	Deletes a disabled distribution. If distribution hasn't been disabled, Amazon CloudFront returns a
	 * 	`DistributionNotDisabled` error. Use <set_distribution_config()> to disable a distribution before
	 * 	attempting to delete.
	 *
	 * 	For an Adobe Real-Time Messaging Protocol (RTMP) streaming distribution, set the `Streaming` option
	 * 	to be `true`.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_id - _string_ (Required) The distribution ID returned from <create_distribution()> or <list_distributions()>.
	 * 	$etag - _string_ (Required) The `ETag` header value retrieved from <get_distribution_config()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	Streaming - _boolean_ (Optional) Whether or not this should be for a streaming distribution. A value of `true` will create a streaming distribution. A value of `false` will create a standard distribution. Defaults to `false`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [DELETE Distribution](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/DeleteDistribution.html)
	 * 	- [DELETE Streaming Distribution](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/DeleteStreamingDistribution.html)
	 */
	public function delete_distribution($distribution_id, $etag, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/' . ((isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'streaming-distribution' : 'distribution');
		$path .= '/' . $distribution_id;

		return $this->authenticate('DELETE', $path, $opt, null, $etag);
	}

	/**
	 * Method: get_distribution_config()
	 * 	Gets the current distribution configuration for the specified distribution ID.
	 *
	 * 	Standard distributions are handled separately from streaming distributions. For streaming
	 * 	distributions, set the `Streaming` option to true.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_id - _string_ (Required) The distribution ID returned from <create_distribution()> or <list_distributions()>.
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	Streaming - _boolean_ (Optional) Whether or not this should be for a streaming distribution. A value of `true` will create a streaming distribution. A value of `false` will create a standard distribution. Defaults to `false`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Distribution Config](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/GetConfig.html)
	 * 	- [GET Streaming Distribution Config](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/GetStreamingDistConfig.html)
	 */
	public function get_distribution_config($distribution_id, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/' . ((isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'streaming-distribution' : 'distribution');
		$path .= '/' . $distribution_id . '/config';

		return $this->authenticate('GET', $path, $opt, null, null);
	}

	/**
	 * Method: set_distribution_config()
	 * 	Sets a new distribution configuration for the specified distribution ID.
	 *
	 * 	Standard distributions are handled separately from streaming distributions. For streaming
	 * 	distributions, set the `Streaming` option to true.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_id - _string_ (Required) The distribution ID returned from <create_distribution()> or <list_distributions()>.
	 * 	$xml - _string_ (Required) The DistributionConfig XML generated by <generate_config_xml()> or <update_config_xml()>.
	 * 	$etag - _string_ (Required) The ETag header value retrieved from <get_distribution_config()>.
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	Streaming - _boolean_ (Optional) Whether or not this should be for a streaming distribution. A value of `true` will create a streaming distribution. A value of `false` will create a standard distribution. Defaults to `false`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [PUT Distribution Config](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/PutConfig.html)
	 * 	- [PUT Streaming Distribution Config](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/PutStreamingDistConfig.html)
	 */
	public function set_distribution_config($distribution_id, $xml, $etag, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/' . ((isset($opt['Streaming']) && $opt['Streaming'] == (bool) true) ? 'streaming-distribution' : 'distribution');
		$path .= '/' . $distribution_id . '/config';

		return $this->authenticate('PUT', $path, $opt, $xml, $etag);
	}


	/*%******************************************************************************************%*/
	// Origin Access Identity

	/**
	 * Method: create_oai()
	 * 	Creates a new Amazon CloudFront origin access identity (OAI). You can create up to 100 OAIs per AWS
	 * 	account. For more information, see the Amazon CloudFront Developer Guide.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$caller_reference - _string_ (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	Comment - _string_ (Optional) A comment about the OAI.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [POST Origin Access Identity](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/CreateOAI.html)
	 */
	public function create_oai($caller_reference, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/origin-access-identity/cloudfront';
		$xml = $this->generate_oai_xml($caller_reference, $opt);

		return $this->authenticate('POST', $path, $opt, $xml, null);
	}

	/**
	 * Method: list_oais()
	 * 	Gets a list of origin access identity (OAI) summaries. By default, the list is returned as one result.
	 * 	If needed, paginate the list by specifying values for the `MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	Marker - _string_ (Optional) Use this when paginating results to indicate where in your list of distributions to begin. The results include distributions in the list that occur after the marker. To get the next page of results, set the Marker to the value of the NextMarker from the current page's response (which is also the ID of the last distribution on that page).
	 * 	MaxItems - _integer_ (Optional) The maximum number of distributions you want in the response body. Maximum of 100.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Origin Access Identity List](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/ListOAIs.html)
	 */
	public function list_oais($opt = null)
	{
		if (!$opt) $opt = array();
		$opt['query_string'] = array();

		// Pass these to the query string
		foreach (array('Marker', 'MaxItems') as $option)
		{
			if (isset($opt[$option]))
			{
				$opt['query_string'][$option] = $opt[$option];
			}
		}

		$path = '/origin-access-identity/cloudfront';

		return $this->authenticate('GET', $path, $opt, null, null);
	}

	/**
	 * Method: get_oai()
	 * 	Gets information about an origin access identity (OAI).
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$identity_id - _string_ (Required) The Identity ID for an existing OAI.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Origin Access Identity](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/GetOAI.html)
	 */
	public function get_oai($identity_id, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/origin-access-identity/cloudfront/' . $identity_id;

		return $this->authenticate('GET', $path, $opt, null, null);
	}

	/**
	 * Method: delete_oai()
	 * 	Deletes an Amazon CloudFront origin access identity (OAI). To delete an OAI, the identity must first
	 * 	be disassociated from all distributions (by updating each distribution's configuration to omit the
	 * 	`OriginAccessIdentity` element). Wait until each distribution's state is `Deployed` before deleting
	 * 	the OAI.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$identity_id - _string_ (Required) An Identity ID for an existing OAI.
	 * 	$etag - _string_ (Required) The `ETag` header value retrieved from a call to <get_oai()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [DELETE Origin Access Identity](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/DeleteOAI.html)
	 */
	public function delete_oai($identity_id, $etag, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/origin-access-identity/cloudfront/' . $identity_id;

		return $this->authenticate('DELETE', $path, $opt, null, $etag);
	}

	/**
	 * Method: get_oai_config()
	 * 	Gets the configuration of the origin access identity (OAI) for the specified identity ID.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$identity_id - _string_ (Required) An Identity ID for an existing OAI.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Origin Access Identity Config](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/GetOAIConfig.html)
	 */
	public function get_oai_config($identity_id, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/origin-access-identity/cloudfront/' . $identity_id . '/config';

		return $this->authenticate('GET', $path, $opt, null, null);
	}

	/**
	 * Method: set_oai_config()
	 * 	Sets the configuration for an Amazon CloudFront origin access identity (OAI). Use this when updating
	 * 	the configuration. Currently, only comments may be updated.  Follow the same process as when updating
	 * 	an identity's configuration as you do when updating a distribution's configuration. For more
	 * 	information, go to Updating a Distribution's Configuration in the Amazon CloudFront Developer Guide.
	 *
	 * 	When attempting to change configuration items that are not allowed to be updated, Amazon CloudFront
	 * 	returns an `IllegalUpdate` error.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$identity_id - _string_ (Required) An Identity ID for an existing OAI.
	 * 	$xml - _string_ (Required) The configuration XML generated by <generate_oai_xml()>.
	 * 	$etag - _string_ (Required) The ETag header value retrieved from a call to <get_distribution_config()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [PUT Origin Access Identity Config](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/PutOAIConfig.html)
	 */
	public function set_oai_config($identity_id, $xml, $etag, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/origin-access-identity/cloudfront/' . $identity_id . '/config';

		return $this->authenticate('PUT', $path, $opt, $xml, $etag);
	}


	/*%******************************************************************************************%*/
	// INVALIDATION

	/**
	 * Method: create_invalidation()
	 * 	Creates a new invalidation request.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_id - _string_ (Required) The distribution ID returned from <create_distribution()> or <list_distributions()>.
	 * 	$caller_reference - _string_ (Required) A unique identifier for the request. A timestamp-appended string is recommended.
	 * 	$paths - _string_|_array_ (Required) One or more paths to set for invalidation. Pass a string for a single value, or an indexed array for multiple values. values.
	 * 	$opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [POST Invalidation](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/CreateInvalidation.html)
	 */
	public function create_invalidation($distribution_id, $caller_reference, $paths, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Paths'] = $paths;

		$path = '/distribution/' . $distribution_id . '/invalidation';
		$xml = $this->generate_invalidation_xml($caller_reference, $opt);

		return $this->authenticate('POST', $path, $opt, $xml, null);
	}

	/**
	 * Method: list_invalidations()
	 * 	Gets a list of invalidations. By default, the list is returned as one result. If needed, paginate the
	 * 	list by specifying values for the `MaxItems` and `Marker` parameters.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_id - _string_ (Required) The distribution ID returned from <create_distribution()> or <list_distributions()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	Marker - _string_ (Optional) Use this when paginating results to indicate where in the list of invalidations to begin. The results include invalidations in the list that occur after the marker. To get the next page of results, set the `Marker` parameter to the value of the `NextMarker` parameter from the current page's response, which is also the ID of the last invalidation on that page.
	 * 	MaxItems - _integer_ (Optional) The maximum number of invalidations you want in the response body. A maximum value of 100 can be used.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Invalidation List](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/ListInvalidation.html)
	 */
	public function list_invalidations($distribution_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['query_string'] = array();

		// Pass these to the query string
		foreach (array('Marker', 'MaxItems') as $option)
		{
			if (isset($opt[$option]))
			{
				$opt['query_string'][$option] = $opt[$option];
			}
		}

		$path = '/distribution/' . $distribution_id . '/invalidation';

		return $this->authenticate('GET', $path, $opt, null, null);
	}

	/**
	 * Method: get_invalidation()
	 * 	Gets information about an invalidation.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_id - _string_ (Required) The distribution ID returned from <create_distribution()> or <list_distributions()>.
	 * 	$invalidation_id - _string_ (Required) The invalidation ID returned from <create_invalidation()> or <list_invalidations()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [GET Invalidation](http://docs.amazonwebservices.com/AmazonCloudFront/latest/APIReference/GetInvalidation.html)
	 */
	public function get_invalidation($distribution_id, $invalidation_id, $opt = null)
	{
		if (!$opt) $opt = array();

		$path = '/distribution/' . $distribution_id . '/invalidation/' . $invalidation_id;

		return $this->authenticate('GET', $path, $opt, null, null);
	}


	/*%******************************************************************************************%*/
	// CONVENIENCE METHODS

	/**
	 * Method: get_distribution_list()
	 * 	Gets a simplified list of standard distribution IDs.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the distribution caller references against.
	 *
	 * Returns:
	 * 	_array_ A list of standard distribution IDs.
	 */
	public function get_distribution_list($pcre = null)
	{
		if ($this->use_batch_flow)
		{
			throw new CloudFront_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$list = $this->list_distributions();
		if ($list = $list->body->Id())
		{
			$list = $list->map_string($pcre);
			return $list;
		}

		return array();
	}

	/**
	 * Method: get_streaming_distribution_list()
	 * 	Gets a simplified list of streaming distribution IDs.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the distribution caller references against.
	 *
	 * Returns:
	 * 	_array_ A list of streaming distribution IDs.
	 */
	public function get_streaming_distribution_list($pcre = null)
	{
		if ($this->use_batch_flow)
		{
			throw new CloudFront_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$list = $this->list_distributions(array(
			'Streaming' => true
		));
		if ($list = $list->body->Id())
		{
			$list = $list->map_string($pcre);
			return $list;
		}

		return array();
	}

	/**
	 * Method: get_oai_list()
	 * 	Gets a simplified list of origin access identity (OAI) IDs.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the OAI caller references against.
	 *
	 * Returns:
	 * 	_array_ A list of OAI IDs.
	 */
	public function get_oai_list($pcre = null)
	{
		if ($this->use_batch_flow)
		{
			throw new CloudFront_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$list = $this->list_oais();
		if ($list = $list->body->Id())
		{
			$list = $list->map_string($pcre);
			return $list;
		}

		return array();
	}


	/*%******************************************************************************************%*/
	// URLS

	/**
	 * Method: get_private_object_url()
	 * 	Generates a time-limited and/or query signed request for a private file with additional optional
	 * 	restrictions.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$distribution_hostname - _string_ (Required) The hostname of the distribution. Obtained from <create_distribution()> or <get_distribution_info()>.
	 *	$filename - _string_ (Required) The file name of the object. Query parameters can be included. You can use multicharacter match wild cards () or a single-character match wild card (?) anywhere in the string.
	 * 	$expires - _integer_|_string_ (Required) The expiration time expressed either as a number of seconds since UNIX Epoch, or any string that `strtotime()` can understand.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	BecomeAvailable - _integer_|_string_ (Optional) The time when the private URL becomes active. Can be expressed either as a number of seconds since UNIX Epoch, or any string that `strtotime()` can understand.
	 *	IPAddress - _string_ (Optional) A single IP address to restrict the access to.
	 * 	Secure - _boolean_ (Optional) Whether or not to use HTTPS as the protocol scheme. A value of `true` uses `https`. A value of `false` uses `http`. Defaults to `false`.
	 *
	 * Returns:
	 * 	_string_ The file URL with authentication parameters.
	 *
	 * See Also:
	 * 	[Serving Private Content](http://docs.amazonwebservices.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html)
	 */
	public function get_private_object_url($distribution_hostname, $filename, $expires, $opt = null)
	{
		if (!$this->key_pair_id || !$this->private_key)
		{
			throw new CloudFront_Exception('You must set both a Amazon CloudFront keypair ID and an RSA private key for that keypair before using ' . __FUNCTION__ . '()');
		}
		if (!function_exists('openssl_sign'))
		{
			throw new CloudFront_Exception(__FUNCTION__ . '() uses functions from the OpenSSL PHP Extension <http://php.net/openssl>, which is not installed in this PHP installation');
		}

		if (!$opt) $opt = array();

		$resource = '';
		$expiration_key = 'Expires';
		$expires = strtotime($expires);
		$conjunction = (strpos($filename, '?') === false ? '?' : '&');

		// Determine the protocol scheme
		switch (substr($distribution_hostname, 0, 1) === 's')
		{
			// Streaming
			case 's':
				$scheme = 'rtmp';
				$resource = str_replace(array('%3F', '%3D', '%26', '%2F'), array('?', '=', '&', '/'), rawurlencode($filename));
				break;

			// Default
			case 'd':
			default:
				$scheme = 'http';
				$scheme .= (isset($opt['Secure']) && $opt['Secure'] === true ? 's' : '');
				$resource = $scheme . '://' . $distribution_hostname . '/' . str_replace(array('%3F', '%3D', '%26', '%2F'), array('?', '=', '&', '/'), rawurlencode($filename));
				break;
		}

		// Generate default policy
		$raw_policy = array(
			'Statement' => array(
				array(
					'Resource' => $resource,
					'Condition' => array(
						'DateLessThan' => array(
							'AWS:EpochTime' => $expires
						)
					)
				)
			)
		);

		// Become Available
		if (isset($opt['BecomeAvailable']))
		{
			// Switch to 'Policy' instead
			$expiration_key = 'Policy';

			// Update the policy
			$raw_policy['Statement'][0]['Condition']['DateGreaterThan'] = array(
				'AWS:EpochTime' => strtotime($opt['BecomeAvailable'])
			);
		}

		// IP Address
		if (isset($opt['IPAddress']))
		{
			// Switch to 'Policy' instead
			$expiration_key = 'Policy';

			// Update the policy
			$raw_policy['Statement'][0]['Condition']['IpAddress'] = array(
				'AWS:SourceIp' => $opt['IPAddress']
			);
		}

		// Munge the policy
		$json_policy = str_replace('\/', '/', json_encode($raw_policy));
		$json_policy = $this->util->decode_uhex($json_policy);
		$encoded_policy = strtr(base64_encode($json_policy), '+=/', '-_~');

		// Generate the signature
		openssl_sign($json_policy, $signature, $this->private_key);
		$signature = strtr(base64_encode($signature), '+=/', '-_~');

		return $scheme . '://' . $distribution_hostname . '/'
			. str_replace(array('%3F', '%3D', '%26', '%2F'), array('?', '=', '&', '/'), rawurlencode($filename))
			. $conjunction
			. ($expiration_key === 'Expires' ? ($expiration_key . '=' . $expires) : ($expiration_key . '=' . $encoded_policy))
			. '&Key-Pair-Id=' . $this->key_pair_id
			. '&Signature=' . $signature;
	}
}

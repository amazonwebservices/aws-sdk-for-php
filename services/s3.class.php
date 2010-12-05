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
 * File: AmazonS3
 * 	Amazon S3 is a web service that enables you to store data in the cloud. You can then download the data
 * 	or use the data with other AWS services, such as Amazon Elastic Cloud Computer (EC2).
 *
 * 	Amazon Simple Storage Service (Amazon S3) is storage for the Internet. You can use Amazon S3 to store
 * 	and retrieve any amount of data at any time, from anywhere on the web. You can accomplish these tasks
 * 	using the AWS Management Console, which is a simple and intuitive web interface.
 *
 * 	To get the most out of Amazon S3, you need to understand a few simple concepts. Amazon S3 stores data
 * 	as objects in buckets. An object is comprised of a file and optionally any metadata that describes
 * 	that file.
 *
 * 	To store an object in Amazon S3, you upload the file you want to store to a bucket. When you upload a
 * 	file, you can set permissions on the object as well as any metadata.
 *
 * 	Buckets are the containers for objects. You can have one or more buckets. For each bucket, you can control
 * 	access to the bucket (who can create, delete, and list objects in the bucket), view access logs for the
 * 	bucket and its objects, and choose the geographical region where Amazon S3 will store the bucket and its
 * 	contents.
 *
 * 	Visit <http://aws.amazon.com/s3/> for more information.
 *
 * Version:
 * 	2010.12.02
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[Amazon Simple Storage Service](http://aws.amazon.com/s3/)
 * 	[Amazon Simple Storage Service documentation](http://aws.amazon.com/documentation/s3/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: S3_Exception
 * 	Default S3 Exception.
 */
class S3_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonS3
 * 	Container for all Amazon S3-related methods. Inherits additional methods from CFRuntime.
 */
class AmazonS3 extends CFRuntime
{
	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	The default endpoint.
	 */
	const DEFAULT_URL = 's3.amazonaws.com';

	/**
	 * Constant: REGION_US_E1
	 * 	Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = '';

	/**
	 * Constant: REGION_US_W1
	 * 	Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'us-west-1';

	/**
	 * Constant: REGION_EU_W1
	 * 	Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'EU';

	/**
	 * Constant: REGION_APAC_SE1
	 * 	Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'ap-southeast-1';

	/**
	 * Constant: ACL_PRIVATE
	 * 	ACL: Owner-only read/write.
	 */
	const ACL_PRIVATE = 'private';

	/**
	 * Constant: ACL_PUBLIC
	 * 	ACL: Owner read/write, public read.
	 */
	const ACL_PUBLIC = 'public-read';

	/**
	 * Constant: ACL_OPEN
	 * 	ACL: Public read/write.
	 */
	const ACL_OPEN = 'public-read-write';

	/**
	 * Constant: ACL_AUTH_READ
	 * 	ACL: Owner read/write, authenticated read.
	 */
	const ACL_AUTH_READ = 'authenticated-read';

	/**
	 * Constant: ACL_OWNER_READ
	 * 	ACL: Bucket owner read.
	 */
	const ACL_OWNER_READ = 'bucket-owner-read';

	/**
	 * Constant: ACL_OWNER_FULL_CONTROL
	 * 	ACL: Bucket owner full control.
	 */
	const ACL_OWNER_FULL_CONTROL = 'bucket-owner-full-control';

	/**
	 * Constant: GRANT_READ
	 * 	When applied to a bucket, grants permission to list the bucket. When applied to an object, this
	 * 	grants permission to read the object data and/or metadata.
	 */
	const GRANT_READ = 'READ';

	/**
	 * Constant: GRANT_WRITE
	 * 	When applied to a bucket, grants permission to create, overwrite, and delete any object in the
	 * 	bucket. This permission is not supported for objects.
	 */
	const GRANT_WRITE = 'WRITE';

	/**
	 * Constant: GRANT_READ_ACP
	 * 	Grants permission to read the ACL for the applicable bucket or object. The owner of a bucket or
	 * 	object always has this permission implicitly.
	 */
	const GRANT_READ_ACP = 'READ_ACP';

	/**
	 * Constant: GRANT_WRITE_ACP
	 * 	Gives permission to overwrite the ACP for the applicable bucket or object. The owner of a bucket
	 * 	or object always has this permission implicitly. Granting this permission is equivalent to granting
	 * 	FULL_CONTROL because the grant recipient can make any changes to the ACP.
	 */
	const GRANT_WRITE_ACP = 'WRITE_ACP';

	/**
	 * Constant: GRANT_FULL_CONTROL
	 * 	Provides READ, WRITE, READ_ACP, and WRITE_ACP permissions. It does not convey additional rights and
	 * 	is provided only for convenience.
	 */
	const GRANT_FULL_CONTROL = 'FULL_CONTROL';

	/**
	 * Constant: USERS_AUTH
	 * 	The "AuthenticatedUsers" group for access control policies.
	 */
	const USERS_AUTH = 'http://acs.amazonaws.com/groups/global/AuthenticatedUsers';

	/**
	 * Constant: USERS_ALL
	 * 	The "AllUsers" group for access control policies.
	 */
	const USERS_ALL = 'http://acs.amazonaws.com/groups/global/AllUsers';

	/**
	 * Constant: USERS_LOGGING
	 * 	The "LogDelivery" group for access control policies.
	 */
	const USERS_LOGGING = 'http://acs.amazonaws.com/groups/s3/LogDelivery';

	/**
	 * Constant: PCRE_ALL
	 * 	PCRE: Match all items
	 */
	const PCRE_ALL = '/.*/i';

	/**
	 * Constant: STORAGE_STANDARD
	 * 	Standard storage redundancy.
	 */
	const STORAGE_STANDARD = 'STANDARD';

	/**
	 * Constant: STORAGE_REDUCED
	 * 	Reduced storage redundancy.
	 */
	const STORAGE_REDUCED = 'REDUCED_REDUNDANCY';


	/*%******************************************************************************************%*/
	// PROPERTIES

	/**
	 * Property: request_url
	 * 	The request URL.
	 */
	public $request_url;

	/**
	 * Property: vhost
	 * 	The virtual host setting.
	 */
	public $vhost;

	/**
	 * Property: base_acp_xml
	 * 	The base XML elements to use for access control policy methods.
	 */
	public $base_acp_xml;

	/**
	 * Property: base_logging_xml
	 * 	The base XML elements to use for logging methods.
	 */
	public $base_logging_xml;

	/**
	 * Property: base_notification_xml
	 * 	The base XML elements to use for notifications.
	 */
	public $base_notification_xml;

	/**
	 * Property: base_versioning_xml
	 * 	The base XML elements to use for versioning.
	 */
	public $base_versioning_xml;

	/**
	 * Property: complete_mpu_xml
	 * 	The base XML elements to use for completing a multipart upload.
	 */
	public $complete_mpu_xml;

	/**
	 * Property: path_style
	 * 	The DNS vs. Path-style setting.
	 */
	public $path_style = false;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonS3>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$key - _string_ (Optional) Amazon API Key. If blank, the <AWS_KEY> constant is used.
	 * 	$secret_key - _string_ (Optional) Amazon API Secret Key. If blank, the <AWS_SECRET_KEY> constant is used.
	 *
	 * Returns:
	 * 	_boolean_ A value of `false` if no valid values are set, otherwise `true`.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->vhost = null;
		$this->api_version = '2006-03-01';
		$this->hostname = self::DEFAULT_URL;

		$this->base_acp_xml = '<?xml version="1.0" encoding="UTF-8"?><AccessControlPolicy xmlns="http://s3.amazonaws.com/doc/latest/"></AccessControlPolicy>';
		$this->base_location_constraint = '<?xml version="1.0" encoding="UTF-8"?><CreateBucketConfiguration xmlns="http://s3.amazonaws.com/doc/2006-03-01/"><LocationConstraint></LocationConstraint></CreateBucketConfiguration>';
		$this->base_logging_xml = '<?xml version="1.0" encoding="utf-8"?><BucketLoggingStatus xmlns="http://doc.s3.amazonaws.com/' . $this->api_version . '"></BucketLoggingStatus>';
		$this->base_notification_xml = '<?xml version="1.0" encoding="utf-8"?><NotificationConfiguration></NotificationConfiguration>';
		$this->base_versioning_xml = '<?xml version="1.0" encoding="utf-8"?><VersioningConfiguration xmlns="http://s3.amazonaws.com/doc/2006-03-01/"></VersioningConfiguration>';
		$this->complete_mpu_xml = '<?xml version="1.0" encoding="utf-8"?><CompleteMultipartUpload></CompleteMultipartUpload>';

		if (!$key && !defined('AWS_KEY'))
		{
			throw new S3_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new S3_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// AUTHENTICATION

	/**
	 * Method: authenticate()
	 * 	Authenticates a connection to Amazon S3. Do not use directly unless implementing custom methods for
	 * 	this class.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * 	$location - _string_ (Do Not Use) Used internally by this function on occasions when Amazon S3 returns a redirect code and it needs to call itself recursively.
	 * 	$redirects - _integer_ (Do Not Use) Used internally by this function on occasions when Amazon S3 returns a redirect code and it needs to call itself recursively.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST authentication](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAuthentication.html)
	 */
	public function authenticate($bucket, $opt = null, $location = null, $redirects = 0, $nothing = null)
	{
		/*
		 * Overriding or extending this class? You can pass the following "magic" keys into $opt.
		 *
		 * ## verb, resource, sub_resource and query_string ##
		 * 	<verb> /<resource>?<sub_resource>&<query_string>
		 * 	GET /filename.txt?versions&prefix=abc&max-items=1
		 *
		 * ## versionId, uploadId, partNumber ##
		 * 	These don't follow the same rules as above, in that the they needs to be signed, while
		 * 	other query_string values do not.
		 *
		 * ## curlopts ##
		 * 	These values get passed directly to the cURL methods in RequestCore.
		 *
		 * ## fileUpload, fileDownload, seekTo, length ##
		 * 	These are slightly modified and then passed to the cURL methods in RequestCore.
		 *
		 * ## headers ##
		 * 	$opt['headers'] is an array, whose keys are HTTP headers to be sent.
		 *
		 * ## body ##
		 * 	This is the request body that is sent to the server via PUT/POST.
		 *
		 * ## preauth ##
		 * 	This is a hook that tells authenticate() to generate a pre-authenticated URL.
		 *
		 * ## returnCurlHandle ##
		 * 	Tells authenticate() to return the cURL handle for the request instead of executing it.
		 */

		/**
		 * @todo: Handle duplicate headers with different values.
		 */

		// Validate the S3 bucket name
		if (!$this->validate_bucketname_support($bucket))
		{
			throw new S3_Exception('S3 does not support "' . $bucket . '" as a valid bucket name. Review "Bucket Restrictions and Limitations" in the S3 Developer Guide for more information.');
		}

		// Die if $opt isn't set.
		if (!$opt) return false;

		$method_arguments = func_get_args();

		// Use the caching flow to determine if we need to do a round-trip to the server.
		if ($this->use_cache_flow)
		{
			// Generate an identifier specific to this particular set of arguments.
			$cache_id = $this->key . '_' . get_class($this) . '_' . $bucket . '_' . sha1(serialize($method_arguments));

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

		// If we haven't already set a resource prefix...
		if (!$this->resource_prefix || $this->path_style)
		{
			// And if the bucket name isn't DNS-valid...
			if (!$this->validate_bucketname_create($bucket) || $this->path_style)
			{
				// Fall back to the older path-style URI
				$this->set_resource_prefix('/' . $bucket);
			}
		}

		// Determine hostname
		$scheme = $this->use_ssl ? 'https://' : 'http://';
		if ($this->resource_prefix || $this->path_style) // Use bucket-in-path method.
		{
			$hostname = $this->hostname . $this->resource_prefix . (($bucket === '' || $this->resource_prefix === '/' . $bucket) ? '' : ('/' . $bucket));
		}
		else
		{
			$hostname = $this->vhost ? $this->vhost : (($bucket === '') ? $this->hostname : ($bucket . '.') . $this->hostname);
		}

		// Get the UTC timestamp in RFC 2616 format
		$date = gmdate($this->util->konst($this->util, 'DATE_FORMAT_RFC2616'), (time() + (integer) $this->adjust_offset));

		// Storage for request parameters.
		$resource = '';
		$sub_resource = '';
		$query_string_params = array();
		$signable_query_string_params = array();
		$string_to_sign = '';
		$headers = array(
			'Content-MD5' => '',
			'Content-Type' => 'application/x-www-form-urlencoded',
			'Date' => $date
		);

		/*%******************************************************************************************%*/

		// Handle specific resources
		if (isset($opt['resource']))
		{
			$resource .= $opt['resource'];
		}

		// Merge query string values
		if (isset($opt['query_string']))
		{
			$query_string_params = array_merge($query_string_params, $opt['query_string']);
		}
		$query_string = $this->util->to_query_string($query_string_params);

		// Merge the signable query string values. Must be alphabetical.
		if (isset($opt['partNumber']))
		{
			$signable_query_string_params['partNumber'] = rawurlencode($opt['partNumber']);
		}
		if (isset($opt['uploadId']))
		{
			$signable_query_string_params['uploadId'] = rawurlencode($opt['uploadId']);
		}
		if (isset($opt['versionId']))
		{
			$signable_query_string_params['versionId'] = rawurlencode($opt['versionId']);
		}
		// ksort($signable_query_string_params);
		$signable_query_string = $this->util->to_query_string($signable_query_string_params);

		// Merge the HTTP headers
		if (isset($opt['headers']))
		{
			$headers = array_merge($headers, $opt['headers']);
		}

		// Compile the URI to request
		$conjunction = '?';
		$signable_resource = '/' . rawurlencode($resource);
		$non_signable_resource = '';

		if (isset($opt['sub_resource']))
		{
			$signable_resource .= $conjunction . rawurlencode($opt['sub_resource']);
			$conjunction = '&';
		}
		if ($signable_query_string !== '')
		{
			$signable_resource .= $conjunction . $signable_query_string;
			$conjunction = '&';
		}
		if ($query_string !== '')
		{
			$non_signable_resource .= $conjunction . $query_string;
			$conjunction = '&';
		}
		$this->request_url = $scheme . $hostname . $signable_resource . $non_signable_resource;

		// Instantiate the request class
		$request = new $this->request_class($this->request_url, $this->proxy);

		// Update RequestCore settings
		$request->request_class = $this->request_class;
		$request->response_class = $this->response_class;

		// Streaming uploads
		if (isset($opt['fileUpload']))
		{
			if (is_resource($opt['fileUpload']))
			{
				$request->set_read_stream($opt['fileUpload'], isset($opt['length']) ? $opt['length'] : -1);

				if ($headers['Content-Type'] === 'application/x-www-form-urlencoded')
				{
					$headers['Content-Type'] = 'application/octet-stream';
				}
			}
			else
			{
				$request->set_read_file($opt['fileUpload']);

				// Attempt to guess the correct mime-type
				if ($headers['Content-Type'] === 'application/x-www-form-urlencoded')
				{
					$extension = explode('.', $opt['fileUpload']);
					$extension = array_pop($extension);
					$mime_type = CFMimeTypes::get_mimetype($extension);
					$headers['Content-Type'] = $mime_type;
				}
			}

			$headers['Content-Length'] = $request->read_stream_size;
			$curlopts[CURLOPT_INFILESIZE] = $headers['Content-Length'];
			$headers['Content-MD5'] = '';
		}

		// Streaming downloads
		if (isset($opt['fileDownload']))
		{
			if (is_resource($opt['fileDownload']))
			{
				$request->set_write_stream($opt['fileDownload']);
			}
			else
			{
				$request->set_write_file($opt['fileDownload']);
			}
		}

		$curlopts = array();

		// Set custom CURLOPT settings
		if (isset($opt['curlopts']))
		{
			$curlopts = $opt['curlopts'];
			unset($opt['curlopts']);
		}

		// Debug mode
		if ($this->debug_mode)
		{
			$curlopts[CURLOPT_VERBOSE] = true;
		}

		// Handle streaming file offsets
		if (isset($opt['seekTo']))
		{
			// Pass the seek position to RequestCore
			$request->set_seek_position((integer) $opt['seekTo']);

			$headers['Content-Length'] = (!is_resource($opt['fileUpload']) ? (filesize($opt['fileUpload']) - (integer) $opt['seekTo']) : -1);
			$curlopts[CURLOPT_INFILESIZE] = $headers['Content-Length'];
		}

		// Override the content length
		if (isset($opt['length']))
		{
			$headers['Content-Length'] = (integer) $opt['length'];
			$curlopts[CURLOPT_INFILESIZE] = $headers['Content-Length'];
		}

		// Set the curl options.
		if (count($curlopts))
		{
			$request->set_curlopts($curlopts);
		}

		// Do we have a verb?
		if (isset($opt['verb']))
		{
			$request->set_method($opt['verb']);
			$string_to_sign .= $opt['verb'] . "\n";
		}

		// Add headers and content when we have a body
		if (isset($opt['body']))
		{
			$request->set_body($opt['body']);
			$headers['Content-Length'] = strlen($opt['body']);

			if ($headers['Content-Type'] === 'application/x-www-form-urlencoded')
			{
				$headers['Content-Type'] = 'application/octet-stream';
			}

			if (!isset($opt['NoContentMD5']) || $opt['NoContentMD5'] !== true)
			{
				$headers['Content-MD5'] = $this->util->hex_to_base64(md5($opt['body']));
			}
		}

		// Handle query-string authentication
		if (isset($opt['preauth']) && (integer) $opt['preauth'] > 0)
		{
			unset($headers['Date']);
			$headers['Content-Type'] = '';
			$headers['Expires'] = strtotime($opt['preauth']);
		}

		// Sort headers
		uksort($headers, 'strnatcasecmp');

		// Add headers to request and compute the string to sign
		foreach ($headers as $header_key => $header_value)
		{
			// Strip linebreaks from header values as they're illegal and can allow for security issues
			$header_value = str_replace(array("\r", "\n"), '', $header_value);

			// Add the header if it has a value
			if ($header_value !== '')
			{
				$request->add_header($header_key, $header_value);
			}

			// Generate the string to sign
			if (
				strtolower($header_key) === 'content-md5' ||
				strtolower($header_key) === 'content-type' ||
				strtolower($header_key) === 'date' ||
				(strtolower($header_key) === 'expires' && isset($opt['preauth']) && (integer) $opt['preauth'] > 0)
			)
			{
				$string_to_sign .= $header_value . "\n";
			}
			elseif (substr(strtolower($header_key), 0, 6) === 'x-amz-')
			{
				$string_to_sign .= strtolower($header_key) . ':' . $header_value . "\n";
			}
		}

		// Add the signable resource location
		$string_to_sign .= ($this->resource_prefix ? $this->resource_prefix : '');
		$string_to_sign .= (($bucket === '' || $this->resource_prefix === '/' . $bucket) ? '' : ('/' . $bucket)) . $signable_resource;

		// Hash the AWS secret key and generate a signature for the request.
		$signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->secret_key, true));
		$request->add_header('Authorization', 'AWS ' . $this->key . ':' . $signature);

		// If we're generating a URL, return certain data to the calling method.
		if (isset($opt['preauth']) && (integer) $opt['preauth'] > 0)
		{
			return $this->request_url . (isset($opt['sub_resource']) ? '&' : '?') . 'AWSAccessKeyId=' . $this->key . '&Expires=' . $headers['Expires'] . '&Signature=' . rawurlencode($signature);
		}
		elseif (isset($opt['preauth']))
		{
			return $this->request_url;
		}

		/*%******************************************************************************************%*/

		// Manage the (newer) batch request API or the (older) returnCurlHandle setting.
		if ($this->use_batch_flow)
		{
			$handle = $request->prep_request();
			$this->batch_object->add($handle);
			$this->use_batch_flow = false;

			return $handle;
		}
		elseif (isset($opt['returnCurlHandle']) && $opt['returnCurlHandle'] === true)
		{
			return $request->prep_request();
		}

		// Send!
		$request->send_request();

		// Prepare the response
		$headers = $request->get_response_header();
		$headers['x-aws-request-url'] = $this->request_url;
		$headers['x-aws-redirects'] = $redirects;
		$headers['x-aws-stringtosign'] = $string_to_sign;
		$headers['x-aws-requestheaders'] = $request->request_headers;

		// Did we have a request body?
		if (isset($opt['body']))
		{
			$headers['x-aws-requestbody'] = $opt['body'];
		}

		$data = new $this->response_class($headers, $this->parse_callback($request->get_response_body()), $request->get_response_code());

		// Did Amazon tell us to redirect? Typically happens for multiple rapid requests EU datacenters.
		// @see: http://docs.amazonwebservices.com/AmazonS3/latest/Redirects.html
		if ((integer) $request->get_response_code() === 307) // Temporary redirect to new endpoint.
		{
			$data = $this->authenticate($bucket, $opt, $headers['location'], ++$redirects);
		}

		// Was it Amazon's fault the request failed? Retry the request until we reach $max_retries.
		elseif ((integer) $request->get_response_code() === 500 || (integer) $request->get_response_code() === 503)
		{
			if ($redirects <= $this->max_retries)
			{
				// Exponential backoff
				$delay = (integer) (pow(4, $redirects) * 100000);
				usleep($delay);
				$data = $this->authenticate($bucket, $opt, null, ++$redirects);
			}
		}

		// Return!
		return $data;
	}

	/**
	 * Method: validate_bucketname_create()
	 * 	Validates whether or not the specified Amazon S3 bucket name is valid for DNS-style access. This
	 * 	method is leveraged by any method that creates buckets.
	 *
	 * Access:
	 * 	public
 	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to validate.
	 *
	 * Returns:
	 * 	_boolean_ Whether or not the specified Amazon S3 bucket name is valid for DNS-style access. A value of `true` means that the bucket name is valid. A value of `false` means that the bucket name is invalid.
	 */
	public function validate_bucketname_create($bucket)
	{
		// list_buckets() uses this. Let it pass.
		if ($bucket === '') return true;

		if (
			($bucket === null || $bucket === false) ||                  // Must not be null or false
			preg_match('/[^(a-z0-9\-\.)]/', $bucket) ||                 // Must be in the lowercase Roman alphabet, period or hyphen
			!preg_match('/^([a-z]|\d)/', $bucket) ||                    // Must start with a number or letter
			!(strlen($bucket) >= 3 && strlen($bucket) <= 63) ||         // Must be between 3 and 63 characters long
			(strpos($bucket, '..') !== false) ||                        // Bucket names cannot contain two, adjacent periods
			(strpos($bucket, '-.') !== false) ||                        // Bucket names cannot contain dashes next to periods
			(strpos($bucket, '.-') !== false) ||                        // Bucket names cannot contain dashes next to periods
			preg_match('/(-|\.)$/', $bucket) ||                         // Bucket names should not end with a dash or period
			preg_match('/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/', $bucket)    // Must not be formatted as an IP address
		) return false;

		return true;
	}

	/**
	 * Method: validate_bucketname_support()
	 * 	Validates whether or not the specified Amazon S3 bucket name is valid for path-style access. This
	 * 	method is leveraged by any method that reads from buckets.
	 *
	 * Access:
	 * 	public
 	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to validate.
	 *
	 * Returns:
	 * 	_boolean_ Whether or not the bucket name is valid. A value of `true` means that the bucket name is valid. A valuf of `false` means that the bucket name is invalid.
	 */
	public function validate_bucketname_support($bucket)
	{
		// list_buckets() uses this. Let it pass.
		if ($bucket === '') return true;

		// Validate
		if (
			($bucket === null || $bucket === false) ||                  // Must not be null or false
			preg_match('/[^(a-z0-9_\-\.)]/i', $bucket) ||               // Must be in the Roman alphabet, period, hyphen or underscore
			!preg_match('/^([a-z]|\d)/i', $bucket) ||                   // Must start with a number or letter
			!(strlen($bucket) >= 3 && strlen($bucket) <= 255) ||        // Must be between 3 and 255 characters long
			preg_match('/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/', $bucket)    // Must not be formatted as an IP address
		) return false;

		return true;
	}

	/**
	 * Method: cache_callback()
	 * 	The callback function that is executed when the cache doesn't exist or has expired. The response of
	 * 	this method is cached. Accepts identical parameters as the <authenticate()> method. Never call this
	 * 	method directly -- it is used internally by the caching system.
	 *
	 * Access:
	 * 	public
 	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * 	$location - _string_ (Optional) Used internally by this method when Amazon S3 returns a redirect code and needs to call itself recursively.
	 * 	$redirects - _integer_ (Optional) Used internally by this method when Amazon S3 returns a redirect code and needs to call itself recursively.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function cache_callback($bucket, $opt = null, $location = null, $redirects = 0)
	{
		// Disable the cache flow since it's already been handled.
		$this->use_cache_flow = false;

		// Make the request
		$response = $this->authenticate($bucket, $opt, $location, $redirects);

		if (isset($response->body) && ($response->body instanceof SimpleXMLElement))
		{
			$response->body = $response->body->asXML();
		}

		return $response;
	}


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * Method: set_region()
	 * 	Sets the region to use for subsequent Amazon S3 operations. This will also reset any prior use of
	 * 	<enable_path_style()>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$region - _string_ (Required) The region to use for subsequent Amazon S3 operations. [Allowed values: `AmazonS3::REGION_US_E1 `, `AmazonS3::REGION_US_W1`, `AmazonS3::REGION_EU_W1`, `AmazonS3::REGION_APAC_SE1`]
	 *
	 * Returns:
	 * 	`$this` A reference to the current instance.
	 */
	public function set_region($region)
	{
		switch ($region)
		{
			case self::REGION_US_W1: // Northern California
			case self::REGION_APAC_SE1: // Singapore
				$this->set_hostname('s3-' . $region . '.amazonaws.com');
				$this->enable_path_style(false);
				break;

			case self::REGION_EU_W1: // Ireland
				$this->set_hostname('s3-eu-west-1.amazonaws.com');
				$this->enable_path_style(); // Always use path-style access for EU endpoint.
				break;

			default:
				// REGION_US_E1 // Northern Virginia
				$this->set_hostname(self::DEFAULT_URL);
				$this->enable_path_style(false);
				break;
		}

		return $this;
	}

	/**
	 * Method: set_vhost()
	 * 	Sets the virtual host to use in place of the default `bucket.s3.amazonaws.com` domain.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$vhost - _string_ (Required) The virtual host to use in place of the default `bucket.s3.amazonaws.com` domain.
	 *
	 * Returns:
	 * 	`$this` A reference to the current instance.
	 *
	 * See Also:
	 * 	[Virtual Hosting of Buckets](http://docs.amazonwebservices.com/AmazonS3/latest/VirtualHosting.html)
	 */
	public function set_vhost($vhost)
	{
		$this->vhost = $vhost;
		return $this;
	}

	/**
	 * Method: enable_path_style()
	 * 	Enables the use of the older path-style URI access for all requests.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$style - _string_ (Optional) Whether or not to enable path-style URI access for all requests. The default value is `true`.
	 *
	 * Returns:
	 * 	`$this` A reference to the current instance.
	 */
	public function enable_path_style($style = true)
	{
		$this->path_style = $style;
		return $this;
	}


	/*%******************************************************************************************%*/
	// BUCKET METHODS

	/**
	 * Method: create_bucket()
	 * 	Creates an Amazon S3 bucket.
	 *
	 * 	Every object stored in Amazon S3 is contained in a bucket. Buckets partition the namespace of
	 * 	objects stored in Amazon S3 at the top level. in a bucket, any name can be used for objects.
	 * 	However, bucket names must be unique across all of Amazon S3.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to create.
	 * 	$region - _string_ (Required) The preferred geographical location for the bucket. [Allowed values: `AmazonS3::REGION_US_E1 `, `AmazonS3::REGION_US_W1`, `AmazonS3::REGION_EU_W1`, `AmazonS3::REGION_APAC_SE1`]
	 * 	$acl - _string_ (Optional) The ACL settings for the specified bucket. [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. The default value is <ACL_PRIVATE>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	* [Working with Amazon S3 Buckets](http://docs.amazonwebservices.com/AmazonS3/latest/UsingBucket.html)
	 */
	public function create_bucket($bucket, $region, $acl = self::ACL_PRIVATE, $opt = null)
	{
		// If the bucket contains uppercase letters...
		if (preg_match('/[A-Z]/', $bucket))
		{
			// Throw a warning
			trigger_error('Since DNS-valid bucket names cannot contain uppercase characters, "' . $bucket . '" has been automatically converted to "' . strtolower($bucket) . '"', E_USER_WARNING);

			// Force the bucketname to lowercase
			$bucket = strtolower($bucket);
		}

		// Validate the S3 bucket name for creation
		if (!$this->validate_bucketname_create($bucket))
		{
			throw new S3_Exception('"' . $bucket . '" is not DNS-valid (i.e., <bucketname>.s3.amazonaws.com), and cannot be used as an S3 bucket name. Review "Bucket Restrictions and Limitations" in the S3 Developer Guide for more information.');
		}

		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['headers'] = array(
			'Content-Type' => 'application/xml',
			'x-amz-acl' => $acl
		);

		// Defaults
		$this->set_region($region);
		$xml = simplexml_load_string($this->base_location_constraint);

		switch ($region)
		{
			case self::REGION_US_W1:    // Northern California
			case self::REGION_APAC_SE1: // Singapore
				$xml->LocationConstraint = $region;
				$opt['body'] = $xml->asXML();
				break;

			case self::REGION_EU_W1:    // Ireland
				$this->enable_path_style(); // DNS-style doesn't seem to work for creation, only in EU. Switch over to path-style.
				$xml->LocationConstraint = $region;
				$opt['body'] = $xml->asXML();
				break;

			default: // REGION_US_E1 // Northern Virginia
				$opt['body'] = '';
				break;
		}

		$response = $this->authenticate($bucket, $opt);

		return $response;
	}

	/**
	 * Method: get_bucket_region()
	 * 	Gets the region in which the specified Amazon S3 bucket is located.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_bucket_region($bucket, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'location';

		// Authenticate to S3
		$response = $this->authenticate($bucket, $opt);

		if ($response->isOK())
		{
			// Handle body
			$response->body = (string) $response->body;
		}

		return $response;
	}

	/**
	 * Method: get_bucket_headers()
	 * 	Gets the HTTP headers for the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_bucket_headers($bucket, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'HEAD';

		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: delete_bucket()
	 * 	Deletes a bucket from an Amazon S3 account. A bucket must be empty before the bucket itself can be
	 * 	deleted.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$force - _boolean_ (Optional) Whether to force-delete the bucket and all of its contents. The default value is `false`.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_mixed_ A <CFResponse> object if the bucket was deleted successfully. Returns _boolean_ `false` if otherwise.
	 */
	public function delete_bucket($bucket, $force = false, $opt = null)
	{
		// Set default value
		$success = true;

		if ($force)
		{
			// Delete all of the items from the bucket.
			$success = $this->delete_all_object_versions($bucket);
		}

		// As long as we were successful...
		if ($success)
		{
			if (!$opt) $opt = array();
			$opt['verb'] = 'DELETE';

			return $this->authenticate($bucket, $opt);
		}

		return false;
	}

	/**
	 * Method: list_buckets()
	 * 	Gets a list of all buckets contained in the caller's Amazon S3 account.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_buckets($opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';

		return $this->authenticate('', $opt);
	}

	/**
	 * Method: get_bucket_acl()
	 * 	Gets the access control list (ACL) settings for the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST Access Control Policy](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAccessPolicy.html)
	 */
	public function get_bucket_acl($bucket, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'acl';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: set_bucket_acl()
	 * 	Sets the access control list (ACL) settings for the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$acl - _string_ (Optional) The ACL settings for the specified bucket. [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. Alternatively, an array of associative arrays. Each associative array contains an `id` and a `permission` key. The default value is <ACL_PRIVATE>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST Access Control Policy](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAccessPolicy.html)
	 */
	public function set_bucket_acl($bucket, $acl = self::ACL_PRIVATE, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'acl';
		$opt['headers'] = array(
			'Content-Type' => 'application/xml'
		);

		// Make sure these are defined.
		if (!defined('AWS_CANONICAL_ID') || !defined('AWS_CANONICAL_NAME'))
		{
			// Fetch the data live.
			$canonical = $this->get_canonical_user_id();
			define('AWS_CANONICAL_ID', $canonical['id']);
			define('AWS_CANONICAL_NAME', $canonical['display_name']);
		}

		if (is_array($acl))
		{
			$opt['body'] = $this->generate_access_policy(AWS_CANONICAL_ID, AWS_CANONICAL_NAME, $acl);
		}
		else
		{
			$opt['headers']['x-amz-acl'] = $acl;
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}


	/*%******************************************************************************************%*/
	// OBJECT METHODS

	/**
	 * Method: create_object()
	 * 	Creates an Amazon S3 object. After an Amazon S3 bucket is created, objects can be stored in it.
	 *
	 * 	Each object can hold up to 5 GB of data. When an object is stored in Amazon S3, the data is streamed
	 * 	to multiple storage servers in multiple data centers. This ensures the data remains available in the
	 * 	event of internal network or hardware failure.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	body - _string_ (Required; Conditional) The data to be stored in the object. Either this parameter or `fileUpload` must be specified.
	 * 	fileUpload - _string_|_resource_ (Required; Conditional) The file system path for the local file to upload, or an open file resource. Either this parameter or `body` is required.
	 * 	acl - _string_ (Optional) The ACL settings for the specified object. [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. The default value is <ACL_PRIVATE>.
	 * 	contentType - _string_ (Optional) The type of content that is being sent in the body. If a file is being uploaded via `fileUpload` as a file system path, it will attempt to determine the correct mime-type based on the file extension. The default value is `application/octet-stream`.
	 * 	headers - _array_ (Optional) The standard HTTP headers to send along in the request.
	 * 	meta - _array_ (Optional) An associative array of key-value pairs. Represented by `x-amz-meta-:` Any header starting with this prefix is considered user metadata. It will be stored with the object and returned when you retrieve the object. The total size of the HTTP request, not including the body, must be less than 4 KB.
	 * 	storage - _string_ (Optional) Whether to use Standard or Reduced Redundancy storage. [Allowed values: `AmazonS3::STORAGE_STANDARD`, `AmazonS3::STORAGE_REDUCED`]. The default value is <STORAGE_STANDARD>.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST Access Control Policy](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAccessPolicy.html)
	 */
	public function create_object($bucket, $filename, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'PUT';
		$opt['resource'] = $filename;

		// Handle content type. Can also be passed as an HTTP header.
		if (isset($opt['contentType']))
		{
			$opt['headers']['Content-Type'] = $opt['contentType'];
			unset($opt['contentType']);
		}

		// Handle Access Control Lists. Can also be passed as an HTTP header.
		if (isset($opt['acl']))
		{
			$opt['headers']['x-amz-acl'] = $opt['acl'];
			unset($opt['acl']);
		}

		// Handle storage settings. Can also be passed as an HTTP header.
		if (isset($opt['storage']))
		{
			$opt['headers']['x-amz-storage-class'] = $opt['storage'];
			unset($opt['storage']);
		}

		// Handle meta tags. Can also be passed as an HTTP header.
		if (isset($opt['meta']))
		{
			foreach ($opt['meta'] as $meta_key => $meta_value)
			{
				// e.g., `My Meta Header` is converted to `x-amz-meta-my-meta-header`.
				$opt['headers']['x-amz-meta-' . strtolower(str_replace(' ', '-', $meta_key))] = $meta_value;
			}
			unset($opt['meta']);
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: get_object()
	 * 	Gets the contents of an Amazon S3 object in the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	etag - _string_ (Optional) The `ETag` header passed in from a previous request. If specified, request `lastmodified` option must be specified as well. Will trigger a `304 Not Modified` status code if the file hasn't changed.
	 * 	fileDownload - _string_|_resource_ (Optional) The file system location to download the file to, or an open file resource. Must be a server-writable location.
	 * 	headers - _array_ (Optional) Standard HTTP headers to send along in the request.
	 * 	lastmodified - _string_ (Optional) The `LastModified` header passed in from a previous request. If specified, request `etag` option must be specified as well. Will trigger a `304 Not Modified` status code if the file hasn't changed.
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	range - _string_ (Optional) The range of bytes to fetch from the object. Specify this parameter when downloading partial bits or completing incomplete object downloads. The specified range must be notated with a hyphen (e.g., 0-10485759). Defaults to the byte range of the complete Amazon S3 object.
	 * 	versionId - _string_ (Optional) The version of the object to retrieve. Version IDs are returned in the `x-amz-version-id` header of any previous object-related request.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_object($bucket, $filename, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'GET';
		$opt['resource'] = $filename;

		if (!isset($opt['headers']) || !is_array($opt['headers']))
		{
			$opt['headers'] = array();
		}

		// Are we checking for changes?
		if (isset($opt['lastmodified']) && isset($opt['etag']))
		{
			$opt['headers']['If-Modified-Since'] = $opt['lastmodified'];
			$opt['headers']['If-None-Match'] = $opt['etag'];
		}

		// Partial content range
		if (isset($opt['range']))
		{
			$opt['headers']['Range'] = 'bytes=' . $opt['range'];
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: get_object_headers()
	 * 	Gets the HTTP headers for the specified Amazon S3 object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	versionId - _string_ (Optional) The version of the object to retrieve. Version IDs are returned in the `x-amz-version-id` header of any previous object-related request.
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_object_headers($bucket, $filename, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'HEAD';
		$opt['resource'] = $filename;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: delete_object()
	 * 	Deletes an Amazon S3 object from the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	versionId - _string_ (Optional) The version of the object to delete. Version IDs are returned in the `x-amz-version-id` header of any previous object-related request.
	 * 	MFASerial - _string_ (Optional) The serial number on the back of the Gemalto device. `MFASerial` and `MFAToken` must both be set for MFA to work.
	 * 	MFAToken - _string_ (Optional) The current token displayed on the Gemalto device. `MFASerial` and `MFAToken` must both be set for MFA to work.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	* [Multi-Factor Authentication](http://aws.amazon.com/mfa/)
	 */
	public function delete_object($bucket, $filename, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'DELETE';
		$opt['resource'] = $filename;

		// Enable MFA delete?
		if (isset($opt['MFASerial']) && isset($opt['MFAToken']))
		{
			$opt['headers'] = array(
				'x-amz-mfa' => ($opt['MFASerial'] . ' ' . $opt['MFAToken'])
			);
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: list_objects()
	 * 	Gets a list of all Amazon S3 objects in the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	delimiter - _string_ (Optional) Keys that contain the same string between the prefix and the first occurrence of the delimiter will be rolled up into a single result element in the CommonPrefixes collection.
	 * 	marker - _string_ (Optional) Restricts the response to contain results that only occur alphabetically after the value of the marker.
	 * 	max-keys - _string_ (Optional) The maximum number of results returned by the method call. The returned list will contain no more results than the specified value, but may return less.
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	prefix - _string_ (Optional) Restricts the response to contain results that begin only with the specified prefix.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_objects($bucket, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'GET';

		foreach (array('delimiter', 'marker', 'max-keys', 'prefix') as $param)
		{
			if (isset($opt[$param]))
			{
				$opt['query_string'][$param] = $opt[$param];
				unset($opt[$param]);
			}
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: copy_object()
	 * 	Copies an Amazon S3 object to a new location, whether in the same Amazon S3 region, bucket, or
	 * 	otherwise.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$source - _ComplexType_ (Required) The bucket and file name to copy from. A required ComplexType is a set of key-value pairs which must be set by passing an associative array with certain entries as keys. See below for a list.
	 * 	$dest - _ComplexType_ (Required) The bucket and file name to copy to. A required ComplexType is a set of key-value pairs which must be set by passing an associative array with certain entries as keys. See below for a list.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $source parameter:
	 *	bucket - _string_ (Required) Specifies the name of the bucket containing the source object.
	 *	filename - _string_ (Required) Specifies the file name of the source object to copy.
	 *
	 * Keys for the $dest parameter:
	 *	bucket - _string_ (Required) Specifies the name of the bucket to copy the object to.
	 *	filename - _string_ (Required) Specifies the file name to copy the object to.
	 *
	 * Keys for the $opt parameter:
	 * 	acl - _string_ (Optional) The ACL settings for the specified object. [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. Alternatively, an array of associative arrays. Each associative array contains an `id` and a `permission` key. The default value is <ACL_PRIVATE>.
	 * 	storage - _string_ (Optional) Whether to use Standard or Reduced Redundancy storage. [Allowed values: `AmazonS3::STORAGE_STANDARD`, `AmazonS3::STORAGE_REDUCED`]. The default value is <STORAGE_STANDARD>.
	 * 	versionId - _string_ (Optional) The version of the object to copy. Version IDs are returned in the `x-amz-version-id` header of any previous object-related request.
	 * 	ifMatch - _string_ (Optional) The ETag header from a previous request. Copies the object if its entity tag (ETag) matches the specified tag; otherwise, the request returns a `412` HTTP status code error (precondition failed). Used in conjunction with `ifUnmodifiedSince`.
	 * 	ifUnmodifiedSince - _string_ (Optional) The LastModified header from a previous request. Copies the object if it hasn't been modified since the specified time; otherwise, the request returns a `412` HTTP status code error (precondition failed). Used in conjunction with `ifMatch`.
	 * 	ifNoneMatch - _string_ (Optional) The ETag header from a previous request. Copies the object if its entity tag (ETag) is different than the specified ETag; otherwise, the request returns a `412` HTTP status code error (failed condition). Used in conjunction with `ifModifiedSince`.
	 * 	ifModifiedSince - _string_ (Optional) The LastModified header from a previous request. Copies the object if it has been modified since the specified time; otherwise, the request returns a `412` HTTP status code error (failed condition). Used in conjunction with `ifNoneMatch`.
	 * 	headers - _array_ (Optional) Standard HTTP headers to send along in the request.
	 * 	meta - _array_ (Optional) Associative array of key-value pairs. Represented by `x-amz-meta-:` Any header starting with this prefix is considered user metadata. It will be stored with the object and returned when you retrieve the object. The total size of the HTTP request, not including the body, must be less than 4 KB.
	 * 	metadataDirective - _string_ (Optional) Accepts either COPY or REPLACE. You will likely never need to use this, as it manages itself with no issues.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[Copying Amazon S3 Objects](http://docs.amazonwebservices.com/AmazonS3/latest/UsingCopyingObjects.html)
	 */
	public function copy_object($source, $dest, $opt = null)
	{
		if (!$opt) $opt = array();
		$batch = array();

		// Add this to our request
		$opt['verb'] = 'PUT';
		$opt['resource'] = $dest['filename'];

		// Handle copy source
		if (isset($source['bucket']) && isset($source['filename']))
		{
			$opt['headers']['x-amz-copy-source'] = '/' . $source['bucket'] . '/' . rawurlencode($source['filename'])
				. (isset($opt['versionId']) ? ('?' . 'versionId=' . rawurlencode($opt['versionId'])) : ''); // Append the versionId to copy, if available
			unset($opt['versionId']);

			// Determine if we need to lookup the pre-existing content-type.
			if (
				(!$this->use_batch_flow && !isset($opt['returnCurlHandle'])) &&
				!in_array(strtolower('content-type'), array_map('strtolower', array_keys($opt['headers'])))
			)
			{
				$response = $this->get_object_headers($source['bucket'], $source['filename']);
				if ($response->isOK())
				{
					$opt['headers']['Content-Type'] = $response->header['content-type'];
				}
			}
		}

		// Handle metadata directive
		$opt['headers']['x-amz-metadata-directive'] = 'COPY';
		if ($source['bucket'] === $dest['bucket'] && $source['filename'] === $dest['filename'])
		{
			$opt['headers']['x-amz-metadata-directive'] = 'REPLACE';
		}
		if (isset($opt['metadataDirective']))
		{
			$opt['headers']['x-amz-metadata-directive'] = $opt['metadataDirective'];
			unset($opt['metadataDirective']);
		}

		// Handle Access Control Lists. Can also pass canned ACLs as an HTTP header.
		if (isset($opt['acl']) && is_array($opt['acl']))
		{
			$batch[] = $this->set_object_acl($dest['bucket'], $dest['filename'], $opt['acl'], array(
				'returnCurlHandle' => true
			));
			unset($opt['acl']);
		}
		elseif (isset($opt['acl']))
		{
			$opt['headers']['x-amz-acl'] = $opt['acl'];
			unset($opt['acl']);
		}

		// Handle storage settings. Can also be passed as an HTTP header.
		if (isset($opt['storage']))
		{
			$opt['headers']['x-amz-storage-class'] = $opt['storage'];
			unset($opt['storage']);
		}

		// Handle conditional-copy parameters
		if (isset($opt['ifMatch']))
		{
			$opt['headers']['x-amz-copy-source-if-match'] = $opt['ifMatch'];
			unset($opt['ifMatch']);
		}
		if (isset($opt['ifNoneMatch']))
		{
			$opt['headers']['x-amz-copy-source-if-none-match'] = $opt['ifNoneMatch'];
			unset($opt['ifNoneMatch']);
		}
		if (isset($opt['ifUnmodifiedSince']))
		{
			$opt['headers']['x-amz-copy-source-if-unmodified-since'] = $opt['ifUnmodifiedSince'];
			unset($opt['ifUnmodifiedSince']);
		}
		if (isset($opt['ifModifiedSince']))
		{
			$opt['headers']['x-amz-copy-source-if-modified-since'] = $opt['ifModifiedSince'];
			unset($opt['ifModifiedSince']);
		}

		// Handle meta tags. Can also be passed as an HTTP header.
		if (isset($opt['meta']))
		{
			foreach ($opt['meta'] as $meta_key => $meta_value)
			{
				// e.g., `My Meta Header` is converted to `x-amz-meta-my-meta-header`.
				$opt['headers']['x-amz-meta-' . strtolower(str_replace(' ', '-', $meta_key))] = $meta_value;
			}
			unset($opt['meta']);
		}

		// Authenticate to S3
		$response = $this->authenticate($dest['bucket'], $opt);

		// Attempt to reset ACLs
		$http = new RequestCore();
		$http->send_multi_request($batch);

		return $response;
	}

	/**
	 * Method: update_object()
	 * 	Updates an Amazon S3 object with new headers or other metadata.
	 *
	 * 	To replace the content of the specified Amazon S3 object, call <create_object()> with the same bucket
	 * 	and file name parameters.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket that contains the source file.
	 * 	$filename - _string_ (Required) The source file name that you want to update.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	acl - _string_ (Optional) The ACL settings for the specified object. [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. The default value is <ACL_PRIVATE>.
	 * 	headers - _array_ (Optional) The standard HTTP headers to update the Amazon S3 object with.
	 * 	meta - _array_ (Optional) An associative array of key-value pairs. Any header with the `x-amz-meta-` prefix is considered user metadata and is stored with the Amazon S3 object. It will be stored with the object and returned when you retrieve the object. The total size of the HTTP request, not including the body, must be less than 4 KB.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[Copying Amazon S3 Objects](http://docs.amazonwebservices.com/AmazonS3/latest/UsingCopyingObjects.html)
	 */
	public function update_object($bucket, $filename, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['metadataDirective'] = 'REPLACE';

		// Authenticate to S3
		return $this->copy_object(
			array('bucket' => $bucket, 'filename' => $filename),
			array('bucket' => $bucket, 'filename' => $filename),
			$opt
		);
	}


	/*%******************************************************************************************%*/
	// ACCESS CONTROL LISTS

	/**
	 * Method: get_object_acl()
	 * 	Gets the access control list (ACL) settings for the specified Amazon S3 object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	versionId - _string_ (Optional) The version of the object to retrieve. Version IDs are returned in the `x-amz-version-id` header of any previous object-related request.
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST Access Control Policy](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAccessPolicy.html)
	 */
	public function get_object_acl($bucket, $filename, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['resource'] = $filename;
		$opt['sub_resource'] = 'acl';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: set_object_acl()
	 * 	Sets the access control list (ACL) settings for the specified Amazon S3 object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$acl - _string_ (Optional) The ACL settings for the specified object. Accepts any of the following constants: [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. Alternatively, an array of associative arrays. Each associative array contains an `id` and a `permission` key. The default value is <ACL_PRIVATE>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST Access Control Policy](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAccessPolicy.html)
	 */
	public function set_object_acl($bucket, $filename, $acl = self::ACL_PRIVATE, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['resource'] = $filename;
		$opt['sub_resource'] = 'acl';

		// Retrieve the original metadata
		$metadata = $this->get_object_metadata($bucket, $filename);
		if ($metadata && $metadata['ContentType'])
		{
			$opt['headers']['Content-Type'] = $metadata['ContentType'];
		}
		if ($metadata && $metadata['StorageClass'])
		{
			$opt['headers']['x-amz-storage-class'] = $metadata['StorageClass'];
		}

		// Make sure these are defined.
		if (!defined('AWS_CANONICAL_ID') || !defined('AWS_CANONICAL_NAME'))
		{
			// Fetch the data live.
			$canonical = $this->get_canonical_user_id();
			define('AWS_CANONICAL_ID', $canonical['id']);
			define('AWS_CANONICAL_NAME', $canonical['display_name']);
		}

		if (is_array($acl))
		{
			$opt['body'] = $this->generate_access_policy(AWS_CANONICAL_ID, AWS_CANONICAL_NAME, $acl);
		}
		else
		{
			$opt['headers']['x-amz-acl'] = $acl;
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: generate_access_policy()
	 * 	Generates the XML to be used for the Access Control Policy.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$canonical_id - _string_ (Required) The canonical ID for the bucket owner. Use the `AWS_CANONICAL_ID` constant or the `id` return value from <get_canonical_user_id()>.
	 * 	$canonical_name - _string_ (Required) The canonical display name for the bucket owner. Use the `AWS_CANONICAL_NAME` constant or the `display_name` value from <get_canonical_user_id()>.
	 * 	$users - _array_ (Optional) An array of associative arrays. Each associative array contains an `id` value and a `permission` value.
	 *
	 * Returns:
	 * 	_string_ Access Control Policy XML.
	 *
	 * See Also:
	 * 	[Access Control Lists](http://docs.amazonwebservices.com/AmazonS3/latest/S3_ACLs.html)
	 */
	public function generate_access_policy($canonical_id, $canonical_name, $users)
	{
		$xml = simplexml_load_string($this->base_acp_xml);
		$owner = $xml->addChild('Owner');
		$owner->addChild('ID', $canonical_id);
		$owner->addChild('DisplayName', $canonical_name);
		$acl = $xml->addChild('AccessControlList');

		foreach ($users as $user)
		{
			$grant = $acl->addChild('Grant');
			$grantee = $grant->addChild('Grantee');

			switch ($user['id'])
			{
				// Authorized Users
				case self::USERS_AUTH:
					$grantee->addAttribute('xsi:type', 'Group', 'http://www.w3.org/2001/XMLSchema-instance');
					$grantee->addChild('URI', self::USERS_AUTH);
					break;

				// All Users
				case self::USERS_ALL:
					$grantee->addAttribute('xsi:type', 'Group', 'http://www.w3.org/2001/XMLSchema-instance');
					$grantee->addChild('URI', self::USERS_ALL);
					break;

				// The Logging User
				case self::USERS_LOGGING:
					$grantee->addAttribute('xsi:type', 'Group', 'http://www.w3.org/2001/XMLSchema-instance');
					$grantee->addChild('URI', self::USERS_LOGGING);
					break;

				// Email Address or Canonical Id
				default:
					if (strpos($user['id'], '@'))
					{
						$grantee->addAttribute('xsi:type', 'AmazonCustomerByEmail', 'http://www.w3.org/2001/XMLSchema-instance');
						$grantee->addChild('EmailAddress', $user['id']);
					}
					else
					{
						// Assume Canonical Id
						$grantee->addAttribute('xsi:type', 'CanonicalUser', 'http://www.w3.org/2001/XMLSchema-instance');
						$grantee->addChild('ID', $user['id']);
					}
					break;
			}

			$grant->addChild('Permission', $user['permission']);
		}

		return $xml->asXML();
	}


	/*%******************************************************************************************%*/
	// LOGGING METHODS

	/**
	 * Method: get_logs()
	 * 	Gets the access logs associated with the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use. Pass a `null` value when using the <set_vhost()> method.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[Server Access Logging](http://docs.amazonwebservices.com/AmazonS3/latest/ServerLogs.html)
	 */
	public function get_logs($bucket, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'logging';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: enable_logging()
	 * 	Enables access logging for the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to enable logging for. Pass a `null` value when using the <set_vhost()> method.
	 * 	$target_bucket - _string_ (Required) The name of the bucket to store the logs in.
	 * 	$target_prefix - _string_ (Required) The prefix to give to the log file names.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	users - _array_ (Optional) An array of associative arrays specifying any user to give access to. Each associative array contains an `id` and `permission` value.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	* [Server Access Logging Configuration API](http://docs.amazonwebservices.com/AmazonS3/latest/LoggingAPI.html)
	 */
	public function enable_logging($bucket, $target_bucket, $target_prefix, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'logging';
		$opt['headers'] = array(
			'Content-Type' => 'application/xml'
		);

		$xml = simplexml_load_string($this->base_logging_xml);
		$LoggingEnabled = $xml->addChild('LoggingEnabled');
		$LoggingEnabled->addChild('TargetBucket', $target_bucket);
		$LoggingEnabled->addChild('TargetPrefix', $target_prefix);
		$TargetGrants = $LoggingEnabled->addChild('TargetGrants');

		if (isset($opt['users']) && is_array($opt['users']))
		{
			foreach ($opt['users'] as $user)
			{
				$grant = $TargetGrants->addChild('Grant');
				$grantee = $grant->addChild('Grantee');

				switch ($user['id'])
				{
					// Authorized Users
					case self::USERS_AUTH:
						$grantee->addAttribute('xsi:type', 'Group', 'http://www.w3.org/2001/XMLSchema-instance');
						$grantee->addChild('URI', self::USERS_AUTH);
						break;

					// All Users
					case self::USERS_ALL:
						$grantee->addAttribute('xsi:type', 'Group', 'http://www.w3.org/2001/XMLSchema-instance');
						$grantee->addChild('URI', self::USERS_ALL);
						break;

					// The Logging User
					case self::USERS_LOGGING:
						$grantee->addAttribute('xsi:type', 'Group', 'http://www.w3.org/2001/XMLSchema-instance');
						$grantee->addChild('URI', self::USERS_LOGGING);
						break;

					// Email Address or Canonical Id
					default:
						if (strpos($user['id'], '@'))
						{
							$grantee->addAttribute('xsi:type', 'AmazonCustomerByEmail', 'http://www.w3.org/2001/XMLSchema-instance');
							$grantee->addChild('EmailAddress', $user['id']);
						}
						else
						{
							// Assume Canonical Id
							$grantee->addAttribute('xsi:type', 'CanonicalUser', 'http://www.w3.org/2001/XMLSchema-instance');
							$grantee->addChild('ID', $user['id']);
						}
						break;
				}

				$grant->addChild('Permission', $user['permission']);
			}
		}

		$opt['body'] = $xml->asXML();

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: disable_logging()
	 * 	Disables access logging for the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use. Pass `null` if using <set_vhost()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[Server Access Logging Configuration API](http://docs.amazonwebservices.com/AmazonS3/latest/LoggingAPI.html)
	 */
	public function disable_logging($bucket, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'logging';
		$opt['headers'] = array(
			'Content-Type' => 'application/xml'
		);
		$opt['body'] = $this->base_logging_xml;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}


	/*%******************************************************************************************%*/
	// CONVENIENCE METHODS

	/**
	 * Method: if_bucket_exists()
	 * 	Gets whether or not the specified Amazon S3 bucket exists in Amazon S3. This includes buckets
	 * 	that do not belong to the caller.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 *
	 * Returns:
	 * 	_boolean_ A value of `true` if the bucket exists, or a value of `false` if it does not.
	 */
	public function if_bucket_exists($bucket)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$header = $this->get_bucket_headers($bucket);
		return (bool) $header->isOK();
	}

	/**
	 * Method: if_object_exists()
	 * 	Gets whether or not the specified Amazon S3 object exists in the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 *
	 * Returns:
	 * 	_boolean_ A value of `true` if the object exists, or a value of `false` if it does not.
	 */
	public function if_object_exists($bucket, $filename)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$header = $this->get_object_headers($bucket, $filename);

		if ($header->isOK()) { return true; }
		elseif ($header->status === 404) { return false; }
		return null;
	}

	/**
	 * Method: if_bucket_policy_exists()
	 * 	Gets whether or not the specified Amazon S3 bucket has a bucket policy associated with it.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 *
	 * Returns:
	 * 	_boolean_ A value of `true` if a bucket policy exists, or a value of `false` if one does not.
	 */
	public function if_bucket_policy_exists($bucket)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$response = $this->get_bucket_policy($bucket);

		if ($response->isOK()) { return true; }
		elseif ($response->status === 404) { return false; }
		return null;
	}

	/**
	 * Method: get_bucket_object_count()
	 * 	Gets the number of Amazon S3 objects in the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 *
	 * Returns:
	 * 	_integer_ The number of Amazon S3 objects in the bucket.
	 */
	public function get_bucket_object_count($bucket)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		return count($this->get_object_list($bucket));
	}

	/**
	 * Method: get_bucket_filesize()
	 * 	Gets the cumulative file size of the contents of the Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$friendly_format - _boolean_ (Optional) A value of `true` will format the return value to 2 decimal points using the largest possible unit (i.e., 3.42 GB). A value of `false` will format the return value as the raw number of bytes.
	 *
	 * Returns:
	 * 	_integer_|_string_ The number of bytes as an integer, or the friendly format as a string.
	 */
	public function get_bucket_filesize($bucket, $friendly_format = false)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$filesize = 0;
		$list = $this->list_objects($bucket);

		foreach ($list->body->Contents as $filename)
		{
			$filesize += (integer) $filename->Size;
		}

		while ((string) $list->body->IsTruncated === 'true')
		{
			$body = (array) $list->body;
			$list = $this->list_objects($bucket, array(
				'marker' => (string) end($body['Contents'])->Key
			));

			foreach ($list->body->Contents as $object)
			{
				$filesize += (integer) $object->Size;
			}
		}

		if ($friendly_format)
		{
			$filesize = $this->util->size_readable($filesize);
		}

		return $filesize;
	}

	/**
	 * Method: get_object_filesize()
	 * 	Gets the file size of the specified Amazon S3 object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$friendly_format - _boolean_ (Optional) A value of `true` will format the return value to 2 decimal points using the largest possible unit (i.e., 3.42 GB). A value of `false` will format the return value as the raw number of bytes.
	 *
	 * Returns:
	 * 	_integer_|_string_ The number of bytes as an integer, or the friendly format as a string.
	 */
	public function get_object_filesize($bucket, $filename, $friendly_format = false)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$object = $this->get_object_headers($bucket, $filename);
		$filesize = (integer) $object->header['content-length'];

		if ($friendly_format)
		{
			$filesize = $this->util->size_readable($filesize);
		}

		return $filesize;
	}

	/**
	 * Method: change_content_type()
	 * 	Changes the content type for an existing Amazon S3 object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$contentType - _string_ (Required) The content-type to apply to the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function change_content_type($bucket, $filename, $contentType, $opt = null)
	{
		if (!$opt) $opt = array();

		// Retrieve the original metadata
		$metadata = $this->get_object_metadata($bucket, $filename);
		if ($metadata && $metadata['ACL'])
		{
			$opt['acl'] = $metadata['ACL'];
		}
		if ($metadata && $metadata['StorageClass'])
		{
			$opt['headers']['x-amz-storage-class'] = $metadata['StorageClass'];
		}

		// Merge optional parameters
		$opt = array_merge(array(
			'headers' => array(
				'Content-Type' => $contentType
			),
			'metadataDirective' => 'REPLACE'
		), $opt);

		return $this->copy_object(
			array('bucket' => $bucket, 'filename' => $filename),
			array('bucket' => $bucket, 'filename' => $filename),
			$opt
		);
	}

	/**
	 * Method: change_storage_redundancy()
	 * 	Changes the storage redundancy for an existing object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$storage - _string_ (Required) The storage setting to apply to the object. [Allowed values: `AmazonS3::STORAGE_STANDARD`, `AmazonS3::STORAGE_REDUCED`]
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function change_storage_redundancy($bucket, $filename, $storage, $opt = null)
	{
		if (!$opt) $opt = array();

		// Retrieve the original metadata
		$metadata = $this->get_object_metadata($bucket, $filename);
		if ($metadata && $metadata['ACL'])
		{
			$opt['acl'] = $metadata['ACL'];
		}
		if ($metadata && $metadata['ContentType'])
		{
			$opt['headers']['Content-Type'] = $metadata['ContentType'];
		}

		// Merge optional parameters
		$opt = array_merge(array(
			'storage' => $storage,
			'metadataDirective' => 'COPY',
		), $opt);

		return $this->copy_object(
			array('bucket' => $bucket, 'filename' => $filename),
			array('bucket' => $bucket, 'filename' => $filename),
			$opt
		);
	}

	/**
	 * Method: get_bucket_list()
	 * 	Gets a simplified list of bucket names on an Amazon S3 account.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the bucket names against.
	 *
	 * Returns:
	 * 	_array_ The list of matching bucket names. If there are no results, the method will return an empty array.
	 *
	 * See Also:
	 * 	[Regular Expressions (Perl-Compatible)](http://php.net/pcre)
	 */
	public function get_bucket_list($pcre = null)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		// Get a list of buckets.
		$list = $this->list_buckets();
		if ($list = $list->body->query('descendant-or-self::Name'))
		{
			$list = $list->map_string($pcre);
			return $list;
		}

		return array();
	}

	/**
	 * Method: get_object_list()
	 * 	Gets a simplified list of Amazon S3 object file names contained in a bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	delimiter - _string_ (Optional) Keys that contain the same string between the prefix and the first occurrence of the delimiter will be rolled up into a single result element in the CommonPrefixes collection.
	 * 	marker - _string_ (Optional) Restricts the response to contain results that only occur alphabetically after the value of the marker.
	 * 	max-keys - _string_ (Optional) The maximum number of results returned by the method call. The returned list will contain no more results than the specified value, but may return less.
	 * 	pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the names against. This is applied only AFTER any native Amazon S3 filtering from specified `prefix`, `marker`, `max-keys`, or `delimiter` values are applied.
	 * 	prefix - _string_ (Optional) Restricts the response to contain results that begin only with the specified prefix.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_array_ The list of matching object names. If there are no results, the method will return an empty array.
	 *
	 * See Also:
	 * 	[Regular Expressions (Perl-Compatible)](http://php.net/pcre)
	 */
	public function get_object_list($bucket, $opt = null)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		if (!$opt) $opt = array();

		// Set some default values
		$pcre = isset($opt['pcre']) ? $opt['pcre'] : null;
		$max_keys = isset($opt['max-keys']) ? (integer) $opt['max-keys'] : 'all';
		$objects = array();

		if ($max_keys === 'all')
		{
			do
			{
				$list = $this->list_objects($bucket, $opt);
				if ($keys = $list->body->query('descendant-or-self::Key')->map_string($pcre))
				{
					$objects = array_merge($objects, $keys);
				}

				$body = (array) $list->body;
				$opt = array_merge($opt, array(
					'marker' => (isset($body['Contents']) && is_array($body['Contents'])) ?
						((string) end($body['Contents'])->Key) :
						((string) $list->body->Contents->Key)
				));
			}
			while ((string) $list->body->IsTruncated === 'true');
		}
		else
		{
			$loops = ceil($max_keys / 1000);

			do
			{
				$list = $this->list_objects($bucket, $opt);
				if ($keys = $list->body->query('descendant-or-self::Key')->map_string($pcre))
				{
					$objects = array_merge($objects, $keys);
				}

				if ($max_keys > 1000)
				{
					$max_keys -= 1000;
				}

				$body = (array) $list->body;
				$opt = array_merge($opt, array(
					'max-keys' => $max_keys,
					'marker' => (isset($body['Contents']) && is_array($body['Contents'])) ?
						((string) end($body['Contents'])->Key) :
						((string) $list->body->Contents->Key)
				));
			}
			while (--$loops);
		}

		if (count($objects) > 0)
		{
			return $objects;
		}

		return array();
	}

	/**
	 * Method: delete_all_objects()
	 * 	Deletes all Amazon S3 objects inside the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the names against. The default value is <PCRE_ALL>.
	 *
	 * Returns:
	 * 	_boolean_ A value of `true` means that all objects were successfully deleted. A value of `false` means that at least one object failed to delete.
	 *
	 * See Also:
	 * 	[Regular Expressions (Perl-Compatible)](http://php.net/pcre)
	 */
	public function delete_all_objects($bucket, $pcre = self::PCRE_ALL)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		// Collect all matches
		$list = $this->get_object_list($bucket, array('pcre' => $pcre));

		// As long as we have at least one match...
		if (count($list) > 0)
		{
			// Create new batch request object
			$q = new $this->batch_class();

			// Go through all of the items and delete them.
			foreach ($list as $item)
			{
				$this->batch($q)->delete_object($bucket, $item);
			}

			return $this->batch($q)->send()->areOK();
		}

		// If there are no matches, return true
		return true;
	}

	/**
	 * Method: delete_all_object_versions()
	 * 	Deletes all of the versions of all Amazon S3 objects inside the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$pcre - _string_ (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the names against. The default value is <PCRE_ALL>.
	 *
	 * Returns:
	 * 	_boolean_ A value of `true` means that all object versions were successfully deleted. A value of `false` means that at least one object/version failed to delete.
	 *
	 * See Also:
	 * 	[Regular Expressions (Perl-Compatible)](http://php.net/pcre)
	 */
	public function delete_all_object_versions($bucket, $pcre = null)
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		// Instantiate
		$q = new CFBatchRequest(200);
		$response = $this->list_bucket_object_versions($bucket);

		// Gather all nodes together into a single array
		if ($response->body->DeleteMarker() && $response->body->Version())
		{
			$markers = array_merge($response->body->DeleteMarker()->getArrayCopy(), $response->body->Version()->getArrayCopy());
		}
		elseif ($response->body->DeleteMarker())
		{
			$markers = $response->body->DeleteMarker()->getArrayCopy();
		}
		elseif ($response->body->Version())
		{
			$markers = $response->body->Version()->getArrayCopy();
		}
		else
		{
			$markers = array();
		}

		while ((string) $response->body->IsTruncated === 'true')
		{
			$response = $this->list_bucket_object_versions($bucket, array(
				'key-marker' => (string) $response->body->NextKeyMarker
			));

			// Gather all nodes together into a single array
			if ($response->body->DeleteMarker() && $response->body->Version())
			{
				$markers = array_merge($markers, $response->body->DeleteMarker()->getArrayCopy(), $response->body->Version()->getArrayCopy());
			}
			elseif ($response->body->DeleteMarker())
			{
				$markers = array_merge($markers, $response->body->DeleteMarker()->getArrayCopy());
			}
			elseif ($response->body->Version())
			{
				$markers = array_merge($markers, $response->body->Version()->getArrayCopy());
			}
		}

		// Loop through markers
		foreach ($markers as $marker)
		{
			if ($pcre)
			{
				if (preg_match($pcre, (string) $marker->Key))
				{
					$this->batch($q)->delete_object($bucket, (string) $marker->Key, array(
						'versionId' => (string) $marker->VersionId
					));
				}
			}
			else
			{
				$this->batch($q)->delete_object($bucket, (string) $marker->Key, array(
					'versionId' => (string) $marker->VersionId
				));
			}
		}

		return $this->batch($q)->send();
	}

	/**
	 * Method: get_object_metadata()
	 * 	Gets the collective metadata for the given Amazon S3 object.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the Amazon S3 object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	versionId - _string_ (Optional) The version of the object to retrieve. Version IDs are returned in the `x-amz-version-id` header of any previous object-related request.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_mixed_ If the object exists, the method returns the collective metadata for the Amazon S3 object. If the object does not exist, the method returns boolean `false`.
	 */
	public function get_object_metadata($bucket, $filename, $opt = null)
	{
		$batch = new CFBatchRequest();
		$this->batch($batch)->get_object_acl($bucket, $filename); // Get ACL info
		$this->batch($batch)->get_object_headers($bucket, $filename); // Get content-type
		$this->batch($batch)->list_objects($bucket, array( // Get other metadata
			'max-keys' => 1,
			'prefix' => $filename
		));
		$response = $this->batch($batch)->send();

		// Fail if any requests were unsuccessful
		if (!$response->areOK())
		{
			return false;
		}

		$data = array(
			'ACL' => array(),
			'ContentType' => null,
			'ETag' => null,
			'Headers' => null,
			'Key' => null,
			'LastModified' => null,
			'Owner' => array(),
			'Size' => null,
			'StorageClass' => null,
		);

		// Add the content type
		$data['ContentType'] = (string) $response[1]->header['content-type'];

		// Add the other metadata (including storage type)
		$contents = json_decode(json_encode($response[2]->body->query('descendant-or-self::Contents')->first()), true);
		$data = array_merge($data, (is_array($contents) ? $contents : array()));

		// Add ACL info
		$grants = $response[0]->body->query('descendant-or-self::Grant');
		$max = count($grants);

		// Add raw header info
		$data['Headers'] = $response[1]->header;
		foreach (array('_info', 'x-amz-id-2', 'x-amz-request-id', 'cneonction', 'server', 'content-length', 'content-type', 'etag') as $header)
		{
			unset($data['Headers'][$header]);
		}
		ksort($data['Headers']);

		foreach ($grants as $grant)
		{
			$dgrant = array(
				'id' => (string) $this->util->try_these(array('ID', 'URI'), $grant->Grantee),
				'permission' => (string) $grant->Permission
			);

			$data['ACL'][] = $dgrant;
		}

		return $data;
	}


	/*%******************************************************************************************%*/
	// URLS

	/**
	 * Method: get_object_url()
	 * 	Gets the web-accessible URL for the Amazon S3 object or generates a time-limited signed request for
	 * 	a private file.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the Amazon S3 object.
	 * 	$preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	method - _string_ (Optional) The HTTP method to use for the request. Defaults to a value of `GET`.
	 * 	torrent - _boolean_ (Optional) A value of `true` will return a URL to a torrent of the Amazon S3 object. A value of `false` will return a non-torrent URL. Defaults to `false`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_string_ The file URL, with authentication and/or torrent parameters if requested.
	 *
	 * See Also:
	 * 	[Using Query String Authentication](http://docs.amazonwebservices.com/AmazonS3/latest/S3_QSAuth.html)
	 */
	public function get_object_url($bucket, $filename, $preauth = 0, $opt = null)
	{
		// Add this to our request
		if (!$opt) $opt = array();
		$opt['verb'] = isset($opt['method']) ? $opt['method'] : 'GET';
		$opt['resource'] = $filename;
		$opt['preauth'] = $preauth;

		if (isset($opt['torrent']) && $opt['torrent'])
		{
			$opt['sub_resource'] = 'torrent';
			unset($opt['torrent']);
		}

		// Authenticate to S3
		$current_ssl_setting = $this->use_ssl;
		$this->use_ssl = false;
		$response = $this->authenticate($bucket, $opt);
		$this->use_ssl = $current_ssl_setting;

		return $response;
	}

	/**
	 * Method: get_torrent_url()
	 * 	Gets the web-accessible URL to a torrent of the Amazon S3 object. The Amazon S3 object's access
	 * 	control list settings (ACL) MUST be set to <ACL_PUBLIC> for a valid URL to be returned.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 *
	 * Returns:
	 * 	_string_ The torrent URL, with authentication parameters if requested.
	 *
	 * See Also:
	 * 	[Using BitTorrent to Retrieve Objects Stored in Amazon S3](http://docs.amazonwebservices.com/AmazonS3/latest/index.html?S3TorrentRetrieve.html)
	 */
	public function get_torrent_url($bucket, $filename, $preauth = 0)
	{
		return $this->get_object_url($bucket, $filename, $preauth, array(
			'torrent' => true
		));
	}


	/*%******************************************************************************************%*/
	// VERSIONING

	/**
	 * Method: enable_versioning()
	 * 	Enables versioning support for the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	MFASerial - _string_ (Optional) The serial number on the back of the Gemalto device. `MFASerial`, `MFAToken` and `MFAStatus` must all be set for MFA to work.
	 * 	MFAToken - _string_ (Optional) The current token displayed on the Gemalto device. `MFASerial`, `MFAToken` and `MFAStatus` must all be set for MFA to work.
	 * 	MFAStatus - _string_ (Optional) The MFA Delete status. Can be `Enabled` or `Disabled`. `MFASerial`, `MFAToken` and `MFAStatus` must all be set for MFA to work.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	* [Multi-Factor Authentication](http://aws.amazon.com/mfa/)
	 */
	public function enable_versioning($bucket, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'versioning';
		$opt['headers'] = array(
			'Content-Type' => 'application/xml'
		);

		$xml = simplexml_load_string($this->base_versioning_xml);
		$xml->addChild('Status', 'Enabled');

		// Enable MFA delete?
		if (isset($opt['MFASerial']) && isset($opt['MFAToken']) && isset($opt['MFAStatus']))
		{
			$xml->addChild('MfaDelete', $opt['MFAStatus']);

			$opt['headers']['x-amz-mfa'] = ($opt['MFASerial'] . ' ' . $opt['MFAToken']);
		}

		$opt['body'] = $xml->asXML();

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: disable_versioning()
	 * 	Disables versioning support for the specified Amazon S3 bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	MFASerial - _string_ (Optional) The serial number on the back of the Gemalto device. `MFASerial`, `MFAToken` and `MFAStatus` must all be set for MFA to work.
	 * 	MFAToken - _string_ (Optional) The current token displayed on the Gemalto device. `MFASerial`, `MFAToken` and `MFAStatus` must all be set for MFA to work.
	 * 	MFAStatus - _string_ (Optional) The MFA Delete status. Can be `Enabled` or `Disabled`. `MFASerial`, `MFAToken` and `MFAStatus` must all be set for MFA to work.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	* [Multi-Factor Authentication](http://aws.amazon.com/mfa/)
	 */
	public function disable_versioning($bucket, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'versioning';
		$opt['headers'] = array(
			'Content-Type' => 'application/xml'
		);

		$xml = simplexml_load_string($this->base_versioning_xml);
		$xml->addChild('Status', 'Suspended');

		// Enable MFA delete?
		if (isset($opt['MFASerial']) && isset($opt['MFAToken']) && isset($opt['MFAStatus']))
		{
			$xml->addChild('MfaDelete', $opt['MFAStatus']);

			$opt['headers']['x-amz-mfa'] = ($opt['MFASerial'] . ' ' . $opt['MFAToken']);
		}

		$opt['body'] = $xml->asXML();

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: get_versioning_status()
	 * 	Gets an Amazon S3 bucket's versioning status.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_versioning_status($bucket, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'versioning';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: list_bucket_object_versions()
	 * 	Gets a list of all the versions of Amazon S3 objects in the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	delimiter - _string_ (Optional) Unicode string parameter. Keys that contain the same string between the prefix and the first occurrence of the delimiter will be rolled up into a single result element in the CommonPrefixes collection.
	 * 	key-marker - _string_ (Optional) Restricts the response to contain results that only occur alphabetically after the value of the `key-marker`.
	 * 	max-keys - _string_ (Optional) Limits the number of results returned in response to your query. Will return no more than this number of results, but possibly less.
	 * 	prefix - _string_ (Optional) Restricts the response to only contain results that begin with the specified prefix.
	 * 	version-id-marker - _string_ (Optional) Restricts the response to contain results that only occur alphabetically after the value of the `version-id-marker`.
	 * 	preauth - _integer_|_string_ (Optional) Specifies that a presigned URL for this request should be returned. May be passed as a number of seconds since UNIX Epoch, or any string compatible with `strtotime()`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_bucket_object_versions($bucket, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'versions';

		foreach (array('delimiter', 'key-marker', 'max-keys', 'prefix', 'version-id-marker') as $param)
		{
			if (isset($opt[$param]))
			{
				$opt['query_string'][$param] = $opt[$param];
				unset($opt[$param]);
			}
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}


	/*%******************************************************************************************%*/
	// BUCKET POLICIES

	/**
	 * Method: set_bucket_policy()
	 * 	Sets the policy sub-resource for the specified Amazon S3 bucket. The specified policy replaces any
	 * 	policy the bucket already has.
	 *
	 * 	To perform this operation, the caller must be authorized to set a policy for the bucket and have
	 * 	PutPolicy permissions. If the caller does not have PutPolicy permissions for the bucket, Amazon S3
	 * 	returns a `403 Access Denied` error. If the caller has the correct permissions but has not been
	 * 	authorized by the bucket owner, Amazon S3 returns a `405 Method Not Allowed` error.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$policy - _CFPolicy_ (Required) The JSON policy to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [Appendix: The Access Policy Language](http://docs.amazonwebservices.com/AmazonS3/latest/dev/AccessPolicyLanguage.html)
	 */
	public function set_bucket_policy($bucket, CFPolicy $policy, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'policy';
		$opt['body'] = $policy->get_json();

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: get_bucket_policy()
	 * 	Gets the policy of the specified Amazon S3 bucket.
	 *
	 * 	To use this operation, the caller must have GetPolicy permissions for the specified bucket and must be
	 * 	the bucket owner. If the caller does not have GetPolicy permissions, this method will generate a
	 * 	`403 Access Denied` error. If the caller has the correct permissions but is not the bucket owner, this
	 * 	method will generate a `405 Method Not Allowed` error. If the bucket does not have a policy defined for
	 * 	it, this method will generate a `404 Policy Not Found` error.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_bucket_policy($bucket, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'policy';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: delete_bucket_policy()
	 * 	Deletes the bucket policy for the specified Amazon S3 bucket. To delete the policy, the caller must
	 * 	be the bucket owner and have `DeletePolicy` permissions for the specified bucket.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response. If you do not have `DeletePolicy` permissions, Amazon S3 returns a `403 Access Denied` error. If you have the correct permissions, but are not the bucket owner, Amazon S3 returns a `405 Method Not Allowed` error. If the bucket doesn't have a policy, Amazon S3 returns a `204 No Content` error.
	 */
	public function delete_bucket_policy($bucket, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'DELETE';
		$opt['sub_resource'] = 'policy';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}


	/*%******************************************************************************************%*/
	// BUCKET NOTIFICATIONS

	/**
	 * Method: create_bucket_notification()
	 * 	Enables notifications of specified events for an Amazon S3 bucket. Currently, the
	 * 	`s3:ReducedRedundancyLostObject` event is the only event supported for notifications. The
	 * 	`s3:ReducedRedundancyLostObject` event is triggered when Amazon S3 detects that it has lost all
	 * 	copies of an Amazon S3 object and can no longer service requests for that object.
	 *
	 * 	If the bucket owner and Amazon SNS topic owner are the same, the bucket owner has permission to
	 * 	publish notifications to the topic by default. Otherwise, the owner of the topic must create a
	 * 	policy to enable the bucket owner to publish to the topic.
	 *
	 * 	By default, only the bucket owner can configure notifications on a bucket. However, bucket owners
	 * 	can use bucket policies to grant permission to other users to set this configuration with the
	 * 	`s3:PutBucketNotification` permission.
	 *
	 * 	After a PUT operation is called to configure notifications on a bucket, Amazon S3 publishes a test
	 * 	notification to ensure that the topic exists and that the bucket owner has permission to publish
	 * 	to the specified topic. If the notification is successfully published to the SNS topic, the PUT
	 * 	operation updates the bucket configuration and returns the 200 OK responses with a
	 * 	`x-amz-sns-test-message-id` header containing the message ID of the test notification sent to topic.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to create bucket notifications for.
	 * 	$topic_arn - _string_ (Required) The SNS topic ARN to send notifications to.
	 * 	$event - _string_ (Required) The event type to listen for.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [Setting Up Notification of Bucket Events](http://docs.amazonwebservices.com/AmazonS3/latest/dev/NotificationHowTo.html)
	 */
	public function create_bucket_notification($bucket, $topic_arn, $event, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'notification';
		$opt['headers'] = array(
			'Content-Type' => 'application/xml'
		);

		$xml = simplexml_load_string($this->base_notification_xml);
		$topic_config = $xml->addChild('TopicConfiguration');
		$topic_config->addChild('Topic', $topic_arn);
		$topic_config->addChild('Event', $event);

		$opt['body'] = $xml->asXML();

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: get_bucket_notifications()
	 * 	Gets the notification configuration of a bucket. Currently, the `s3:ReducedRedundancyLostObject` event
	 * 	is the only event supported for notifications. The `s3:ReducedRedundancyLostObject` event is triggered
	 * 	when Amazon S3 detects that it has lost all replicas of a Reduced Redundancy Storage object and can no
	 * 	longer service requests for that object.
	 *
	 * 	If notifications are not enabled on the bucket, the operation returns an empty
	 * 	`NotificatonConfiguration` element.
	 *
	 * 	By default, you must be the bucket owner to read the notification configuration of a bucket. However,
	 * 	the bucket owner can use a bucket policy to grant permission to other users to read this configuration
	 * 	with the `s3:GetBucketNotification` permission.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A _CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [Setting Up Notification of Bucket Events](http://docs.amazonwebservices.com/AmazonS3/latest/dev/NotificationHowTo.html)
	 */
	public function get_bucket_notifications($bucket, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'notification';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: delete_bucket_notification()
	 * 	Empties the list of SNS topics to send notifications to.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	- [Setting Up Notification of Bucket Events](http://docs.amazonwebservices.com/AmazonS3/latest/dev/NotificationHowTo.html)
	 */
	public function delete_bucket_notification($bucket, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['verb'] = 'PUT';
		$opt['sub_resource'] = 'notification';
		$opt['body'] = $this->base_notification_xml;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}


	/*%******************************************************************************************%*/
	// MULTIPART UPLOAD

	/**
	 * Method: get_multipart_counts()
	 * 	Calculates the correct values for sequentially reading a file for multipart upload. This method should
	 * 	be used in conjunction with <upload_part()>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$filesize - _integer_ (Required) The size in bytes of the entire file.
	 * 	$part_size - _integer_ (Required) The size in bytes of the part of the file to send.
	 *
	 * Returns:
	 * 	_array_ An array containing key-value pairs. The keys are `seekTo` and `length`.
	 */
	public function get_multipart_counts($filesize, $part_size)
	{
		$i = 0;
		$sizecount = $filesize;
		$values = array();

		while ($sizecount > 0)
		{
			$sizecount -= $part_size;
			$values[] = array(
				'seekTo' => ($part_size * $i),
				'length' => (($sizecount > 0) ? $part_size : ($sizecount + $part_size)),
			);
			$i++;
		}

		return $values;
	}

	/**
	 * Method: initiate_multipart_upload()
	 * 	Initiates a multipart upload and returns an `UploadId`.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	acl - _string_ (Optional) The ACL settings for the specified object. [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. The default value is <ACL_PRIVATE>.
	 * 	contentType - _string_ (Optional) The type of content that is being sent. The default value is `application/octet-stream`.
	 * 	headers - _array_ (Optional) The standard HTTP headers to send along in the request.
	 * 	meta - _array_ (Optional) An associative array of key-value pairs. Any header starting with `x-amz-meta-:` is considered user metadata. It will be stored with the object and returned when you retrieve the object. The total size of the HTTP request, not including the body, must be less than 4 KB.
	 * 	storage - _string_ (Optional) Whether to use Standard or Reduced Redundancy storage. [Allowed values: `AmazonS3::STORAGE_STANDARD`, `AmazonS3::STORAGE_REDUCED`]. The default value is <STORAGE_STANDARD>.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST Access Control Policy](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAccessPolicy.html)
	 */
	public function initiate_multipart_upload($bucket, $filename, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'POST';
		$opt['resource'] = $filename;
		$opt['sub_resource'] = 'uploads';

		// Handle content type. Can also be passed as an HTTP header.
		if (isset($opt['contentType']))
		{
			$opt['headers']['Content-Type'] = $opt['contentType'];
			unset($opt['contentType']);
		}

		// Handle Access Control Lists. Can also be passed as an HTTP header.
		if (isset($opt['acl']))
		{
			$opt['headers']['x-amz-acl'] = $opt['acl'];
			unset($opt['acl']);
		}

		// Handle storage settings. Can also be passed as an HTTP header.
		if (isset($opt['storage']))
		{
			$opt['headers']['x-amz-storage-class'] = $opt['storage'];
			unset($opt['storage']);
		}

		// Handle meta tags. Can also be passed as an HTTP header.
		if (isset($opt['meta']))
		{
			foreach ($opt['meta'] as $meta_key => $meta_value)
			{
				// e.g., `My Meta Header` is converted to `x-amz-meta-my-meta-header`.
				$opt['headers']['x-amz-meta-' . strtolower(str_replace(' ', '-', $meta_key))] = $meta_value;
			}
			unset($opt['meta']);
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: upload_part()
	 * 	Uploads a single part of a multipart upload. The part size cannot be smaller than 5 MB
	 * 	or larger than 5 GB. A multipart upload can have no more than 10,000 parts.
	 *
	 * 	Amazon S3 charges for storage as well as requests to the service. Smaller part sizes (and more
	 * 	requests) allow for faster failures and better upload reliability. Larger part sizes (and fewer
	 * 	requests) costs slightly less but has lower upload reliability.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$upload_id - _string_ (Required) The upload ID identifying the multipart upload whose parts are being listed. The upload ID is retrieved from a call to <initiate_multipart_upload()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	fileUpload - _string_|_resource_ (Required) The file system path for the local file to upload or an open file resource.
	 * 	partNumber - _integer_ (Required) The part number order of the multipart upload.
	 * 	expect - _string_ (Optional) Specifies that the SDK not send the request body until it receives an acknowledgement. If the message is rejected based on the headers, the body of the message is not sent. For more information, see [RFC 2616, section 14.20](http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.20). The value can also be passed to the `header` option as `Expect`. [Allowed values: `100-continue`]
	 * 	headers - _array_ (Optional) The standard HTTP headers to send along in the request.
	 * 	length - _integer_ (Optional) The size of the part in bytes. For more information, see [RFC 2616, section 14.13](http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.13). The value can also be passed to the `header` option as `Content-Length`.
	 * 	md5 - _string_ (Optional) The base64 encoded 128-bit MD5 digest of the part data. This header can be used as a message integrity check to verify that the part data is the same data that was originally sent. Although it is optional, we recommend using this mechanism as an end-to-end integrity check. For more information, see [RFC 1864](http://www.ietf.org/rfc/rfc1864.txt). The value can also be passed to the `header` option as `Content-MD5`.
	 * 	seekTo - _integer_ (Optional) The starting position in bytes for the piece of the file to upload.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function upload_part($bucket, $filename, $upload_id, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'PUT';
		$opt['resource'] = $filename;
		$opt['uploadId'] = $upload_id;

		if (!isset($opt['fileUpload']) || !isset($opt['partNumber']))
		{
			throw new S3_Exception('The `fileUpload` and `partNumber` options are both required in ' . __FUNCTION__ . '().');
		}

		// Handle expectation. Can also be passed as an HTTP header.
		if (isset($opt['expect']))
		{
			$opt['headers']['Expect'] = $opt['expect'];
			unset($opt['expect']);
		}

		// Handle content md5. Can also be passed as an HTTP header.
		if (isset($opt['md5']))
		{
			$opt['headers']['Content-MD5'] = $opt['md5'];
			unset($opt['md5']);
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: list_parts()
	 * 	Lists the completed parts of an in-progress multipart upload.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$upload_id - _string_ (Required) The upload ID identifying the multipart upload whose parts are being listed. The upload ID is retrieved from a call to <initiate_multipart_upload()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	max-parts - _string_ (Optional) The maximum number of parts to return in the response body.
	 * 	part-number-marker - _string_ (Optional) Restricts the response to contain results that only occur numerically after the value of the `part-number-marker`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_parts($bucket, $filename, $upload_id, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'GET';
		$opt['resource'] = $filename;
		$opt['uploadId'] = $upload_id;
		$opt['query_string'] = array();

		foreach (array('max-parts', 'part-number-marker') as $param)
		{
			if (isset($opt[$param]))
			{
				$opt['query_string'][$param] = $opt[$param];
				unset($opt[$param]);
			}
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: abort_multipart_upload()
	 * 	Aborts an in-progress multipart upload. This operation cannot be reversed.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$upload_id - _string_ (Required) The upload ID identifying the multipart upload whose parts are being listed. The upload ID is retrieved from a call to <initiate_multipart_upload()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function abort_multipart_upload($bucket, $filename, $upload_id, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'DELETE';
		$opt['resource'] = $filename;
		$opt['uploadId'] = $upload_id;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: complete_multipart_upload()
	 * 	Completes an in-progress multipart upload.
	 *
	 * 	A multipart upload is completed by describing the part numbers and corresponding ETag values in order, and submitting that data to Amazon S3 as an XML document.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$upload_id - _string_ (Required) The upload ID identifying the multipart upload whose parts are being listed. The upload ID is retrieved from a call to <initiate_multipart_upload()>.
	 * 	$parts - _string_|_array_|_SimpleXMLElement_|_CFResponse_ (Required) The completion XML document. This document can be provided in multiple ways; as a string of XML, as a `SimpleXMLElement` object representing the XML document, as an indexed array of associative arrays where the keys are `PartNumber` and `ETag`, or as a `CFResponse` object returned by <list_parts()>.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function complete_multipart_upload($bucket, $filename, $upload_id, $parts, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'POST';
		$opt['resource'] = $filename;
		$opt['uploadId'] = $upload_id;
		$opt['headers'] = array(
			'Content-Type' => 'application/xml'
		);

		// Disable Content-MD5 calculation for this operation
		$opt['NoContentMD5'] = true;

		if (is_string($parts))
		{
			// Assume it's the intended XML.
			$opt['body'] = $xml;
		}
		elseif ($parts instanceof SimpleXMLElement)
		{
			// Assume it's a SimpleXMLElement object representing the XML.
			$opt['body'] = $xml->asXML();
		}
		elseif (is_array($parts) || $parts instanceof CFResponse)
		{
			$xml = simplexml_load_string($this->complete_mpu_xml);

			if (is_array($parts))
			{
				// Generate the appropriate XML.
				foreach ($parts as $node)
				{
					$part = $xml->addChild('Part');
					$part->addChild('PartNumber', $node['PartNumber']);
					$part->addChild('ETag', $node['ETag']);
				}

			}
			elseif ($parts instanceof CFResponse)
			{
				// Assume it's a response from list_parts().
				foreach ($parts->body->Part as $node)
				{
					$part = $xml->addChild('Part');
					$part->addChild('PartNumber', (string) $node->PartNumber);
					$part->addChild('ETag', (string) $node->ETag);
				}
			}

			$opt['body'] = $xml->asXML();
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: list_multipart_uploads()
	 * 	Lists the in-progress multipart uploads.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	delimiter - _string_ (Optional) Keys that contain the same string between the prefix and the first occurrence of the delimiter will be rolled up into a single result element in the CommonPrefixes collection.
	 * 	key-marker - _string_ (Optional) Restricts the response to contain results that only occur alphabetically after the value of the `key-marker`. If used in conjunction with `upload-id-marker`, the results will be filtered to include keys whose upload ID is alphabetically after the value of `upload-id-marker`.
	 * 	upload-id-marker - _string_ (Optional) Restricts the response to contain results that only occur alphabetically after the value of the `upload-id-marker`. Must be used in conjunction with `key-marker`.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_multipart_uploads($bucket, $opt = null)
	{
		if (!$opt) $opt = array();

		// Add this to our request
		$opt['verb'] = 'GET';
		$opt['sub_resource'] = 'uploads';

		foreach (array('key-marker', 'max-uploads', 'upload-id-marker') as $param)
		{
			if (isset($opt[$param]))
			{
				$opt['query_string'][$param] = $opt[$param];
				unset($opt[$param]);
			}
		}

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Method: create_mpu_object()
	 * 	Creates an Amazon S3 object using the multipart upload APIs. It is analogous to <create_object()>.
	 *
	 * 	While each individual part of a multipart upload can hold up to 5 GB of data, this method limits the
	 * 	part size to a maximum of 500 MB. The combined size of all parts can not exceed 5 GB of data. When an
	 * 	object is stored in Amazon S3, the data is streamed to multiple storage servers in multiple data
	 * 	centers. This ensures the data remains available in the event of internal network or hardware failure.
	 *
	 * 	Amazon S3 charges for storage as well as requests to the service. Smaller part sizes (and more
	 * 	requests) allow for faster failures and better upload reliability. Larger part sizes (and fewer
	 * 	requests) costs slightly less but has lower upload reliability.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$bucket - _string_ (Required) The name of the bucket to use.
	 * 	$filename - _string_ (Required) The file name for the object.
	 * 	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 * 	fileUpload - _string_|_resource_ (Required) The file system path for the local file to upload or an open file resource.
	 * 	acl - _string_ (Optional) The ACL settings for the specified object. [Allowed values: `AmazonS3::ACL_PRIVATE`, `AmazonS3::ACL_PUBLIC`, `AmazonS3::ACL_OPEN`, `AmazonS3::ACL_AUTH_READ`, `AmazonS3::ACL_OWNER_READ`, `AmazonS3::ACL_OWNER_FULL_CONTROL`]. The default value is <ACL_PRIVATE>.
	 * 	contentType - _string_ (Optional) The type of content that is being sent in the body. The default value is `application/octet-stream`.
	 * 	headers - _array_ (Optional) The standard HTTP headers to send along in the request.
	 * 	meta - _array_ (Optional) An associative array of key-value pairs. Any header starting with `x-amz-meta-:` is considered user metadata. It will be stored with the object and returned when you retrieve the object. The total size of the HTTP request, not including the body, must be less than 4 KB.
	 * 	partSize - _integer_ (Optional) The size of an individual part. The size may not be smaller than 5 MB or larger than 500 MB. The default value is 50 MB.
	 * 	storage - _string_ (Optional) Whether to use Standard or Reduced Redundancy storage. [Allowed values: `AmazonS3::STORAGE_STANDARD`, `AmazonS3::STORAGE_REDUCED`]. The default value is <STORAGE_STANDARD>.
	 * 	uploadId - _string_ (Optional) An upload ID identifying an existing multipart upload to use. If this option is not set, one will be created automatically.
	 * 	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 * 	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 *
	 * See Also:
	 * 	[REST Access Control Policy](http://docs.amazonwebservices.com/AmazonS3/latest/RESTAccessPolicy.html)
	 */
	public function create_mpu_object($bucket, $filename, $opt = null)
	{
		// Don't timeout!
		set_time_limit(0);

		if (!isset($opt['fileUpload']))
		{
			throw new S3_Exception('The `fileUpload` option is required in ' . __FUNCTION__ . '().');
		}

		// Handle part size
		if (isset($opt['partSize']))
		{
			// If less that 5 MB...
			if ((integer) $opt['partSize'] < 5242880)
			{
				$opt['partSize'] = 5242880; // 5 MB
			}
			// If more than 500 MB...
			elseif ((integer) $opt['partSize'] > 524288000)
			{
				$opt['partSize'] = 524288000; // 500 MB
			}
		}
		else
		{
			$opt['partSize'] = 52428800; // 50 MB
		}

		$upload_filesize = filesize($opt['fileUpload']);

		// If the upload size is smaller than the piece size, failover to create_object().
		if ($upload_filesize < $opt['partSize'])
		{
			return $this->create_object($bucket, $filename, $opt);
		}

		// Initiate multipart upload
		if (isset($opt['uploadId']))
		{
			$upload_id = $opt['uploadId'];
		}
		else
		{
			// Compose options for initiate_multipart_upload().
			$_opt = array();
			foreach (array('contentType', 'acl', 'storage', 'headers', 'meta') as $param)
			{
				if (isset($opt[$param]))
				{
					$_opt[$param] = $opt[$param];
				}
			}

			$upload = $this->initiate_multipart_upload($bucket, $filename, $_opt);
			if (!$upload->isOK())
			{
				return false;
			}

			// Fetch the UploadId
			$upload_id = (string) $upload->body->UploadId;
		}

		// Get the list of pieces
		$pieces = $this->get_multipart_counts($upload_filesize, (integer) $opt['partSize']);

		// Queue batch requests
		$batch = new CFBatchRequest();
		foreach ($pieces as $i => $piece)
		{
			$this->batch($batch)->upload_part($bucket, $filename, $upload_id, array(
				'expect' => '100-continue',
				'fileUpload' => $opt['fileUpload'],
				'partNumber' => ($i + 1),
				'seekTo' => (integer) $piece['seekTo'],
				'length' => (integer) $piece['length'],
			));
		}

		// Send batch requests
		$batch_responses = $this->batch($batch)->send();
		if (!$batch_responses->areOK())
		{
			return false;
		}

		// Compose completion XML
		$parts = array();
		foreach ($batch_responses as $i => $response)
		{
			$parts[] = array('PartNumber' => ($i + 1), 'ETag' => $response->header['etag']);
		}

		return $this->complete_multipart_upload($bucket, $filename, $upload_id, $parts);
	}


	/*%******************************************************************************************%*/
	// MISCELLANEOUS

	/**
	 * Method: get_canonical_user_id()
	 * 	Gets the canonical user ID and display name from the Amazon S3 server.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_array_ An associative array containing the `id` and `display_name` values.
	 */
	public function get_canonical_user_id()
	{
		if ($this->use_batch_flow)
		{
			throw new S3_Exception(__FUNCTION__ . '() cannot be batch requested');
		}

		$id = $this->list_buckets();

		return array(
			'id' => (string) $id->body->Owner->ID,
			'display_name' => (string) $id->body->Owner->DisplayName
		);
	}
}

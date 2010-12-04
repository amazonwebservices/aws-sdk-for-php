<?php
/**
 * File: CacheAPC
 * 	APC-based caching class.
 *
 * Version:
 * 	2009.10.10
 *
 * Copyright:
 * 	2006-2010 Ryan Parman, Foleeo Inc., and contributors.
 *
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 *
 * See Also:
* 	CacheCore - http://cachecore.googlecode.com
 * 	CloudFusion - http://getcloudfusion.com
 * 	APC - http://php.net/apc
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CacheAPC
 * 	Container for all APC-based cache methods. Inherits additional methods from CacheCore. Adheres to the ICacheCore interface.
 */
class CacheAPC extends CacheCore implements ICacheCore
{

	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	name - _string_ (Required) A name to uniquely identify the cache object.
	 * 	location - _string_ (Required) The location to store the cache object in. This may vary by cache method.
	 * 	expires - _integer_ (Required) The number of seconds until a cache object is considered stale.
	 * 	gzip - _boolean_ (Optional) Whether data should be gzipped before being stored. Defaults to true.
	 *
	 * Returns:
	 * 	_object_ Reference to the cache object.
	 */
	public function __construct($name, $location, $expires, $gzip = true)
	{
		parent::__construct($name, null, $expires, $gzip);
		$this->id = $this->name;
	}

	/**
	 * Method: create()
	 * 	Creates a new cache.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	data - _mixed_ (Required) The data to cache.
	 *
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function create($data)
	{
		$data = serialize($data);
		$data = $this->gzip ? gzcompress($data) : $data;

		return apc_add($this->id, $data, $this->expires);
	}

	/**
	 * Method: read()
	 * 	Reads a cache.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_mixed_ Either the content of the cache object, or _boolean_ false.
	 */
	public function read()
	{
		if ($data = apc_fetch($this->id))
		{
			$data = $this->gzip ? gzuncompress($data) : $data;
			return unserialize($data);
		}

		return false;
	}

	/**
	 * Method: update()
	 * 	Updates an existing cache.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	data - _mixed_ (Required) The data to cache.
	 *
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function update($data)
	{
		$data = serialize($data);
		$data = $this->gzip ? gzcompress($data) : $data;

		return apc_store($this->id, $data, $this->expires);
	}

	/**
	 * Method: delete()
	 * 	Deletes a cache.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function delete()
	{
		return apc_delete($this->id);
	}

	/**
	 * Method: is_expired()
	 * 	Implemented here, but always returns false. APC manages it's own expirations.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether the cache is expired or not.
	 */
	public function is_expired()
	{
		return false;
	}

	/**
	 * Method: timestamp()
	 * 	Implemented here, but always returns false. APC manages it's own expirations.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_mixed_ Either the Unix time stamp of the cache creation, or _boolean_ false.
	 */
	public function timestamp()
	{
		return false;
	}

	/**
	 * Method: reset()
	 * 	Implemented here, but always returns false. APC manages it's own expirations.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function reset()
	{
		return false;
	}
}

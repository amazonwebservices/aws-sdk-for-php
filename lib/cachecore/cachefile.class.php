<?php
/**
 * File: CacheFile
 * 	File-based caching class.
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
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CacheFile
 * 	Container for all file-based cache methods. Inherits additional methods from CacheCore. Adheres to the ICacheCore interface.
 */
class CacheFile extends CacheCore implements ICacheCore
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
		parent::__construct($name, $location, $expires, $gzip);
		$this->id = $this->location . '/' . $this->name . '.cache';
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
		if (file_exists($this->id))
		{
			return false;
		}
		elseif (file_exists($this->location) && is_writeable($this->location))
		{
			$data = serialize($data);
			$data = $this->gzip ? gzcompress($data) : $data;

			return (bool) file_put_contents($this->id, $data);
		}

		return false;
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
		if (file_exists($this->id) && is_readable($this->id))
		{
			$data = file_get_contents($this->id);
			$data = $this->gzip ? gzuncompress($data) : $data;
			$data = unserialize($data);

			if ($data === false)
			{
				/*
					This should only happen when someone changes the gzip settings and there is
					existing data or someone has been mucking about in the cache folder manually.
					Delete the bad entry since the file cache doesn't clean up after itself and
					then return false so fresh data will be retrieved.
				 */
				$this->delete();
				return false;
			}

			return $data;
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
		if (file_exists($this->id) && is_writeable($this->id))
		{
			$data = serialize($data);
			$data = $this->gzip ? gzcompress($data) : $data;

			return (bool) file_put_contents($this->id, $data);
		}

		return false;
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
		if (file_exists($this->id))
		{
			return unlink($this->id);
		}

		return false;
	}

	/**
	 * Method: timestamp()
	 * 	Retrieves the timestamp of the cache.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_mixed_ Either the Unix timestamp of the cache creation, or _boolean_ false.
	 */
	public function timestamp()
	{
		clearstatcache();

		if (file_exists($this->id))
		{
			$this->timestamp = filemtime($this->id);
			return $this->timestamp;
		}

		return false;
	}

	/**
	 * Method: reset()
	 * 	Resets the freshness of the cache.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function reset()
	{
		if (file_exists($this->id))
		{
			return touch($this->id);
		}

		return false;
	}

	/**
	 * Method: is_expired()
	 * 	Checks whether the cache object is expired or not.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_boolean_ Whether the cache is expired or not.
	 */
	public function is_expired()
	{
		if ($this->timestamp() + $this->expires < time())
		{
			return true;
		}

		return false;
	}
}

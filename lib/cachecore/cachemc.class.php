<?php
/**
 * File: CacheMC
 * 	Memcache-based caching class.
 *
 * Version:
* 	2010.05.17
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
 * 	Memcache - http://php.net/memcache
 * 	Memcached - http://php.net/memcached
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CacheMC
 * 	Container for all Memcache-based cache methods. Inherits additional methods from CacheCore. Adheres to the ICacheCore interface.
 */
class CacheMC extends CacheCore implements ICacheCore
{
	/**
	 * Property: memcache
	 * 	Holds the Memcache object.
	 */
	var $memcache = null;

	/**
	 * Property: is_memcached
	 * 	Whether the Memcached extension is being used (as opposed to Memcache).
	 */
	var $is_memcached = false;


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

		// Prefer Memcached over Memcache.
		if (class_exists('Memcached'))
		{
			$this->memcache = new Memcached();
			$this->is_memcached = true;
		}
		elseif (class_exists('Memcache'))
		{
			$this->memcache = new Memcache();
		}
		else
		{
			return false;
		}

		// Enable compression, if available
		if ($this->gzip)
		{
			if ($this->is_memcached)
			{
				$this->memcache->setOption(Memcached::OPT_COMPRESSION, true);
			}
			else
			{
				$this->gzip = MEMCACHE_COMPRESSED;
			}
		}

		// Process Memcached servers.
		if (isset($location) && sizeof($location) > 0)
		{
			foreach ($location as $loc)
			{
				if (isset($loc['port']) && !empty($loc['port']))
				{
					$this->memcache->addServer($loc['host'], $loc['port']);
				}
				else
				{
					$this->memcache->addServer($loc['host'], 11211);
				}
			}
		}

		return $this;
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
		if ($this->is_memcached)
		{
			return $this->memcache->set($this->id, $data, $this->expires);
		}
		return $this->memcache->set($this->id, $data, $this->gzip, $this->expires);
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
		if ($this->is_memcached)
		{
			return $this->memcache->get($this->id);
		}
		return $this->memcache->get($this->id, $this->gzip);
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
		if ($this->is_memcached)
		{
			return $this->memcache->replace($this->id, $data, $this->expires);
		}
		return $this->memcache->replace($this->id, $data, $this->gzip, $this->expires);
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
		return $this->memcache->delete($this->id);
	}

	/**
	 * Method: is_expired()
	 * 	Defined here, but always returns false. Memcache manages it's own expirations.
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
	 * 	Implemented here, but always returns false. Memcache manages it's own expirations.
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
	 * 	Implemented here, but always returns false. Memcache manages it's own expirations.
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

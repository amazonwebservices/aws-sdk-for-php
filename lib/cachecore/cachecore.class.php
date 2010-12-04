<?php
/**
 * File: CacheCore
 * 	Core functionality and default settings shared across caching classes.
 *
 * Version:
 * 	2010.10.03
 *
 * Copyright:
 * 	2006-2010 Ryan Parman, Foleeo Inc., and contributors.
 *
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 *
 * See Also:
* 	CacheCore - http://github.com/skyzyx/cachecore
 */


/*%******************************************************************************************%*/
// CORE DEPENDENCIES

// Include the ICacheCore interface.
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'icachecore.interface.php'))
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'icachecore.interface.php';
}


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CacheCore
 * 	Container for all shared caching methods. This is not intended to be instantiated directly, but is extended by the cache-specific classes.
 */
class CacheCore
{
	/**
	 * Property: name
	 * A name to uniquely identify the cache object by.
	 */
	var $name;

	/**
	 * Property: location
	 * Where to store the cache.
	 */
	var $location;

	/**
	 * Property: expires
	 * The number of seconds before a cache object is considered stale.
	 */
	var $expires;

	/**
	 * Property: id
	 * Used internally to uniquely identify the location + name of the cache object.
	 */
	var $id;

	/**
	 * Property: timestamp
	 * Stores the time when the cache object was created.
	 */
	var $timestamp;

	/**
	 * Property: gzip
	 * Stores whether or not the content should be gzipped when stored
	 */
	var $gzip;


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
		if (!extension_loaded('zlib'))
		{
			$gzip = false;
		}

		$this->name = $name;
		$this->location = $location;
		$this->expires = $expires;
		$this->gzip = $gzip;

		return $this;
	}

	/**
	 * Method: init()
	 * 	Allows for chaining from the constructor. Requires PHP 5.3 or newer.
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
	 * 	_object_ Reference to a new cache object.
	 */
	public static function init($name, $location, $expires, $gzip = true)
	{
		if (version_compare(PHP_VERSION, '5.3.0', '<'))
		{
			throw new Exception('PHP 5.3 or newer is required to use CacheCore::init().');
		}

		$self = get_called_class();
		return new $self($name, $location, $expires, $gzip);
	}

	/**
	 * Method: response_manager()
	 * 	Provides a simple, straightforward cache-logic mechanism. Useful for non-complex response caches.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	callback - _string_ (Required) The name of the function to fire when we need to fetch new data to cache.
	 * 	params - _array_ (Optional) Parameters to pass into the callback function, as an array.
	 *
	 * Returns:
	 * 	_array_ The cached data being requested.
	 */
	public function response_manager($callback, $params = null)
	{
		// Automatically handle $params values.
		$params = is_array($params) ? $params : array($params);

		if ($data = $this->read())
		{
			if ($this->is_expired())
			{
				if ($data = call_user_func_array($callback, $params))
				{
					$this->update($data);
				}
				else
				{
					$this->reset();
					$data = $this->read();
				}
			}
		}
		else
		{
			if ($data = call_user_func_array($callback, $params))
			{
				$this->create($data);
			}
		}

		return $data;
	}
}

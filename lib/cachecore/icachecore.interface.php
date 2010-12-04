<?php
/**
 * File: ICacheCore
 * 	Interface that all storage-specific adapters must adhere to.
 *
 * Version:
 * 	2009.03.22
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
// INTERFACE

/**
 * Interface: ICacheCore
 * 	Defines the methods that all implementing classes MUST have. Covers CRUD (create, read, update, delete) methods, as well as others that are used in the base CacheCore class.
 */
interface ICacheCore
{

	/**
	 * Method: create()
	 * 	Creates a new cache. Placeholder method should be defined by the implementing class.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	data - _mixed_ (Required) The data to cache.
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 * 
	 * See Also:
	 * 	Example Usage - http://tarzan-aws.com/docs/examples/cachecore/cache.phps
	 */
	public function create($data);

	/**
	 * Method: read()
	 * 	Reads a cache. Placeholder method should be defined by the implementing class.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_mixed_ Either the content of the cache object, or _boolean_ false.
	 * 
	 * See Also:
	 * 	Example Usage - http://tarzan-aws.com/docs/examples/cachecore/cache.phps
	 */
	public function read();

	/**
	 * Method: update()
	 * 	Updates an existing cache. Placeholder method should be defined by the implementing class.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	data - _mixed_ (Required) The data to cache.
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 * 
	 * See Also:
	 * 	Example Usage - http://tarzan-aws.com/docs/examples/cachecore/cache.phps
	 */
	public function update($data);

	/**
	 * Method: delete()
	 * 	Deletes a cache. Placeholder method should be defined by the implementing class.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function delete();

	/**
	 * Method: is_expired()
	 * 	Determines whether a cache has expired or not. Placeholder method should be defined by the implementing class.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_boolean_ Whether the cache is expired or not.
	 * 
	 * See Also:
	 * 	Example Usage - http://tarzan-aws.com/docs/examples/cachecore/cache.phps
	 */
	public function is_expired();

	/**
	 * Method: timestamp()
	 * 	Retrieves the time stamp of the cache. Placeholder method should be defined by the implementing class.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_mixed_ Either the Unix time stamp of the cache creation, or _boolean_ false.
	 */
	public function timestamp();

	/**
	 * Method: reset()
	 * 	Resets the freshness of the cache. Placeholder method should be defined by the implementing class.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 * 
	 * See Also:
	 * 	Example Usage - http://tarzan-aws.com/docs/examples/cachecore/cache.phps
	 */
	public function reset();
}

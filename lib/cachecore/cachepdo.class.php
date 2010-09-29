<?php
/**
 * File: CachePDO
 * 	Database-based caching class using PHP Data Objects (PDO).
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
 * 	PDO - http://php.net/pdo
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CachePDO
 * 	Container for all PDO-based cache methods. Inherits additional methods from CacheCore. Adheres to the ICacheCore interface.
 */
class CachePDO extends CacheCore implements ICacheCore
{
	/**
	 * Property: pdo
	 * 	Reference to the PDO connection object.
	 */
	var $pdo = null;

	/**
	 * Property: dsn
	 * 	Holds the parsed URL components.
	 */
	var $dsn = null;

	/**
	 * Property: dsn_string
	 * 	Holds the PDO-friendly version of the connection string.
	 */
	var $dsn_string = null;

	/**
	 * Property: create
	 * 	Holds the prepared statement for creating an entry.
	 */
	var $create = null;

	/**
	 * Property: read
	 * 	Holds the prepared statement for reading an entry.
	 */
	var $read = null;

	/**
	 * Property: update
	 * 	Holds the prepared statement for updating an entry.
	 */
	var $update = null;

	/**
	 * Property: reset
	 * 	Holds the prepared statement for resetting the expiry of an entry.
	 */
	var $reset = null;

	/**
	 * Property: delete
	 * 	Holds the prepared statement for deleting an entry.
	 */
	var $delete = null;

	/**
	 * Property: store_read
	 * 	Holds the response of the read so we only need to fetch it once instead of doing multiple queries.
	 */
	var $store_read = null;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor.
	 *
	 * 	Tested with MySQL 5.0.x (http://mysql.com), PostgreSQL (http://postgresql.com), and SQLite 3.x (http://sqlite.org).
	 * 	SQLite 2.x is assumed to work. No other PDO-supported databases have been tested (e.g. Oracle, Microsoft SQL Server,
	 * 	IBM DB2, ODBC, Sybase, Firebird). Feel free to send patches for additional database support.
	 *
	 * 	See <http://php.net/pdo> for more information.
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
		// Make sure the name is no longer than 40 characters.
		$name = sha1($name);

		// Call parent constructor and set id.
		parent::__construct($name, $location, $expires, $gzip);
		$this->id = $this->name;
		$options = array();

		// Check if the location contains :// (e.g. mysql://user:pass@hostname:port/table)
		if (stripos($location, '://') === false)
		{
			// No? Just pass it through.
			$this->dsn = parse_url($location);
			$this->dsn_string = $location;
		}
		else
		{
			// Yes? Parse and set the DSN
			$this->dsn = parse_url($location);
			$this->dsn_string = $this->dsn['scheme'] . ':host=' . $this->dsn['host'] . ((isset($this->dsn['port'])) ? ';port=' . $this->dsn['port'] : '') . ';dbname=' . substr($this->dsn['path'], 1);
		}

		// Make sure that user/pass are defined.
		$user = isset($this->dsn['user']) ? $this->dsn['user'] : null;
		$pass = isset($this->dsn['pass']) ? $this->dsn['pass'] : null;

		// Set persistence for databases that support it.
		switch ($this->dsn['scheme'])
		{
			case 'mysql': // MySQL
			case 'pgsql': // PostgreSQL
				$options[PDO::ATTR_PERSISTENT] = true;
				break;
		}

		// Instantiate a new PDO object with a persistent connection.
		$this->pdo = new PDO($this->dsn_string, $user, $pass, $options);

		// Define prepared statements for improved performance.
		$this->create = $this->pdo->prepare("INSERT INTO cache (id, expires, data) VALUES (:id, :expires, :data)");
		$this->read = $this->pdo->prepare("SELECT id, expires, data FROM cache WHERE id = :id");
		$this->reset = $this->pdo->prepare("UPDATE cache SET expires = :expires WHERE id = :id");
		$this->delete = $this->pdo->prepare("DELETE FROM cache WHERE id = :id");
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

		$this->create->bindParam(':id', $this->id);
		$this->create->bindParam(':data', $data);
		$this->create->bindParam(':expires', $this->generate_timestamp());

		return (bool) $this->create->execute();
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
		if (!$this->store_read)
		{
			$this->read->bindParam(':id', $this->id);
			$this->read->execute();
			$this->store_read = $this->read->fetch(PDO::FETCH_ASSOC);
		}

		if ($this->store_read)
		{
			$data = $this->store_read['data'];
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
		$this->delete();
		return $this->create($data);
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
		$this->delete->bindParam(':id', $this->id);
		return $this->delete->execute();
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
		if (!$this->store_read)
		{
			$this->read->bindParam(':id', $this->id);
			$this->read->execute();
			$this->store_read = $this->read->fetch(PDO::FETCH_ASSOC);
		}

		if ($this->store_read)
		{
			$value = $this->store_read['expires'];

			// If 'expires' isn't yet an integer, convert it into one.
			if (!is_numeric($value))
			{
				$value = strtotime($value);
			}

			$this->timestamp = date('U', $value);
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
		$this->reset->bindParam(':id', $this->id);
		$this->reset->bindParam(':expires', $this->generate_timestamp());
		return (bool) $this->reset->execute();
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

	/**
	 * Method: get_drivers()
	 * 	Returns a list of supported PDO database drivers. Identical to PDO::getAvailableDrivers().
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_array_ The list of supported database drivers.
	 *
	 * See Also:
	 * 	PHP Method - http://php.net/pdo.getavailabledrivers
	 */
	public function get_drivers()
	{
		return PDO::getAvailableDrivers();
	}

	/**
	 * Method: generate_timestamp()
	 * 	Returns a timestamp value apropriate to the current database type.
	 *
	 * Access:
	 * 	private
	 *
	 * Returns:
	 * 	_mixed_ Timestamp for MySQL and PostgreSQL, integer value for SQLite.
	 */
	private function generate_timestamp()
	{
		// Define 'expires' settings differently.
		switch ($this->dsn['scheme'])
		{
			// These support timestamps.
			case 'mysql': // MySQL
			case 'pgsql': // PostgreSQL
				$expires = date(DATE_FORMAT_MYSQL, time());
				break;

			// These support integers.
			case 'sqlite': // SQLite 3
			case 'sqlite2': // SQLite 2
				$expires = time();
				break;
		}

		return $expires;
	}
}

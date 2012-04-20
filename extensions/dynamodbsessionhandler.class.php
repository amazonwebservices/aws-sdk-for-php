<?php
/*
 * Copyright 2011-2012 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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
 * Provides an interface for using Amazon DynamoDB as a session store by hooking into
 * PHP's session handler hooks. This class is not auto-loaded, and must be included
 * manually or via the <code>AmazonDynamoDB::register_session_hander()</code> method.
 *
 * Once registered, You may use the native <code>$_SESSION</code> superglobal and
 * session functions, and the sessions will be stored automatically in DynamoDB.
 */
class DynamoDBSessionHandler
{
	/**
	 * @var AmazonDynamoDB The DyanamoDB client.
	 */
	protected $_dynamodb = null;

	/**
	 * @var string The session save path (see <php:session_save_path()>).
	 */
	protected $_save_path = null;

	/**
	 * @var string The session name (see <php:session_name()>).
	 */
	protected $_session_name = null;

	/**
	 * @var boolean Keeps track of if the session is open.
	 */
	protected $_open_session = null;

	/**
	 * @var boolean Keeps track of whether the session is open.
	 */
	protected $_session_written = false;

	/**
	 * @var string The name of the DynamoDB table in which to store sessions.
	 */
	protected $_table_name = 'sessions';

	/**
	 * @var string The name of the hash key in the DynamoDB sessions table.
	 */
	protected $_hash_key = 'id';

	/**
	 * @var integer The lifetime of an inactive session before it should be garbage collected.
	 */
	protected $_session_lifetime = 0;

	/**
	 * @var boolean Whether or not the session handler should do consistent reads from DynamoDB.
	 */
	protected $_consistent_reads = true;

	/**
	 * @var boolean Whether or not the session handler should do session locking.
	 */
	protected $_session_locking = true;

	/**
	 * @var integer Maximum time, in seconds, that the session handler should take to acquire a lock.
	 */
	protected $_max_lock_wait_time = 30;

	/**
	 * @var integer Minimum time, in microseconds, that the session handler should wait to retry acquiring a lock.
	 */
	protected $_min_lock_retry_utime = 10000;

	/**
	 * @var integer Maximum time, in microseconds, that the session handler should wait to retry acquiring a lock.
	 */
	protected $_max_lock_retry_utime = 100000;

	/**
	 * @var array Type for casting the configuration options.
	 */
	protected static $_option_types = array(
		'table_name'           => 'string',
		'hash_key'             => 'string',
		'session_lifetime'     => 'integer',
		'consistent_reads'     => 'boolean',
		'session_locking'      => 'boolean',
		'max_lock_wait_time'   => 'integer',
		'min_lock_retry_utime' => 'integer',
		'max_lock_retry_utime' => 'integer',
	);

	/**
	 * Initializes the session handler and prepares the configuration options.
	 *
	 * @param AmazonDynamoDB $dynamodb (Required) An instance of the DynamoDB client.
	 * @param array $options (Optional) Configuration options.
	 */
	public function __construct(AmazonDynamoDB $dynamodb, array $options = array())
	{
		// Store the AmazonDynamoDB client for use in the session handler
		$this->_dynamodb = $dynamodb;

		// Do type conversions on options and store the values
		foreach ($options as $key => $value)
		{
			if (isset(self::$_option_types[$key]))
			{
				settype($value, self::$_option_types[$key]);
				$this->{'_' . $key} = $value;
			}
		}

		// Make sure the lifetime is positive. Use the gc_maxlifetime otherwise
		if ($this->_session_lifetime <= 0)
		{
			$this->_session_lifetime = (integer) ini_get('session.gc_maxlifetime');
		}
	}

	/**
	 * Destruct the session handler and make sure the session gets written.
	 *
	 * NOTE: It is usually better practice to call <code>session_write_close()</code>
	 * manually in your application as soon as session modifications are complete. This
	 * is especially true if session locking is enabled (which it is by default).
	 *
	 * @see http://php.net/manual/en/function.session-set-save-handler.php#refsect1-function.session-set-save-handler-notes
	 */
	public function __destruct()
	{
		session_write_close();
	}

	/**
	 * Register DynamoDB as a session handler.
	 *
	 * Uses the PHP-provided method to register this class as a session handler.
	 *
	 * @return DynamoDBSessionHandler Chainable.
	 */
	public function register()
	{
		session_set_save_handler(
			array($this, 'open'),
			array($this, 'close'),
			array($this, 'read'),
			array($this, 'write'),
			array($this, 'destroy'),
			array($this, 'garbage_collect')
		);

		return $this;
	}

	/**
	 * Checks if the session is open and writable.
	 *
	 * @return boolean Whether or not the session is still open for writing.
	 */
	public function is_session_open()
	{
		return (boolean) $this->_open_session;
	}

	/**
	 * Delegates to <code>session_start()</code>
	 *
	 * @return DynamoDBSessionHandler Chainable.
	 */
	public function open_session()
	{
		session_start();

		return $this;
	}

	/**
	 * Delegates to <code>session_commit()</code>
	 *
	 * @return DynamoDBSessionHandler Chainable.
	 */
	public function close_session()
	{
		session_commit();

		return $this;
	}

	/**
	 * Delegates to <code>session_destroy()</code>
	 *
	 * @return DynamoDBSessionHandler Chainable.
	 */
	public function destroy_session()
	{
		session_destroy();

		return $this;
	}

	/**
	 * Open a session for writing. Triggered by <php:session_start()>.
	 *
	 * Part of the standard PHP session handler interface.
	 *
	 * @param string $save_path (Required) The session save path (see <php:session_save_path()>).
	 * @param string $session_name (Required) The session name (see <php:session_name()>).
	 * @return boolean Whether or not the operation succeeded.
	 */
	public function open($save_path, $session_name)
	{
		$this->_save_path    = $save_path;
		$this->_session_name = $session_name;
		$this->_open_session = session_id();

		return true;
	}

	/**
	 * Close a session from writing
	 *
	 * Part of the standard PHP session handler interface
	 *
	 * @return boolean Success
	 */
	public function close()
	{
		if (!$this->_session_written)
		{
			// Ensure that the session is unlocked even if the write did not happen
			$id = $this->_open_session;
			$response = $this->_dynamodb->update_item(array(
				'TableName'        => $this->_table_name,
				'Key'              => array('HashKeyElement' => $this->_dynamodb->attribute($this->_id($id))),
				'AttributeUpdates' => array(
					'expires'  => $this->_dynamodb->attribute(time() + $this->_session_lifetime, 'update'),
					'lock'     => array('Action' => AmazonDynamoDB::ACTION_DELETE)
				),
			));

			$this->_session_written = $response->isOK();
		}

		$this->_open_session = null;

		return $this->_session_written;
	}

	/**
	 * Read a session stored in DynamoDB
	 *
	 * Part of the standard PHP session handler interface
	 *
	 * @param string $id (Required) The session ID.
	 * @return string The session data.
	 */
	public function read($id)
	{
		$result = '';

		// Get the session data from DynamoDB (acquire a lock if locking is enabled)
		if ($this->_session_locking)
		{
			$response = $this->_lock_and_read($id);
			$node_name = 'Attributes';
		}
		else
		{
			$response = $this->_dynamodb->get_item(array(
				'TableName'      => $this->_table_name,
				'Key'            => array('HashKeyElement' => $this->_dynamodb->attribute($this->_id($id))),
				'ConsistentRead' => $this->_consistent_reads,
			));
			$node_name = 'Item';
		}

		if ($response->isOK())
		{
			$item = array();

			// Get the data from the DynamoDB response
			if ($response->body->{$node_name})
			{
				foreach ($response->body->{$node_name}->children() as $key => $value)
				{
					$item[$key] = (string) current($value);
				}
			}

			if (isset($item['expires']) && isset($item['data']))
			{
				// Check the expiration date before using
				if ($item['expires'] > time())
				{
					$result = $item['data'];
				}
				else
				{
					$this->destroy($id);
				}
			}
		}

		return $result;
	}

	/**
	 * Write a session to DynamoDB.
	 *
	 * Part of the standard PHP session handler interface.
	 *
	 * @param string $id (Required) The session ID.
	 * @param string $data (Required) The session data.
	 * @return boolean Whether or not the operation succeeded.
	 */
	public function write($id, $data)
	{
		// Write the session data to DynamoDB
		$response = $this->_dynamodb->put_item(array(
			'TableName' => $this->_table_name,
			'Item'      => $this->_dynamodb->attributes(array(
				$this->_hash_key => $this->_id($id),
				'expires'        => time() + $this->_session_lifetime,
				'data'           => $data,
			)),
		));

		$this->_session_written = $response->isOK();

		return $this->_session_written;
	}

	/**
	 * Delete a session stored in DynamoDB.
	 *
	 * Part of the standard PHP session handler interface.
	 *
	 * @param string $id (Required) The session ID.
	 * @param boolean $garbage_collect_mode (Optional) Whether or not the handler is doing garbage collection.
	 * @return boolean Whether or not the operation succeeded.
	 */
	public function destroy($id, $garbage_collect_mode = false)
	{
		// Make sure we don't prefix the ID a second time
		if (!$garbage_collect_mode)
		{
			$id = $this->_id($id);
		}

		$delete_options = array(
			'TableName' => $this->_table_name,
			'Key'       => array('HashKeyElement' => $this->_dynamodb->attribute($id)),
		);

		// Make sure not to garbage collect locked sessions
		if ($garbage_collect_mode && $this->_session_locking)
		{
			$delete_options['Expected'] = array('lock' => array('Exists' => false));
		}

		// Send the delete request to DynamoDB
		$response = $this->_dynamodb->delete_item($delete_options);

		$this->_session_written = $response->isOK();

		return $this->_session_written;
	}

	/**
	 * Performs garbage collection on the sessions stored in the DynamoDB table.
	 *
	 * Part of the standard PHP session handler interface.
	 *
	 * @param integer $maxlifetime (Required) The value of <code>session.gc_maxlifetime</code>. Ignored.
	 * @return boolean Whether or not the operation succeeded.
	 */
	public function garbage_collect($maxlifetime = null)
	{
		// Send a search request to DynamoDB looking for expired sessions
		$response = $this->_dynamodb->scan(array(
			'TableName'  => $this->_table_name,
			'ScanFilter' => array('expires' => array(
				'AttributeValueList' => array($this->_dynamodb->attribute(time())),
				'ComparisonOperator' => AmazonDynamoDB::CONDITION_LESS_THAN,
			)),
		));

		// Delete the expired sessions
		if ($response->isOK())
		{
			$deleted = array();

			// Get the ID of and delete each session that is expired
			foreach ($response->body->Items as $item)
			{
				$id = (string) $item->{$this->_hash_key}->{AmazonDynamoDB::TYPE_STRING};
				$deleted[$id] = $this->destroy($id, true);
			}

			// Return true if all of the expired sessions were deleted
			return (array_sum($deleted) === count($deleted));
		}

		return false;
	}

	/**
	 * Creates a table in DynamoDB for session storage according to provided configuration options.
	 *
	 * Note: Table creation may also be done via the AWS Console, which might make the most sense for this use case.
	 *
	 * @param integer $read_capacity_units (Required) Read capacity units for table throughput.
	 * @param integer $write_capacity_units (Required) Write capacity units for table throughput.
	 * @return boolean Returns <code>true</code> on success.
	 */
	public function create_sessions_table($read_capacity_units = 10, $write_capacity_units = 5)
	{
		$response = $this->_dynamodb->create_table(array(
			'TableName' => $this->_table_name,
			'KeySchema' => array(
				'HashKeyElement' => array(
					'AttributeName' => $this->_hash_key,
					'AttributeType' => AmazonDynamoDB::TYPE_STRING,
				)
			),
			'ProvisionedThroughput' => array(
				'ReadCapacityUnits' => $read_capacity_units,
				'WriteCapacityUnits' => $write_capacity_units,
			)
		));

		return $response->isOK();
	}

	/**
	 * Deletes the session storage table from DynamoDB.
	 *
	 * Note: Table deletion may also be done via the AWS Console, which might make the most sense for this use case.
	 *
	 * @return boolean Returns <code>true</code> on success.
	 */
	public function delete_sessions_table()
	{
		$response = $this->_dynamodb->delete_table(array('TableName' => $this->_table_name));

		return $response->isOK();
	}

	/**
	 * Prefix the session ID with the session name and prepare for DynamoDB usage
	 *
	 * @param string $id (Required) The session ID.
	 * @return array The HashKeyElement value formatted as an array.
	 */
	protected function _id($id)
	{
		return trim($this->_session_name . '_' . $id, '_');
	}

	/**
	 * Acquires a lock on a session in DynamoDB using conditional updates.
	 *
	 * WARNING: There is a <code>while(true);</code> in here.
	 *
	 * @param string $id (Required) The session ID.
	 * @return CFResponse The response from DynamoDB.
	 */
	protected function _lock_and_read($id)
	{
		$now = time();
		$timeout = $now + $this->_max_lock_wait_time;

		do
		{
			// Acquire the lock
			$response = $this->_dynamodb->update_item(array(
				'TableName'        => $this->_table_name,
				'Key'              => array('HashKeyElement' => $this->_dynamodb->attribute($this->_id($id))),
				'AttributeUpdates' => array('lock' => $this->_dynamodb->attribute(1, 'update')),
				'Expected'         => array('lock' => array('Exists' => false)),
				'ReturnValues'     => 'ALL_NEW',
			));

			// If lock succeeds (or times out), exit the loop, otherwise sleep and try again
			if ($response->isOK() || $now >= $timeout)
			{
				return $response;
			}
			else
			{
				usleep(rand($this->_min_lock_retry_utime, $this->_max_lock_retry_utime));

				$now = time();
			}
		}
		while(true);
	}
}

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
 * File: CFStepConfig
 * 	Contains functionality for simplifying Amazon EMR Hadoop steps.
 *
 * Version:
 * 	2010.11.16
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[PHP Developer Center](http://aws.amazon.com/php/)
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CFStepConfig
 * 	Contains functionality for simplifying Amazon EMR Hadoop steps.
 */
class CFStepConfig
{
	/**
	 * Property: config
	 * 	Stores the configuration map.
	 */
	public $config;

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <CFStepConfig>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$config - _array_ (Required) An associative array representing the Hadoop step configuration.
	 *
	 * Returns:
	 * 	`$this` A reference to the current instance.
	 */
	public function __construct($config)
	{
		// Handle Hadoop jar arguments
		if (isset($config['HadoopJarStep']['Args']) && $args = $config['HadoopJarStep']['Args'])
		{
			$config['HadoopJarStep']['Args'] = is_array($args) ? $args : array($args);
		}

		$this->config = $config;
	}

	/**
	 * Method: init()
	 * 	Constructs a new instance of <CFStepConfig>, and allows chaining.
	 *
	 * Access:
	 * 	public static
	 *
	 * Parameters:
	 * 	$config - _array_ (Required) An associative array representing the Hadoop step configuration.
	 *
	 * Returns:
	 * 	`$this` A reference to the current instance.
	 */
	public static function init($config)
	{
		if (version_compare(PHP_VERSION, '5.3.0', '<'))
		{
			throw new Exception('PHP 5.3 or newer is required to instantiate a new class with CLASS::init().');
		}

		$self = get_called_class();
		return new $self($config);
	}

	/**
	 * Method: __toString()
	 * 	Returns a JSON representation of the object when typecast as a string.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_string_ A JSON representation of the object.
	 *
	 * See Also:
	 * 	[PHP Magic Methods](http://www.php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring)
	 */
	public function __toString()
	{
		return json_encode($this->config);
	}

	/**
	 * Method: get_config()
	 * 	Returns the configuration data.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	_array_ The configuration data.
	 */
	public function get_config()
	{
		return $this->config;
	}
}

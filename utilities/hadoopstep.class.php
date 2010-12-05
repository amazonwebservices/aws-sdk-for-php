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
 * File: CFHadoopStep
 * 	Contains a set of pre-built Amazon EMR Hadoop steps.
 *
 * Version:
 * 	2010.11.16
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for more information.
 *
 * See Also:
 * 	[PHP Developer Center](http://aws.amazon.com/php/)
 * 	[Apache Hadoop](http://hadoop.apache.org)
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CFHadoopStep
 * 	Contains a set of pre-built Amazon EMR Hadoop steps.
 */
class CFHadoopStep
{

	/*%******************************************************************************************%*/
	// CORE METHODS

	/**
	 * Method: script_runner()
	 * 	Runs a specified script on the master node of your cluster.
	 *
	 * Access:
	 *	protected static
	 *
	 * Parameters:
	 *	$script - _string_ (Required) The script to run with `script-runner.jar`.
	 *	$args - _array_ (Optional) An indexed array of arguments to pass to the script.
	 *
	 * Returns:
	 *	_array_ A standard array that is intended to be passed into a <CFStepConfig> object.
	 */
	protected static function script_runner($script, $args = null)
	{
		if (!$args) $args = array();
		array_unshift($args, $script);

		return array(
			'Jar' => 's3://us-east-1.elasticmapreduce/libs/script-runner/script-runner.jar',
			'Args' => $args
		);
	}

	/**
	 * Method: hive_pig_script()
	 * 	Prepares a Hive or Pig script before passing it to the script runner.
	 *
	 * Access:
	 *	protected static
	 *
	 * Parameters:
	 *	$type - _string_ (Required) The type of script to run. [Allowed values: `hive`, `pig`].
	 *	$args - _array_ (Optional) An indexed array of arguments to pass to the script.
	 *
	 * Returns:
	 *	_array_ A standard array that is intended to be passed into a <CFStepConfig> object.
	 *
	 * See Also:
	 * 	[Apache Hive](http://hive.apache.org)
	 * 	[Apache Pig](http://pig.apache.org)
	 */
	protected static function hive_pig_script($type, $args = null)
	{
		if (!$args) $args = array();
		$args = is_array($args) ? $args : array($args);
		$args = array_merge(array('--base-path', 's3://us-east-1.elasticmapreduce/libs/' . $type . '/'), $args);

        return self::script_runner('s3://us-east-1.elasticmapreduce/libs/' . $type . '/' . $type . '-script', $args);
	}


	/*%******************************************************************************************%*/
	// USER-FACING METHODS

	/**
	 * Method: enable_debugging()
	 * 	When ran as the first step in your job flow, enables the Hadoop debugging UI in the
	 * 	AWS Management Console.
	 *
	 * Access:
	 *	public static
	 *
	 * Returns:
	 *	_array_ A standard array that is intended to be passed into a <CFStepConfig> object.
	 */
	public static function enable_debugging()
	{
		return self::script_runner('s3://us-east-1.elasticmapreduce/libs/state-pusher/0.1/fetch');
	}

	/**
	 * Method: install_hive()
	 * 	Step that installs Hive on your job flow.
	 *
	 * Access:
	 *	public static
	 *
	 * Returns:
	 *	_array_ A standard array that is intended to be passed into a <CFStepConfig> object.
	 *
	 * See Also:
	 * 	[Apache Hive](http://hive.apache.org)
	 */
	public static function install_hive()
	{
		return self::hive_pig_script('hive', '--install-hive');
	}

	/**
	 * Method: run_hive_script()
	 * 	Step that runs a Hive script on your job flow.
	 *
	 * Access:
	 *	public static
	 *
	 * Parameters:
	 *	$script - _string_ (Required) The script to run with `script-runner.jar`.
	 *	$args - _array_ (Optional) An indexed array of arguments to pass to the script.
	 *
	 * Returns:
	 *	_array_ A standard array that is intended to be passed into a <CFStepConfig> object.
	 *
	 * See Also:
	 * 	[Apache Hive](http://hive.apache.org)
	 */
	public static function run_hive_script($script, $args = null)
	{
		if (!$args) $args = array();
		$args = is_array($args) ? $args : array($args);
		$args = array_merge(array('--run-hive-script', '--args', '-f', $script), $args);

        return self::hive_pig_script('hive', $args);
	}

	/**
	 * Method: install_pig()
	 * 	Step that installs Pig on your job flow.
	 *
	 * Access:
	 *	public static
	 *
	 * Returns:
	 *	_array_ A standard array that is intended to be passed into a <CFStepConfig> object.
	 *
	 * See Also:
	 * 	[Apache Pig](http://pig.apache.org)
	 */
	public static function install_pig()
	{
		return self::hive_pig_script('pig', '--install-pig');
	}

	/**
	 * Method: run_pig_script()
	 * 	Step that runs a Pig script on your job flow.
	 *
	 * Access:
	 *	public static
	 *
	 * Parameters:
	 *	$script - _string_ (Required) The script to run with `script-runner.jar`.
	 *	$args - _array_ (Optional) An indexed array of arguments to pass to the script.
	 *
	 * Returns:
	 *	_array_ A standard array that is intended to be passed into a <CFStepConfig> object.
	 *
	 * See Also:
	 * 	[Apache Pig](http://pig.apache.org)
	 */
	public static function run_pig_script($script, $args = null)
	{
		if (!$args) $args = array();
		$args = is_array($args) ? $args : array($args);
		$args = array_merge(array('--run-pig-script', '--args', '-f', $script), $args);

        return self::hive_pig_script('pig', $args);
	}
}

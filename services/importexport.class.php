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
 * File: AmazonImportExport
 * 	 *
 * 	AWS Import/Export accelerates transferring large amounts of data between the AWS cloud and portable
 * 	storage devices that you mail to us. AWS Import/Export transfers data directly onto and off of your
 * 	storage devices using Amazon's high-speed internal network and bypassing the Internet. For large
 * 	data sets, AWS Import/Export is often faster than Internet transfer and more cost effective than
 * 	upgrading your connectivity.
 *
 * Version:
 * 	Fri Dec 03 16:26:16 PST 2010
 *
 * License and Copyright:
 * 	See the included NOTICE.md file for complete information.
 *
 * See Also:
 * 	[Amazon Import/Export Service](http://aws.amazon.com/importexport/)
 * 	[Amazon Import/Export Service documentation](http://aws.amazon.com/documentation/importexport/)
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Exception: ImportExport_Exception
 * 	Default ImportExport Exception.
 */
class ImportExport_Exception extends Exception {}


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonImportExport
 * 	Container for all service-related methods.
 */
class AmazonImportExport extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Constant: DEFAULT_URL
	 * 	Specify the default queue URL.
	 */
	const DEFAULT_URL = 'importexport.amazonaws.com';



	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	Constructs a new instance of <AmazonImportExport>.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	$key - _string_ (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * 	$secret_key - _string_ (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 *
	 * Returns:
	 * 	_boolean_ false if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->api_version = '2010-06-01';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			throw new ImportExport_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			throw new ImportExport_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 * Method: create_job()
	 * 	This operation initiates the process of scheduling an upload or download of your data. You include
	 * 	in the request a manifest that describes the data transfer specifics. The response to the request
	 * 	includes a job ID, which you can use in other operations, a signature that you use to identify your
	 * 	storage device, and the address where you should ship your storage device.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$job_type - _string_ (Required) Specifies whether the job to initiate is an import or export job. [Allowed values: `Import`, `Export`]
	 *	$manifest - _string_ (Required) The UTF-8 encoded text of the manifest file.
	 *	$validate_only - _boolean_ (Required) Validate the manifest and parameter values in the request but do not actually create a job.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	ManifestAddendum - _string_ (Optional) For internal use only.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_job($job_type, $manifest, $validate_only, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['JobType'] = $job_type;
		$opt['Manifest'] = $manifest;
		$opt['ValidateOnly'] = $validate_only;

		return $this->authenticate('CreateJob', $opt, $this->hostname);
	}

	/**
	 * Method: cancel_job()
	 * 	This operation cancels a specified job. Only the job owner can cancel it. The operation fails if the
	 * 	job has already started or is complete.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$job_id - _string_ (Required) A unique identifier which refers to a particular job.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function cancel_job($job_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['JobId'] = $job_id;

		return $this->authenticate('CancelJob', $opt, $this->hostname);
	}

	/**
	 * Method: get_status()
	 * 	This operation returns information about a job, including where the job is in the processing
	 * 	pipeline, the status of the results, and the signature value associated with the job. You can only
	 * 	return information about jobs you own.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$job_id - _string_ (Required) A unique identifier which refers to a particular job.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_status($job_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['JobId'] = $job_id;

		return $this->authenticate('GetStatus', $opt, $this->hostname);
	}

	/**
	 * Method: list_jobs()
	 * 	This operation returns the jobs associated with the requester. AWS Import/Export lists the jobs in
	 * 	reverse chronological order based on the date of creation. For example if Job Test1 was created
	 * 	2009Dec30 and Test2 was created 2010Feb05, the ListJobs operation would return Test2 followed by
	 * 	Test1.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	MaxJobs - _integer_ (Optional) Sets the maximum number of jobs returned in the response. If there are additional jobs that were not returned because MaxJobs was exceeded, the response contains <IsTruncated>true</IsTruncated>. To return the additional jobs, see Marker.
	 *	Marker - _string_ (Optional) Specifies the JOBID to start after when listing the jobs created with your account. AWS Import/Export lists your jobs in reverse chronological order. See MaxJobs.
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function list_jobs($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListJobs', $opt, $this->hostname);
	}

	/**
	 * Method: update_job()
	 * 	You use this operation to change the parameters specified in the original manifest file by supplying
	 * 	a new manifest file. The manifest file attached to this request replaces the original manifest file.
	 * 	You can only use the operation after a CreateJob request but before the data transfer starts and you
	 * 	can only use it on jobs you own.
	 *
	 * Access:
	 *	public
	 *
	 * Parameters:
	 *	$job_id - _string_ (Required) A unique identifier which refers to a particular job.
	 *	$manifest - _string_ (Required) The UTF-8 encoded text of the manifest file.
	 *	$job_type - _string_ (Required) Specifies whether the job to initiate is an import or export job. [Allowed values: `Import`, `Export`]
	 *	$validate_only - _boolean_ (Required) Validate the manifest and parameter values in the request but do not actually create a job.
	 *	$opt - _array_ (Optional) An associative array of parameters that can have the keys listed in the following section.
	 *
	 * Keys for the $opt parameter:
	 *	returnCurlHandle - _boolean_ (Optional) A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.
	 *
	 * Returns:
	 *	_CFResponse_ A <CFResponse> object containing a parsed HTTP response.
	 */
	public function update_job($job_id, $manifest, $job_type, $validate_only, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['JobId'] = $job_id;
		$opt['Manifest'] = $manifest;
		$opt['JobType'] = $job_type;
		$opt['ValidateOnly'] = $validate_only;

		return $this->authenticate('UpdateJob', $opt, $this->hostname);
	}
}


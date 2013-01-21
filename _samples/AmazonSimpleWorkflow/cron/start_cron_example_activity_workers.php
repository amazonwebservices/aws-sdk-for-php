<?php
/*
 * Copyright 2012-2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'sdk.class.php';
require_once 'BasicActivityWorker.php' ;
require_once 'cron_example_utils.php' ;

$swf = new AmazonSWF();
$domain = 'myDomain';

register_domain($swf, $domain, 'my domain', 7);
register_activity_type($swf, $domain, BasicActivityWorker::ACTIVITY_NAME, BasicActivityWorker::ACTIVITY_VERSION, 'Does some work');

$activity_task_list = 'activityTaskList';
$activity_worker = new BasicActivityWorker($swf, $domain, $activity_task_list);

echo "Starting activity worker polling\n";
$activity_worker->start();

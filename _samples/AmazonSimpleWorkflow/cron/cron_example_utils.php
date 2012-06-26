<?php
/*
 * Copyright 2012 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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

function register_domain(AmazonSWF $swf, $name, $description, $retention_period_in_days) {
    $opts = array(
        'description' => $description,
        'name' => $name,
        'workflowExecutionRetentionPeriodInDays' => (string) $retention_period_in_days
    );

    $response = $swf->registerDomain($opts);

    if ($response->isOK()) {
        echo 'Domain ' . json_encode($opts) . " registered\n";
    } else {
        // A real application may want to handle errors during domain registration,
        // but if the domain already exists, it's safe to ignore that error.
        print_r($response->body);
    }
}

function register_workflow_type(AmazonSWF $swf, $domain, $name, $version, $description) {
    $opts = array(
        'domain' => $domain,
        'name' => $name,
        'version' => $version,
        'description' => $description
    );
    
    $response = $swf->registerWorkflowType($opts);

    if ($response->isOK()) {
        echo 'Workflow ' . json_encode($opts) . " registered\n";
    } else {
        // A real application may want to handle errors during type registration,
        // but if the type already exists, it's safe to ignore that error.
        print_r($response->body);
    }
}

function register_activity_type(AmazonSWF $swf, $domain, $name, $version, $description) {
    $opts = array(
        'domain' => $domain,
        'name' => $name,
        'version' => $version,
        'description' => $description
    );
    
    $response = $swf->registerActivityType($opts);

    if ($response->isOK()) {
        echo 'Activity ' . json_encode($opts) . " registered\n";
    } else {
        // A real application may want to handle errors during type registration,
        // but if the type already exists, it's safe to ignore that error.
        print_r($response->body);
    }
}

function wrap_decision_opts_as_decision($decision_type, $decision_opts) {
    return array(
        'decisionType' => $decision_type,
        strtolower(substr($decision_type, 0, 1)) . substr($decision_type, 1) . 'DecisionAttributes' => $decision_opts
    );
}

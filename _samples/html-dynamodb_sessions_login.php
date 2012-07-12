<?php
/*
 * Copyright 2010-2012 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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

/*
	PREREQUISITES:
	In order to run this sample, I'll assume a few things:

	* You already have a valid Amazon Web Services developer account, and are
	  signed up to use Amazon DynamoDB <http://aws.amazon.com/simpledb>.

	* You already understand the fundamentals of object-oriented PHP.

	* You've verified that your PHP environment passes the SDK Compatibility Test.

	* You've already added your credentials to your config.inc.php file, as per the
	  instructions in the Getting Started Guide.

	* You've already created a table in Amazon DynamoDB called "sessions-test" with
	  a string primary key called "id".

	TO RUN:
	* Run this file on your web server by loading it in your browser. It will
	  generate HTML output.
*/

// Include the SDK
require_once dirname(dirname(__FILE__)) . '/sdk.class.php';

// Instantiate a DynamoDB client
$dynamodb = new AmazonDynamoDB();

// Instantiate, configure, and register the session handler
$session_handler = $dynamodb->register_session_handler(array(
	'table_name'       => 'sessions-test',
	'lifetime'         => 3600,
));

// Open the session
session_start();

// If the logout flag is set, do a logout instead
if (isset($_GET['logout']))
{
	// Destroy the session
	session_destroy();

	// Refresh this page to show the login form
	header('Location: html-dynamodb_sessions_login.php');
	exit(0);
}

// Simulate authentication by checking for username and password
if (isset($_POST['username']) && isset($_POST['password']))
{
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password))
	{
		// Simulate logging in the user by storing their info in the session
		$_SESSION['username'] = $username;
		$_SESSION['views'] = 0;
	}
}

// Increment page views for logged in users
if (isset($_SESSION['username']) && isset($_SESSION['views']))
{
	$_SESSION['views']++;
}

// Write the session (Doing this early helps prevent latency when session locking is enabled)
session_commit();

// Generate the HTML for the page
header("Content-type: text/html; charset=utf-8");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PHP DynamoDB Session Handler</title>
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css"></style>
  </head>

  <body>

    <div class="container">

      <br>

      <div class="row">
        <div class="span12">
          <h1>DynamoDB Session Handler Demo for PHP</h1>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="span12">
          <?php if (isset($_SESSION['username'])): ?>
          <div class="well">
            <h3>Hi, <?php echo $_SESSION['username']; ?>!</h3>
            <p>You are logged in! You have viewed this page <strong><?php echo $_SESSION['views']; ?></strong> time(s) since you logged in.</p>
            <br>
            <div class="button-group">
              <a class="btn btn-large btn-success" href="html-dynamodb_sessions_login.php"><i class="icon-refresh icon-white"></i> Refresh</a>
              <a class="btn btn-large btn-danger" href="html-dynamodb_sessions_login.php?logout"><i class="icon-lock icon-white"></i> Logout</a>
            </div>
          </div>
          <?php else: ?>
          <form action="html-dynamodb_sessions_login.php" method="post" class="form-horizontal well">
            <fieldset>
              <legend>Login</legend>
              <div class="control-group">
                <label class="control-label" for="username">Username</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" id="username" name="username">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                  <input type="password" class="input-xlarge" id="password" name="password">
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-large btn-primary"><i class="icon-user icon-white"></i> Login</button>
              </div>
            </fieldset>
          </form>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </body>
</html>

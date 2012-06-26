# OVERVIEW

This sample shows a workflow that can be used to run tasks periodically.

# PREREQUISITES

1. You must have a valid Amazon Web Services developer account.
2. Requires the AWS SDK for PHP. For more information on the AWS SDK for PHP, see http://aws.amazon.com/sdkforphp.
3. You must be signed up for Amazon Simple Workflow Service (SWF). For more information, see http://aws.amazon.com/swf.

# RUNNING THE SAMPLE

* Create the **Samples** domain
    1. Go to the SWF Management Console (https://console.aws.amazon.com/swf/home).

    2. Follow the on-screen instructions to log in.

    3. Click Manage Domains and register a new domain with the name Samples.

* To run this sample, you need to execute three scripts from the command line in separate terminal/console windows
    1. Start the decider, which periodically schedules an activity task, using the command: **php -f start_cron_example_workflow_workers.php**
Once successfully started, the decider will start polling for decision tasks.  

    2. Start the activity worker to perform the tasks using the command: **php -f start_cron_example_activity_workers.php**
Once successfully started, the activity worker will start polling for activity tasks.  	  

    3. Start a workflow execution using the command: **php -f start_cron_example_workflow.php**
After an execution has been started, the decider and activity worker will start processing tasks. 

The decider will print a message to the console each time it completes a decision task and the activity worker will print a message to the console each time it completes an activity task.    

Note that the start_cron_example_workflow.php script will exit quickly while the decider and activity worker scripts keep running until you manually terminate them.

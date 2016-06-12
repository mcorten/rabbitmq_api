<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use mcorten87\rabbitmq_api\jobs\JobBaseCreateVirtualHost;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\MqManagementFactory;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use mcorten87\rabbitmq_api\services\MqManagermentService;

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
        case 2: // Declaration of  errors <- they are equal to the base... stop complaining
            return strpos($errstr, 'Declaration of') !== false;
            break;
    }
}

// set to the user defined error handler
$old_error_handler = set_error_handler("myErrorHandler");


$url = new Url('http://192.168.33.11:15672/api/');
$user = new User('admin');
$password = new Password('admin');

$factory = new MqManagementFactory();
$config = new MqManagementConfig($user, $password, $url);
$mqManagerment = new MqManagermentService($factory, $config);

$client = new Client();

$jobService = $factory->getJobService();

//// list vhosts
//$job = $factory->getJobListVirtualHost();
//var_dump($jobService->execute($job)->getBody());
////
//// create vhost
//$job = $factory->getJobCreateVirtualHost(new VirtualHost('/foo/test'));
//var_dump($jobService->execute($job)->getBody());
////
////// list vhosts
//$job = $factory->getJobListVirtualHost();
//var_dump($jobService->execute($job)->getBody());
////
//$job = $factory->getJobListVirtualHost(new VirtualHost('/'));
//var_dump($jobService->execute($job)->getBody());
//
////
//// list specific vhost
//$job = $factory->getJobListVirtualHost(new VirtualHost('/foo/test'));
//var_dump($jobService->execute($job)->getBody());
//
//// delete vhost
//$job = $factory->getJobDeleteVirtualHost(new VirtualHost('/foo/test'));
//var_dump($jobService->execute($job)->getBody());
//
//// list vhosts
//$job = $factory->getJobListVirtualHost();
//var_dump($jobService->execute($job)->getBody());
////
////
////// queues
$job = $factory->getJobCreateQueue(new VirtualHost('/example/'),new QueueName('test'));
$job->setDurable(true);
$job->addArgument(new QueueArgument(QueueArgument::MAX_PRIORITY, 10));
var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobListQueues();
//var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobListQueues(new VirtualHost('/example/'));
//var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobListQueue(new VirtualHost('/example/'),new QueueName('test'));
//var_dump($jobService->execute($job)->getBody());
////
////
////
//$job = $factory->getJobDeleteQueue(new VirtualHost('/example/'),new QueueName('test'));
//var_dump($jobService->execute($job)->getBody());
//
//
//$job = $factory->getJobListUser();
//var_dump($jobService->execute($job)->getBody());
//
//
//$job = $factory->getJobCreateUser(new User('mathijs'), new UserTag(UserTag::MANAGEMENT), new Password('test'));
//$job->addUserTag(new UserTag(UserTag::MONITORING));
//var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobListUser(new User('mathijs'));
//$userListResult = $jobService->execute($job);
//$userListResult = json_decode($userListResult->getBody());
//var_dump($userListResult);
//
//$job = $factory->getJobCreateUser(new User("mathijs"), new UserTag(UserTag::MANAGEMENT), null, new PasswordHash($userListResult->password_hash));
//$job->addUserTag(new UserTag(UserTag::MONITORING));
//$job->addUserTag(new UserTag(UserTag::ADMINISTRATOR));
//var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobListUser(new User('mathijs'));
//var_dump($jobService->execute($job)->getBody());

//$job = $factory->getJobListPermission();
//var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobListVirtualHostPermission(new VirtualHost('/example/'));
//var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobListUserPermission(new User('admin'));
//var_dump($jobService->execute($job)->getBody());

//$job = $factory->getJobCreatePermission(new VirtualHost('/'), new User('admin'));
//var_dump($jobService->execute($job)->getBody());
//
//$job = $factory->getJobDeletePermission(new VirtualHost('/'), new User('admin'));
//var_dump($jobService->execute($job)->getBody());

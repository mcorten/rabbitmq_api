<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobQueueListTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function test_dependencyInjection() {
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName('test');

        $job = new JobQueueList($virtualHost, $queueName);


        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($queueName, $job->getQueueName());
    }
}

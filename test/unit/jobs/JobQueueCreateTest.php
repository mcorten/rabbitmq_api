<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobQueueCreateTest extends TestCase
{

    public function providerDependencyInjection() {
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName("test");

        $job = new JobQueueCreate($virtualHost, $queueName);

        return [
            [$job, $virtualHost, $queueName],
        ];
    }

    /**
     * Tests if the dependency injection in the constructor works
     * @dataProvider providerDependencyInjection
     *
     * @param JobQueueCreate $job
     * @param VirtualHost $virtualHost
     * @param QueueName $queueName
     */
    public function testDependencyInjection($job, $virtualHost, $queueName) {
        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($queueName, $job->getQueueName());
    }

    public function providerAddArguments() {
        $argument1 = new QueueArgument(QueueArgument::MESSAGE_TTL, 1000);
        $argument2 = new QueueArgument(QueueArgument::MESSAGE_TTL, 10);


        return [
            [$argument1, $argument2],
        ];
    }

    /**
     * Tests if an argument can be added
     *
     * @dataProvider providerAddArguments
     */
    public function testAddArguments($argument1, $argument2) {
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName("test");

        $job = new JobQueueCreate($virtualHost, $queueName);

        $job->addArgument($argument1);
        $job->addArgument($argument2);
        $this->assertEquals($argument1, $job->getArguments()[0]);
        $this->assertEquals($argument2, $job->getArguments()[1]);
    }

    public function testSettersAndGetters() {
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName("test");

        $job = new JobQueueCreate($virtualHost, $queueName);

        $this->assertEquals(false, $job->isAutoDelete());
        $job->setAutoDelete(true);
        $this->assertEquals(true, $job->isAutoDelete());

        $this->assertEquals(true, $job->isDurable());
        $job->setDurable(false);
        $this->assertEquals(false, $job->isDurable());
    }
}

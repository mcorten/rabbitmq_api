<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 12-3-17
 * Time: 11:33
 */

namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobBindingListQueue;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobBindingListQueueTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection()
    {
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName('/test/');

        $job = new JobBindingListQueue($virtualHost, $queueName);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($queueName, $job->getQueueName());
    }
}

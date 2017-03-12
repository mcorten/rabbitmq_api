<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 12-3-17
 * Time: 11:24
 */

namespace mcorten87\rabbitmq_api\test\unit\jobs;


use mcorten87\rabbitmq_api\jobs\JobBindingListBetweenQueueAndExchange;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobBindingListBetweenQueueAndExchangeTest extends TestCase
{
    /**
    * Tests if the dependency injection in the constructor works
    */
    public function testDependencyInjection()
    {
        $virtualHost = new VirtualHost('test');
        $queueName = new QueueName('/test/');
        $exchangeName = new ExchangeName('/test');

        $job = new JobBindingListBetweenQueueAndExchange($virtualHost, $queueName, $exchangeName);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($queueName, $job->getQueueName());
        $this->assertEquals($exchangeName, $job->getExchangeName());
    }
}
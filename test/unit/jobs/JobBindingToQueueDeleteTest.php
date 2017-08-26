<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 12-3-17
 * Time: 11:33
 */

namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobBindingToQueueDelete;
use mcorten87\rabbitmq_api\objects\DestinationType;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobBindingToQueueDeleteTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection()
    {
        $virtualHost = new VirtualHost('/test/');
        $queueNameDestination = new QueueName('/test_source/');
        $exchangeNameSource = new ExchangeName('/test_destination/');

        $job = new  JobBindingToQueueDelete(
            $virtualHost,
            $queueNameDestination,
            $exchangeNameSource
        );

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($queueNameDestination, $job->getQueueName());
        $this->assertEquals($exchangeNameSource, $job->getExchangeName());
        $this->assertEquals(DestinationType::QUEUE, $job->getDestinationType());
        $this->assertEquals('', (string)$job->getRoutingKey()); // default routing key
    }

    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjectionRoutingKey()
    {
        $virtualHost = new VirtualHost('/test/');
        $queueNameDestination = new QueueName('/test_source/');
        $exchangeNameSource = new ExchangeName('/test_destination/');
        $routingKey = new RoutingKey('test');


        $job = new  JobBindingToQueueDelete(
            $virtualHost,
            $queueNameDestination,
            $exchangeNameSource,
            $routingKey
        );

        $this->assertEquals($routingKey, $job->getRoutingKey());
    }
}

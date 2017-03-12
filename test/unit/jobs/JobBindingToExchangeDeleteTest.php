<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 12-3-17
 * Time: 11:33
 */

namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobBindingToExchangeDelete;
use mcorten87\rabbitmq_api\objects\DestinationType;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobBindingToExchangeDeleteTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection()
    {
        $virtualHost = new VirtualHost('/test/');
        $exchangeNameSource = new ExchangeName('/test_source/');
        $exchangeNameDestination = new ExchangeName('/test_destination/');

        $job = new JobBindingToExchangeDelete(
            $virtualHost,
            $exchangeNameSource,
            $exchangeNameDestination
        );

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($exchangeNameSource, $job->getExchangeName());
        $this->assertEquals($exchangeNameDestination, $job->getToExchange());
        $this->assertEquals(DestinationType::EXCHANGE, $job->getDestinationType());
        $this->assertEquals('', (string)$job->getRoutingKey()); // default routing key
    }

    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjectionRoutingKey()
    {
        $virtualHost = new VirtualHost('/test/');
        $exchangeNameSource = new ExchangeName('/test_source/');
        $exchangeNameDestination = new ExchangeName('/test_destination/');
        $routingKey = new RoutingKey('test');

        $job = new JobBindingToExchangeDelete(
            $virtualHost,
            $exchangeNameSource,
            $exchangeNameDestination,
            $routingKey
        );

        $this->assertEquals($routingKey, $job->getRoutingKey());
    }
}

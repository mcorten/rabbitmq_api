<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobExchangePublish;
use mcorten87\rabbitmq_api\objects\DeliveryMode;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\Message;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobExchangePublishTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection()
    {

        $virtualHost = new VirtualHost('/test/');
        $exchangeName = new ExchangeName('/test/');
        $message = new Message('Hallo');
        $deliveryMode = new DeliveryMode(DeliveryMode::NON_PERSISTENT);

        $job = new JobExchangePublish($virtualHost, $exchangeName, $message, $deliveryMode);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($exchangeName, $job->getExchangeName());
        $this->assertEquals($message, $job->getMessage());
        $this->assertEquals($deliveryMode, $job->getDeliveryMode());
        $this->assertEquals('', (string)$job->getRoutingKey());
    }

    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjectionRoutingKey()
    {

        $virtualHost = new VirtualHost('/test/');
        $exchangeName = new ExchangeName('/test/');
        $message = new Message('Hallo');
        $deliveryMode = new DeliveryMode(DeliveryMode::NON_PERSISTENT);
        $routingKey = new RoutingKey('hallo');

        $job = new JobExchangePublish($virtualHost, $exchangeName, $message, $deliveryMode, $routingKey);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($exchangeName, $job->getExchangeName());
        $this->assertEquals($message, $job->getMessage());
        $this->assertEquals($deliveryMode, $job->getDeliveryMode());
        $this->assertEquals($routingKey, $job->getRoutingKey());
    }
}

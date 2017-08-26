<?php

use mcorten87\rabbitmq_api\jobs\JobBindingListAll;
use mcorten87\rabbitmq_api\jobs\JobBindingListBetweenQueueAndExchange;
use mcorten87\rabbitmq_api\jobs\JobBindingListExchange;
use mcorten87\rabbitmq_api\jobs\JobBindingListQueue;
use mcorten87\rabbitmq_api\jobs\JobBindingListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobBindingToQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobBindingToQueueDelete;
use mcorten87\rabbitmq_api\jobs\JobExchangeCreate;
use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\MqManagementFactory;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
class BindingExchangeToQueueTest extends TestCase
{
    private static $virtualHost;
    private static $queueName;
    private static $exchangeName;
    private static $routingKey;

    /** @var  MqManagementFactory $factory */
    private $factory;

    public static function setUpBeforeClass()
    {
        $jobService = Bootstrap::getFactory()->getJobService();

        // bootstrap the virtual host
        self::$queueName = new QueueName('queue-integration-test');
        self::$exchangeName = new ExchangeName('exchange-integration-test');
        self::$virtualHost = new VirtualHost(sprintf('/integration-test/%1$s/%2$d/', __CLASS__, time()));
        self::$routingKey = new RoutingKey('routing-integration-test');

        $job = new JobVirtualHostCreate(self::$virtualHost);
        $response = $jobService->execute($job);
        self::assertTrue($response->isSuccess());

        // setup virtualhost permissions
        $job = new JobPermissionCreate(self::$virtualHost, Bootstrap::getConfig()->getUser());
        $response = $jobService->execute($job);
        self::assertTrue($response->isSuccess());

        // setup exchange
        $job = new JobExchangeCreate(self::$virtualHost, self::$exchangeName);
        $response = $jobService->execute($job);
        self::assertTrue($response->isSuccess());

        // setup queue
        $job = new JobQueueCreate(self::$virtualHost, self::$queueName);
        $response = $jobService->execute($job);
        self::assertTrue($response->isSuccess());
    }

    public static function tearDownAfterClass()
    {
        $job = new JobVirtualHostDelete(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        self::assertTrue($response->isSuccess());
    }


    private function listBindings()
    {
        $job = new JobBindingListBetweenQueueAndExchange(self::$virtualHost, self::$queueName, self::$exchangeName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        return $response;
    }


    public function testNoBindingsShouldExist()
    {
        $response = $this->listBindings();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertTrue(empty($body));
    }

    public function testCreateBinding()
    {
        $job = new JobBindingToQueueCreate(self::$virtualHost, self::$queueName, self::$exchangeName, self::$routingKey);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $response = $this->listBindings();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertFalse(empty($body));

        $this->assertEquals((string) self::$exchangeName, $body[0]->source);
        $this->assertEquals((string) self::$queueName, $body[0]->destination);
        $this->assertEquals((string) self::$routingKey, $body[0]->routing_key);
    }

    public function testListBindingsOnExchange()
    {
        $job = new JobBindingListExchange(self::$virtualHost, self::$exchangeName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $response = $this->listBindings();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertFalse(empty($body));

        $this->assertEquals((string) self::$exchangeName, $body[0]->source);
        $this->assertEquals((string) self::$queueName, $body[0]->destination);
        $this->assertEquals((string) self::$routingKey, $body[0]->routing_key);
    }

    public function testListBindingsOnQueue()
    {
        $job = new JobBindingListQueue(self::$virtualHost, self::$queueName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $response = $this->listBindings();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertFalse(empty($body));

        $this->assertEquals((string) self::$exchangeName, $body[0]->source);
        $this->assertEquals((string) self::$queueName, $body[0]->destination);
        $this->assertEquals((string) self::$routingKey, $body[0]->routing_key);
    }

    public function testListAllBindings()
    {
        $job = new JobBindingListAll(self::$virtualHost, self::$queueName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $response = $this->listBindings();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertFalse(empty($body));

        $this->assertEquals((string) self::$exchangeName, $body[0]->source);
        $this->assertEquals((string) self::$queueName, $body[0]->destination);
        $this->assertEquals((string) self::$routingKey, $body[0]->routing_key);
    }

    public function testListBindingsOnVirtualHost()
    {
        $job = new JobBindingListVirtualHost(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $response = $this->listBindings();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertFalse(empty($body));

        $this->assertEquals((string) self::$exchangeName, $body[0]->source);
        $this->assertEquals((string) self::$queueName, $body[0]->destination);
        $this->assertEquals((string) self::$routingKey, $body[0]->routing_key);
    }

    public function testDeleteBinding()
    {
        $job = new JobBindingToQueueDelete(self::$virtualHost, self::$queueName, self::$exchangeName, self::$routingKey);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $response = $this->listBindings();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertTrue(empty($body));
    }
}

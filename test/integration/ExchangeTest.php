<?php

use mcorten87\rabbitmq_api\jobs\JobBindingToQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobExchangeCreate;
use mcorten87\rabbitmq_api\jobs\JobExchangeDelete;
use mcorten87\rabbitmq_api\jobs\JobExchangeList;
use mcorten87\rabbitmq_api\jobs\JobExchangeListAll;
use mcorten87\rabbitmq_api\jobs\JobExchangeListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobExchangePublish;
use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\objects\DeliveryMode;
use mcorten87\rabbitmq_api\objects\ExchangeArgument;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\Message;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
class ExchangeTest extends TestCase
{
    private static $exchangeName;
    private static $virtualHost;

    public static function setUpBeforeClass()
    {
        $jobService = Bootstrap::getFactory()->getJobService();

        // bootstrap the virtual host
        self::$exchangeName = new ExchangeName('integration-test');
        self::$virtualHost = new VirtualHost(sprintf('/integration-test/%1$s/%2$d/', __CLASS__, time()));

        $job = new JobVirtualHostCreate(self::$virtualHost);
        $response = $jobService->execute($job);
        self::assertTrue($response->isSuccess());

        // setup virtualhost permissions
        $job = new JobPermissionCreate(self::$virtualHost, Bootstrap::getConfig()->getUser());
        $response = $jobService->execute($job);
        self::assertTrue($response->isSuccess());
    }

    public static function tearDownAfterClass()
    {
        $job = new JobVirtualHostDelete(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        self::assertTrue($response->isSuccess());
    }

    public function testListExchangesEmpty()
    {
        $job = new JobExchangeList(self::$virtualHost, self::$exchangeName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertFalse($response->isSuccess());
    }

    public function testCreateBasicExchange()
    {
        $job = new JobExchangeCreate(self::$virtualHost,self::$exchangeName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());
    }

    public function testCreateExchangeWithArguments()
    {
        $exchangeName = new ExchangeName(((string)self::$exchangeName).'-with-arguments');

        $job = new JobExchangeCreate(self::$virtualHost,$exchangeName);
        $job->addArgument(new ExchangeArgument(ExchangeArgument::ALTERNATE_EXCHAGE, self::$exchangeName));
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());
    }

    /**
     * Tests if we can list the just created queue
     */
    public function testListExchanges()
    {
        $job = new JobExchangeList(self::$virtualHost,self::$exchangeName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());
    }


    public function testExchangePublish()
    {
        $queues = [
            new QueueName("test publish 1"),
            new QueueName("test publish 2"),
            new QueueName("test publish 3"),
        ];

        $message = new Message("test integration tests");
        $deliveryMode = new DeliveryMode(DeliveryMode::PERSISTENT);

        // create all the queues and create a binding form the exchange to the queue so we can test if the message actually arrives in the queues
        foreach ($queues as $queue) {
            $job = new JobQueueCreate(self::$virtualHost, $queue);
            $response = Bootstrap::getFactory()->getJobService()->execute($job);
            $this->assertTrue($response->isSuccess());

            // create a binding to the new queue so messages get routed
            $job = new JobBindingToQueueCreate(self::$virtualHost, $queue, self::$exchangeName);
            $response = Bootstrap::getFactory()->getJobService()->execute($job);
            $this->assertTrue($response->isSuccess());
        }

        $job = new JobExchangePublish(self::$virtualHost, self::$exchangeName, $message, $deliveryMode);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        foreach ($queues as $queue) {
            $job = new JobQueueList(self::$virtualHost, $queue);
            $response = Bootstrap::getFactory()->getJobService()->execute($job);
            $this->assertTrue($response->isSuccess());
            $this->assertEquals(1, (int)$response->getBody()->message_stats->publish);
        }

    }



    public function testLisExchangeOnVirtualHost()
    {
        $job = new JobExchangeListVirtualHost(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(is_array($body));
        $this->assertGreaterThanOrEqual(1, $body);

        $found = false;
        foreach ($body as $exchange) {
            if ($exchange->name === (string)self::$exchangeName && $exchange->vhost === (string)self::$virtualHost) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found);
    }

    public function testListALl()
    {
        $job = new JobExchangeListAll();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(is_array($body));
        $this->assertGreaterThanOrEqual(1, $body);

        $found = false;
        foreach ($body as $exchange) {
            if ($exchange->name === (string)self::$exchangeName && $exchange->vhost === (string)self::$virtualHost) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found);
    }

    public function testExchangeDelete()
    {
        $job = new JobExchangeDelete(self::$virtualHost,self::$exchangeName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $job = new JobExchangeList(self::$virtualHost, self::$exchangeName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertFalse($response->isSuccess());
    }

}

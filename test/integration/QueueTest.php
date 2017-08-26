<?php

use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\jobs\JobQueueListAll;
use mcorten87\rabbitmq_api\jobs\JobQueueListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\MqManagementFactory;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
class QueueTest extends TestCase
{
    private static $virtualHost;
    private static $queueName;

    /** @var  MqManagementFactory $factory */
    private $factory;

    public static function setUpBeforeClass()
    {
        $jobService = Bootstrap::getFactory()->getJobService();

        // bootstrap the virtual host
        self::$queueName = new QueueName('integration-test');
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

    public function testListQueueEmpty()
    {
        $job = new JobQUeueList(self::$virtualHost, self::$queueName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertFalse($response->isSuccess());
    }

    public function testCreateBasicQueue()
    {
        $job = new JobQueueCreate(self::$virtualHost, self::$queueName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());
    }

    /**
     * Tests if we can list the just created queue
     */
    public function testListQueue()
    {
        $job = new JobQUeueList(self::$virtualHost, self::$queueName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(is_object($body));
        $this->assertEquals((string)self::$virtualHost, $body->vhost);
        $this->assertEquals((string)self::$queueName, $body->name);
    }


    public function testListQueueOnVirtualHost()
    {
        $job = new JobQueueListVirtualHost(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(is_array($body));
        $this->assertCount(1, $body);

        $this->assertEquals((string)self::$virtualHost, $body[0]->vhost);
        $this->assertEquals((string)self::$queueName, $body[0]->name);
    }

    public function testListALlOnVirtualHost()
    {
        $job = new JobQueueListAll();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(is_array($body));

        $found = false;
        foreach ($body as $queue) {
            $found = $queue->vhost === (string)self::$virtualHost && (string)self::$queueName === $queue->name;
            if ($found) {
                break;
            }
        }
        $this->assertTrue($found);
    }

    public function testQueueDelete()
    {
        $job = new JobQueueDelete(self::$virtualHost, self::$queueName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        // try to list the queue, if it fails it is deleted
        $job = new JobQUeueList(self::$virtualHost, self::$queueName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertFalse($response->isSuccess());
    }

}

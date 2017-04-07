<?php
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostList;
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
class VirtualHostTest extends TestCase
{
    private static $virtualHost;

    public static function setUpBeforeClass()
    {
        self::$virtualHost = new VirtualHost(sprintf('/integration-test/%1$s/%2$d/', __CLASS__, time()));
    }

    public function testCreateVirtualHost()
    {
        $jobService = Bootstrap::getFactory()->getJobService();

        $job = new JobVirtualHostCreate(self::$virtualHost);
        $response = $jobService->execute($job);
        self::assertTrue($response->isSuccess());

        // lets find the virtualhost
        $job = new JobVirtualHostList();
        $response = $jobService->execute($job);
        $body = $response->getBody();
        $this->assertTrue($response->isSuccess());
        $this->assertTrue(is_array($body));

        $found = false;
        foreach ($body as $virtualHost) {
            $found = $virtualHost->name === (string)self::$virtualHost;
            if ($found) {
                break;
            }
        }
        $this->assertTrue($found);
    }

    /**
     * Tests if we can list the just created queue
     */
    public function testListVirtualHost()
    {
        $job = new JobVirtualHostList();
        $job->setVirtualHost(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        $this->assertTrue($response->isSuccess());
        $this->assertEquals((string)self::$virtualHost, $body->name);
    }

    public function testDeleteVirtualHost()
    {
        $job = new JobVirtualHostDelete(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        // list the virtualhost, if the call fails the virtualhost got deleted
        $job = new JobVirtualHostList();
        $job->setVirtualHost(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertFalse($response->isSuccess());
    }
}
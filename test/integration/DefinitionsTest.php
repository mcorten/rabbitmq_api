<?php

namespace mcorten87\rabbitmq_api\test\integration;

use mcorten87\rabbitmq_api\jobs\JobDefinitionListAll;
use mcorten87\rabbitmq_api\jobs\JobDefinitionListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class DefinitionsTest extends TestCase
{

    private static $virtualHost;

    public static function setUpBeforeClass()
    {
        $jobService = Bootstrap::getFactory()->getJobService();

        // bootstrap the virtual host
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

    public function testDefinitionListAll()
    {
        $job = new JobDefinitionListAll();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        self::assertTrue($response->isSuccess());
        self::assertNotEmpty($body->rabbit_version);
        self::assertTrue(is_array($body->users));
        self::assertTrue(is_array($body->vhosts));
        self::assertTrue(is_array($body->permissions));
    }

    public function testDefinitionListVirtualHost()
    {
        $job = new JobDefinitionListVirtualHost(self::$virtualHost);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $body = $response->getBody();

        self::assertTrue($response->isSuccess());
        self::assertNotEmpty($body->rabbit_version);
    }
}

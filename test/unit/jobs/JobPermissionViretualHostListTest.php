<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionVirtualHostList;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobPermissionVirtualHostListTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection() {
        $virtualHost = new VirtualHost('/test/');

        $job = new JobPermissionVirtualHostList($virtualHost);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
    }
}

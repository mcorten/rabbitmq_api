<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobVirtualHostList;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobVirtualHostDListTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function test_dependencyInjection() {
        $virtualHost = new VirtualHost('/test/');

        $job = new JobVirtualHostList();
        $this->assertFalse($job->hasVirtualHost());

        $job->setVirtualHost($virtualHost);
        $this->assertEquals($virtualHost, $job->getVirtualHost());
    }
}

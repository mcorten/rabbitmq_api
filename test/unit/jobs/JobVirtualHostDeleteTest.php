<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobVirtualHostDeleteTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDdependencyInjection() {
        $virtualHost = new VirtualHost('/test/');

        $job = new JobVirtualHostDelete($virtualHost);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
    }
}

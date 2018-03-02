<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobDefinitionListVirtualHost;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobDefinitionListTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testListVirtualHostDependencyInjection()
    {
        $virtualHost = new VirtualHost('/test/');

        $job = new JobDefinitionListVirtualHost($virtualHost);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
    }
}

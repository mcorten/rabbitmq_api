<?php
namespace mcorten87\rabbitmq_api\tests\jobs;

use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobVirtualHostCreateTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function test_dependencyInjection() {
        $virtualHost = new VirtualHost('/test/');

        $job = new JobVirtualHostCreate($virtualHost);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
    }
}

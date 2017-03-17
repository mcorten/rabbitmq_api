<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobExchangeList;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobExchangeListTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection()
    {

        $virtualHost = new VirtualHost('/test/');
        $exchangeName = new ExchangeName('/test/');


        $job = new JobExchangeList($virtualHost, $exchangeName);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($exchangeName, $job->getExchangeName());
    }
}

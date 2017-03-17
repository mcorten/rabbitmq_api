<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobExchangeCreate;
use mcorten87\rabbitmq_api\objects\ExchangeArgument;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobExchangeCreateTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection()
    {

        $virtualHost = new VirtualHost('/test/');
        $exchangeName = new ExchangeName('/test/');


        $job = new JobExchangeCreate($virtualHost, $exchangeName);

        $this->assertEquals($virtualHost, $job->getVirtualHost());
        $this->assertEquals($exchangeName, $job->getExchangeName());

        $this->assertFalse($job->isAutoDelete());
        $job->setAutoDelete(true);
        $this->assertTrue($job->isAutoDelete());

        $this->assertTrue($job->isDurable());
        $job->setDurable(false);
        $this->assertFalse($job->isDurable());

        $alternateExchangeArgument = new ExchangeArgument(ExchangeArgument::ALTERNATE_EXCHAGE, 'test');
        $job->addArgument($alternateExchangeArgument);
        $this->assertEquals($alternateExchangeArgument, $job->getArguments()[0]);
    }
}

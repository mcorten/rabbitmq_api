<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\RoutingKeyUnknown;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class VirtualHostTest extends TestCase
{
    public function providerValid()
    {
        return [
            ['user'],
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($value)
    {
        $virtualHost = new VirtualHost($value);
        $this->assertEquals($value, $virtualHost->getValue());
    }

    public function providerInvalid()
    {
        return [
            [''],
        ];
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     * @dataProvider providerInvalid
     */
    public function testInvalid($value)
    {
        $virtualHost = new VirtualHost($value);
        $this->assertEquals($value, $virtualHost->getValue());
    }
}
<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\RoutingKeyUnknown;
use mcorten87\rabbitmq_api\objects\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function providerValid()
    {
        return [
            ['http://www.test.nl'],
            ['www.test.nl'],
            ['/bindings'],
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($value)
    {
        $url = new Url($value);
        $this->assertEquals($value, $url->getValue());
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
        $url = new Url($value);
        $this->assertEquals($value, $url->getValue());
    }
}
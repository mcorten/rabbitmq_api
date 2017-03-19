<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\RoutingKeyUnknown;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
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
        $user = new User($value);
        $this->assertEquals($value, $user->getValue());
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
        $user = new User($value);
        $this->assertEquals($value, $user->getValue());
    }
}
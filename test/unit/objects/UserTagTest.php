<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\RoutingKeyUnknown;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use PHPUnit\Framework\TestCase;

class UserTagTest extends TestCase
{
    public function providerValid()
    {
        return [
            [UserTag::ADMINISTRATOR],
            [UserTag::MANAGEMENT],
            [UserTag::MONITORING],
            [UserTag::POLICYMAKER],
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($value)
    {
        $userTag = new UserTag($value);
        $this->assertEquals($value, $userTag->getValue());
    }

    public function providerInvalid()
    {
        return [
            [''],
            ['foo_unknown_bar'],
        ];
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     * @dataProvider providerInvalid
     */
    public function testInvalid($value)
    {
        $userTag = new UserTag($value);
        $this->assertEquals($value, $userTag->getValue());
    }
}
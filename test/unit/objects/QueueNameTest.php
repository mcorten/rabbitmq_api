<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\QueueName;
use PHPUnit\Framework\TestCase;

class QueueNameTest extends TestCase
{
    public function providerValid()
    {
        return [
            ['asd'],
            [0],
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($value)
    {
        $queueName = new QueueName($value);
        $this->assertEquals($value, $queueName->getValue());
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
        $queueName = new QueueName($value);
        $this->assertEquals($value, $queueName->getValue());
    }
}

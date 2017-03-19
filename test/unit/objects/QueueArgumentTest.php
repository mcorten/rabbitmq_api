<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use PHPUnit\Framework\TestCase;

class QueueArgumentTest extends TestCase
{
    public function providerValid()
    {
        return [
            [QueueArgument::MESSAGE_TTL, 0],
            [QueueArgument::EXPIRES, 0],
            [QueueArgument::MAX_LENGTH, 0],
            [QueueArgument::MAX_BYTES, 0],
            [QueueArgument::MAX_PRIORITY, 0],
            [QueueArgument::MAX_DEAD_LETTER_EXCHAGE, 'test'],
            [QueueArgument::MAX_DEAD_LETTER_ROUTING_KEY, 'test'],
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($argument, $value)
    {
        $queueArgument = new QueueArgument($argument, $value);
        $this->assertEquals($value, $queueArgument->getValue());
    }

    public function providerInvalid()
    {
        return [
            ['', ''],
            ['foo_unknown_argument_bar', 'asd'],
            [QueueArgument::MESSAGE_TTL, -1],
            [QueueArgument::EXPIRES, -1],
            [QueueArgument::MAX_LENGTH, -1],
            [QueueArgument::MAX_BYTES, -1],
            [QueueArgument::MAX_PRIORITY, -1],
            [QueueArgument::MAX_DEAD_LETTER_EXCHAGE, ''],
            [QueueArgument::MAX_DEAD_LETTER_ROUTING_KEY, ''],
        ];
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     * @dataProvider providerInvalid
     */
    public function testInvalid($argument, $value)
    {
        $queueArgument = new QueueArgument($argument, $value);
        $this->assertEquals($value, $queueArgument->getValue());
    }
}
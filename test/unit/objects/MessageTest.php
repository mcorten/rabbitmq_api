<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testValid()
    {
        $value = 'test';
        $message = new Message($value);
        $this->assertEquals($value, $message->getValue());
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     */
    public function testInvalid()
    {
        new Message('');
    }
}
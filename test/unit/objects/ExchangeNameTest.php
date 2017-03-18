<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\ExchangeName;
use PHPUnit\Framework\TestCase;

class ExchangeNameTest extends TestCase
{
    public function testValid()
    {
        $value = 'test';
        $exchangeName = new ExchangeName($value);
        $this->assertEquals($value, $exchangeName->getValue());
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     */
    public function testInvalid()
    {
        new ExchangeName('');
    }
}
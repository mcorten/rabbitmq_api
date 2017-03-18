<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Host;
use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    public function testValid()
    {
        $value = 'test';
        $host = new Host($value);
        $this->assertEquals($value, $host->getValue());
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     */
    public function testInvalid()
    {
        new Host('');
    }
}
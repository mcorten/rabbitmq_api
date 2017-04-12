<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Host;
use PHPUnit\Framework\TestCase;

class JobResultTest extends TestCase
{

    public function testValid()
    {

    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     */
    public function testInvalid()
    {
        new Host('');
    }
}
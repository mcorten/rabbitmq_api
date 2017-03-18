<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\DestinationType;
use PHPUnit\Framework\TestCase;

class DestinationTypeTest extends TestCase
{

    public function providerValid()
    {
        return [
            [DestinationType::QUEUE],
            [DestinationType::EXCHANGE]
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($value)
    {
        $destinationType = new DestinationType($value);
        $this->assertEquals($value, $destinationType->getValue());
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     */
    public function testInvalid()
    {
        new DestinationType(999);
    }
}
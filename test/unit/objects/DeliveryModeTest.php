<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\DeliveryMode;
use PHPUnit\Framework\TestCase;

class DeliveryModeTest extends TestCase
{

    public function providerValid()
    {
        return [
            [DeliveryMode::NON_PERSISTENT],
            [DeliveryMode::PERSISTENT]
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($value)
    {
        $deliveryMode = new DeliveryMode($value);
        $this->assertEquals($value, $deliveryMode->getValue());
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     */
    public function testInvalid()
    {
        new DeliveryMode(999);
    }
}
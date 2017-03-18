<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\exceptions\InvalidDataException;
use mcorten87\rabbitmq_api\objects\DeliveryMode;
use PHPUnit\Framework\TestCase;

class CallerObjectInfoTest extends TestCase
{

    public function testValid()
    {
        try {
            $deliveryMode = new DeliveryMode(999);
        } catch (InvalidDataException $e) {
            $this->assertEquals($e->getMessage(), "Invalid value[999] for class[src/objects/DeliveryMode.php]");
        }
    }
}
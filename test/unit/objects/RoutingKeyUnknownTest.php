<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\RoutingKeyUnknown;
use PHPUnit\Framework\TestCase;

class RouingKeyUnknownTest extends TestCase
{
    public function testValid()
    {
        $routingKey = new RoutingKeyUnknown();
        $this->assertEquals('', $routingKey->getValue());
        $this->assertEquals('', (string)$routingKey);
    }
}

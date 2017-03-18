<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\Method;
use PHPUnit\Framework\TestCase;

class MethodTest extends TestCase
{
    public function providerValid()
    {
        return [
            [Method::DELETE],
            [Method::GET],
            [Method::POST],
            [Method::PUT],
        ];
    }

    /**
     * @param $value
     * @dataProvider providerValid
     */
    public function testValid($value)
    {
        $method = new Method($value);
        $this->assertEquals($value, $method->getValue());
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     */
    public function testInvalid()
    {
        new Method(1);
    }
}
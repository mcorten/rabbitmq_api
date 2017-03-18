<?php

namespace mcorten87\rabbitmq_api\test\unit\objects;

use mcorten87\rabbitmq_api\objects\ExchangeArgument;
use PHPUnit\Framework\TestCase;

class ExchangeArgumentTest extends TestCase
{


    public function testValid()
    {
        $alternateExchangeName = 'test';
        $exchangeArgument = new ExchangeArgument(ExchangeArgument::ALTERNATE_EXCHAGE, $alternateExchangeName);
        $this->assertEquals($alternateExchangeName, $exchangeArgument->getValue());
    }

    public function providerInvalid()
    {
        return [
            ['','test'],
            [ExchangeArgument::ALTERNATE_EXCHAGE, ''],
            ['test', 'test'],
        ];
    }

    /**
     * @expectedException \mcorten87\rabbitmq_api\exceptions\InvalidDataException
     * @dataProvider providerInvalid
     */
    public function testInvalid($argument, $value)
    {
        new ExchangeArgument($argument, $value);
    }
}
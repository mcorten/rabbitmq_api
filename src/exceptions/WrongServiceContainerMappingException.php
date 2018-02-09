<?php

namespace mcorten87\rabbitmq_api\exceptions;

class WrongServiceContainerMappingException extends BaseException
{
    protected $code = 3;
    private $baseMessage = 'Wrong mapping, got [%1$s] expected [%2$s]';

    public static function expectedOtherMapping($mapping, string $expectedMapping)
    {
        return new self($mapping, $expectedMapping);
    }

    public function __construct($class, string $expectedClass)
    {
        $message = sprintf($this->baseMessage, get_class($class), $expectedClass);
        parent::__construct($message, $this->code);
    }
}

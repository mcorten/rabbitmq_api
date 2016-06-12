<?php

namespace mcorten87\rabbitmq_api\exceptions;

class InvalidDataException extends BaseException
{
    protected $code = 1;
    private $baseMessage = 'Invalid value[%1$s] for class[%2$s]';

    public function __construct()
    {
        $caller = $this->getCallerInfo();

        $message = sprintf($this->baseMessage, $caller->getValue(), $caller->getFile());
        parent::__construct($message, $this->code);
    }

}

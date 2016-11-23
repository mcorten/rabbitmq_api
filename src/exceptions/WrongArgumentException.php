<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:03
 */

namespace mcorten87\rabbitmq_api\exceptions;


use mcorten87\rabbitmq_api\jobs\JobBase;

class WrongArgumentException extends BaseException
{
    protected $code = 2;
    private $baseMessage = 'Wrong argument, got [%1$s] expected [%2$s]';

    public function __construct(JobBase $class, string $expectedClass)
    {
        $message = sprintf($this->baseMessage, get_class($class), $expectedClass);
        parent::__construct($message, $this->code);
    }
}

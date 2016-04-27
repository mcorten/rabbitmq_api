<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:03
 */

namespace mcorten87\messagequeue_management\exceptions;


use mcorten87\messagequeue_management\jobs\JobBase;

class NoMapperForJob extends BaseException
{
    protected $code = 100;
    private $baseMessage = 'No mapper found for class[%1$s]';

    public function __construct(JobBase $class)
    {
        $message = sprintf($this->baseMessage, get_class($class));
        parent::__construct($message, $this->code);
    }
}

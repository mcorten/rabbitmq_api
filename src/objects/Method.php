<?php

namespace mcorten87\rabbitmq_api\objects;

class Method extends BaseObject
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate($value) : bool
    {
        switch ($value) {
            case self::METHOD_GET:
            case self::METHOD_POST:
            case self::METHOD_PUT:
            case self::METHOD_DELETE:
                return true;
            default:
                return false;
        }
    }
}

<?php

namespace mcorten87\rabbitmq_api\objects;

class Method extends BaseObject
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate($value) : bool
    {
        switch ($value) {
            case self::GET:
            case self::POST:
            case self::PUT:
            case self::DELETE:
                return true;
            default:
                return false;
        }
    }
}

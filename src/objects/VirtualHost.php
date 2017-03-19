<?php

namespace mcorten87\rabbitmq_api\objects;

class VirtualHost extends BaseObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function validate($value) : bool
    {
        return !empty($value) || is_numeric($value);
    }
}

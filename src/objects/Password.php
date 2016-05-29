<?php

namespace mcorten87\rabbitmq_api\objects;

class Password extends BaseObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}

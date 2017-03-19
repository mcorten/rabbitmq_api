<?php

namespace mcorten87\rabbitmq_api\objects;

class Url extends BaseObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate($value): bool
    {
        return !empty($value);
    }

}

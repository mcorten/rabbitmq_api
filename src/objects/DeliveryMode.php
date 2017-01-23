<?php

namespace mcorten87\rabbitmq_api\objects;

class DeliveryMode extends BaseObject
{
    const NON_PERSISTENT = 1;
    const PERSISTENT = 2;

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function validate($value) : bool
    {
        switch ($value) {
            case self::NON_PERSISTENT:
            case self::PERSISTENT:
                return true;
            default:
                return parent::validate($value);
        }
    }
}

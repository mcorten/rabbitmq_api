<?php

namespace mcorten87\rabbitmq_api\objects;

class UserTag extends BaseObject
{
    const ADMINISTRATOR = "administrator";
    const MANAGEMENT = "management";
    const MONITORING = "monitoring";
    const POLICYMAKER = "policymaker";

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function validate($value) : bool
    {
        switch ($value) {
            case self::ADMINISTRATOR:
            case self::MANAGEMENT:
            case self::MONITORING:
            case self::POLICYMAKER:
                return true;
            default:
                return false;
        }
    }
}

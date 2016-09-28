<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 28-9-16
 * Time: 21:16
 */

namespace mcorten87\rabbitmq_api\objects;


class DestinationType extends BaseObject
{
    const QUEUE = 'q';
    const EXCHANGE = 'e';

    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    protected function validate($value) : bool
    {
        switch ($value) {
            case self::QUEUE:
            case self::EXCHANGE:
                return true;

            default:
                return false;
        }
    }


}
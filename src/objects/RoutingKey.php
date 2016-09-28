<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 28-9-16
 * Time: 21:16
 */

namespace mcorten87\rabbitmq_api\objects;


class RoutingKey extends BaseObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
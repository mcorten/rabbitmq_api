<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 28-9-16
 * Time: 21:16
 */

namespace mcorten87\rabbitmq_api\objects;


class RoutingKeyUnknown extends RoutingKey
{
    public function __construct()
    {
        parent::__construct('');
    }

    public function getValue(): string
    {
        return '';
    }

    public function __toString(): string
    {
        return '';
    }


}
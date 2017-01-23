<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 28-9-16
 * Time: 21:16
 */

namespace mcorten87\rabbitmq_api\objects;


class RoutingKeyUnknown extends BaseObject
{
    public function __construct()
    {
        parent::__construct(null);
    }

    public function __toString(): string
    {
        return '';
    }


}
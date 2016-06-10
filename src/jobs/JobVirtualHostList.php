<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:09
 */

namespace mcorten87\rabbitmq_api\jobs;


use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobVirtualHostList extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /**
     * @param VirtualHost $virtualHost
     */
    public function setVirtualHost($virtualHost)
    {
        $this->virtualHost = $virtualHost;
    }

    /**
     * @return VirtualHost
     */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    public function hasVirtualHost() {
        return $this->virtualHost !== null;
    }
}

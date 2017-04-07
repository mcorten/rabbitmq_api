<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:09
 */

namespace mcorten87\rabbitmq_api\jobs;


use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobVirtualHostList extends JobBase
{
    // TODO this should be in its own class
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

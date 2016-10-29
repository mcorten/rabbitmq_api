<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\VirtualHost;

/**
 * Lists the details of a specific exchange
 */
class JobBindingListVirtualHost extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;


    /** @return VirtualHost */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    public function __construct(VirtualHost $virtualHost)
    {
        $this->virtualHost = $virtualHost;
    }
}

<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobDefinitionListVirtualHost extends JobBase
{
    private $virtualHost;

    public function __construct(VirtualHost $virtualHost)
    {
        $this->virtualHost = $virtualHost;
    }

    /**
     * @return VirtualHost
     */
    public function getVirtualHost(): VirtualHost
    {
        return $this->virtualHost;
    }
}

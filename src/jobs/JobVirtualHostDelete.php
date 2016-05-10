<?php

namespace mcorten87\messagequeue_management\jobs;

use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobVirtualHostDelete extends JobBase
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

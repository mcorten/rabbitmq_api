<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobPermissionDelete extends JobBase
{

    /** @var  VirtualHost */
    private $virtualHost;

    /** @var  User */
    private $user;

    /**
     * @return VirtualHost
     */
    public function getVirtualHost()
    {
        return $this->virtualHost;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __construct(VirtualHost $virtualHost, User $user)
    {
        $this->virtualHost = $virtualHost;
        $this->user = $user;
    }
}

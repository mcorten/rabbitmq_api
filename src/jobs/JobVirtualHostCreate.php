<?php

namespace mcorten87\messagequeue_management\jobs;

use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobVirtualHostCreate extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $vhost;

    /**
     * @param VirtualHost $vhost
     */
    public function setVhost(VirtualHost $vhost)
    {
        $this->vhost = $vhost;
    }

    /** @return VirtualHost */
    public function getVhost() : VirtualHost
    {
        return $this->vhost;
    }


    public function __construct(User $user, Password $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 21:14
 */

namespace mcorten87\messagequeue_management\jobs;


use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobQueuesList extends JobBase
{
    private $virtualhost;

    /**
     * @return VirtualHost
     */
    public function getVirtualhost()
    {
        return $this->virtualhost;
    }

    /**
     * @param VirtualHost $virtualhost
     */
    public function setVirtualhost(VirtualHost $virtualhost)
    {
        $this->virtualhost = $virtualhost;
    }

    public function __construct(User $user, Password $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
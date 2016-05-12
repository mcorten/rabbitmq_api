<?php

namespace mcorten87\messagequeue_management\jobs;

use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\QueueName;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\UserTag;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobUserDelete extends JobBase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

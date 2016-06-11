<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\User;

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

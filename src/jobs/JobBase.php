<?php

namespace mcorten87\messagequeue_management\jobs;

use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;

class JobBase
{
    protected $user;
    protected $password;

    protected function __construct(User $user, Password $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
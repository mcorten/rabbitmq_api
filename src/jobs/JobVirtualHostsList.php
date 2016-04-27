<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:09
 */

namespace mcorten87\messagequeue_management\jobs;


use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;

class JobVirtualHostsList extends JobBase
{
    public function __construct(User $user, Password $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}

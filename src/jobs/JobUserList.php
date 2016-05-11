<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 21:14
 */

namespace mcorten87\messagequeue_management\jobs;


use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\QueueName;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobUserList extends JobBase
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

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


}

<?php

namespace mcorten87\messagequeue_management\jobs;

use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\QueueName;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\UserTag;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobUserCreate extends JobBase
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Password
     */
    private $password;

    /**
     * @var UserTag[]
     */
    private $userTags = [];

    public function addUserTag (UserTag $userTag) {
        $this->userTags[] = $userTag;
    }

    /**
     * @param Password $password
     */
    public function setPassword(Password $password) {
        $this->password = $password;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return UserTag[]
     */
    public function getUserTags()
    {
        return $this->userTags;
    }

    public function __construct(User $user, UserTag $tag)
    {
        $this->user = $user;
        $this->addUserTag($tag);
    }
}

<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\PasswordHash;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;

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
     * @var PasswordHash
     */
    private $passwordHash;

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
     * @param PasswordHash $passwordHash
     */
    public function setPasswordHash(PasswordHash $passwordHash)
    {
        $this->passwordHash = $passwordHash;
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
     * @return PasswordHash
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @return UserTag[]
     */
    public function getUserTags()
    {
        return $this->userTags;
    }

    public function hasPassword() {
        return $this->password instanceof Password;
    }

    public function hasPasswordHash() {
        return $this->passwordHash instanceof PasswordHash;
    }

    public function __construct(User $user, UserTag $tag)
    {
        $this->user = $user;
        $this->addUserTag($tag);
    }
}

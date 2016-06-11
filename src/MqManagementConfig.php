<?php

namespace mcorten87\rabbitmq_api;


use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;

class MqManagementConfig
{

    /**
     * @var User
     */
    private $user;

    /** @return User */
    public function getUser() : User {
        return $this->user;
    }

    /**
     * @var Password
     */
    private $password;

    /** @return Password */
    public function getPassword() : Password {
        return $this->password;
    }


    private $url;

    /** @return Url */
    public function getUrl() : Url {
        return $this->url;
    }


    public function __construct(User $user, Password $password, Url $url)
    {
        $this->user = $user;
        $this->password = $password;
        $this->url = $url;
    }
}

<?php

namespace mcorten87\messagequeue_management\services;


use mcorten87\messagequeue_management\jobs\JobVirtualHostCreate;
use mcorten87\messagequeue_management\MqManagementConfig;
use mcorten87\messagequeue_management\MqManagementFactory;
use mcorten87\messagequeue_management\objects\Host;
use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class MqManagermentService
{
    /**
     * MqManagermentService constructor.
     *
     * @param MqManagementFactory $factory
     * @param Host $host
     * @param User $user
     * @param Password $password
     */
    public function __construct(MqManagementFactory $factory, MqManagementConfig $config)
    {
        $factory->register($config);
        $factory->getConfig();
    }
}

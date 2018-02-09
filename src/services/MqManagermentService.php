<?php

namespace mcorten87\rabbitmq_api\services;


use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\MqManagementFactory;
use mcorten87\rabbitmq_api\objects\Host;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\User;

class MqManagermentService
{
    /**
     * MqManagermentService constructor.
     *
     * @param MqManagementFactory $factory
     */
    public function __construct(MqManagementFactory $factory, MqManagementConfig $config)
    {
        $factory->register($config);
        $factory->getConfig();
    }
}

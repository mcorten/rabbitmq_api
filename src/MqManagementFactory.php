<?php

namespace mcorten87\messagequeue_management;


use mcorten87\messagequeue_management\jobs\JobCreateVirtualHost;
use mcorten87\messagequeue_management\mappers\JobCreateVirtualHostMapper;
use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;
use mcorten87\messagequeue_management\services\JobService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class MqManagementFactory
{
    const HTTPCLIENT = 'HttpClient';

    const SERVICE_JOB = 'JobService';

    const JOB_CREATEVHOST = 'JobCreateVhost';
    const JOB_CREATEVHOSTMAPPER = 'JobCreateVhostMapper';

    /** @var MqManagementConfig */
    private $config;

    public function getConfig() : MqManagementConfig {
        return $this->config;
    }

    /**
     * @var ContainerBuilder
     */
    private $container;


    public function __construct()
    {
        $container = new ContainerBuilder();
        $this->container = $container;
    }

    /**
     * @param MqManagementConfig $config
     */
    public function register(MqManagementConfig $config) {
        $this->config = $config;

        $this->container->register(self::HTTPCLIENT,'GuzzleHttp\Client');

        $definition = new Definition('mcorten87\messagequeue_management\jobs\JobCreateVirtualHost');
        $definition->setShared(false);
        $this->container->setDefinition(self::JOB_CREATEVHOST, $definition)
            ->addArgument($this->config->getUser())
            ->addArgument($this->config->getPassword())
        ;

        $this->container->register(self::SERVICE_JOB,'mcorten87\messagequeue_management\services\JobService')
            ->addArgument($this)
            ->addArgument($this->container->get(self::HTTPCLIENT))
        ;

        $this->container->register(self::JOB_CREATEVHOSTMAPPER, 'mcorten87\messagequeue_management\mappers\JobCreateVirtualHostMapper')
            ->addArgument($this->config)
        ;
    }

    /**
     * @param VirtualHost $vhost
     * @return JobCreateVirtualHost
     */
    public function getJobCreateVirtualHost(VirtualHost $vhost) : JobCreateVirtualHost {
        /** @var JobCreateVirtualHost $job */
        $job = $this->container->get(self::JOB_CREATEVHOST);
        $job->setVhost($vhost);
        return $job;

//        $job = new JobCreateVirtualHost($this->config->getUser(), $this->config->getPassword(), $vhost);
//        return $job;
    }

    /**
     * @return JobCreateVirtualHostMapper
     */
    public function getJobCreateVirtualHostMapper() : JobCreateVirtualHostMapper {
        return $this->container->get(self::JOB_CREATEVHOSTMAPPER);
    }

    /**
     * @return JobService
     */
    public function getJobService() : JobService {
        return $this->container->get(self::SERVICE_JOB);
    }
}
<?php

namespace mcorten87\rabbitmq_api;

use GuzzleHttp\Client;
use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostsList;
use mcorten87\rabbitmq_api\mappers\BaseMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingListAllMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingListBetweenQueueAndExchangeMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingListExchangeMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingListQueueMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingListVirtualHostMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingToExchangeCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingToExchangeDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingToQueueCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingToQueueDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeListAllMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeListMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeListVirtualHostMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangePublishMapper;
use mcorten87\rabbitmq_api\mappers\JobOverviewListMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionListAllMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionListMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionListUserMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionListVirtualHostMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueListAllMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueListMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueListVirtualHostMapper;
use mcorten87\rabbitmq_api\mappers\JobUserCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobUserDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobUserListMapper;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostListMapper;
use mcorten87\rabbitmq_api\objects\JobResult;
use mcorten87\rabbitmq_api\services\JobService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class MqManagementFactory
{

    /** @var MqManagementConfig */
    private $config;

    public function getConfig() : MqManagementConfig
    {
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
    public function register(MqManagementConfig $config)
    {
        $this->config = $config;

        $this->container->register(Client::class, Client::class);

        $this->container->register(JobService::class, JobService::class)
            ->addArgument($this)
            ->addArgument($this->container->get(Client::class))
        ;
    }

    protected function registerMapper(BaseMapper $mapper, JobBase $job) {
        $this->container->register(
                get_class($job),
                get_class($mapper))
            ->addArgument($this->config)
        ;
    }


    /**
     * @param  String $class
     * @return JobService|JobBase
     */
    private function get(String $class)
    {
        $result = $this->container->get($class);
        return $result;
    }

    /**
     * @return JobService
     */
    public function getJobService()
    {
        return $this->get(JobService::class);
    }

    /**
     * @param $result
     * @return JobResult
     */
    public function getJobResult($result)
    {
        return new JobResult($result);
    }

    /**
     * Gets a mapper for the job, if non found it throws an NoMapperForJob exception
     *
     * @param JobBase $job
     * @return BaseMapper
     * @throws NoMapperForJob
     */
    public function getJobMapper(JobBase $job) : BaseMapper
    {
        $mapper = $this->getJobMapperFromContainer($job);
        if ($mapper instanceof BaseMapper) {
            return $mapper;
        }

        $mapper = $this->getJobMapperFromAutoload($job);
        if ($mapper instanceof BaseMapper) {
            return $mapper;
        }

        throw new NoMapperForJob($job);
    }

    private function getJobMapperFromContainer(JobBase $job) {
        $class = get_class($job);

        if (!$this->container->has($class)) {
            return null;
        }

        return $this->container->get($class);
    }

    private function getJobMapperFromAutoload(JobBase $job) {
        $class = get_class($job);
        $class = str_replace('\\jobs\\', '\\mappers\\', $class);
        $class .= 'Mapper';

        try {
            return new $class($this->config);
        } catch (\Throwable  $e) {
            return null;
        }
    }
}

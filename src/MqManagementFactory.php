<?php

namespace mcorten87\rabbitmq_api;

use GuzzleHttp\Client;
use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostsList;
use mcorten87\rabbitmq_api\mappers\BaseMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionListMapper;
use mcorten87\rabbitmq_api\objects\JobResult;
use mcorten87\rabbitmq_api\services\JobService;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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

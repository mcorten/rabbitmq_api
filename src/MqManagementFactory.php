<?php

namespace mcorten87\rabbitmq_api;

use GuzzleHttp\Client;
use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\exceptions\WrongServiceContainerMappingException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\mappers\BaseMapper;
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
     * @throws \Exception
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

    protected function registerMapper(BaseMapper $mapper, JobBase $job)
    {
        $this->container->register(
            get_class($job),
            get_class($mapper)
        )
        ->addArgument($this->config);
    }

    /**
     * @return JobService
     * @throws \Exception
     */
    public function getJobService() : JobService
    {
        $jobService = $this->container->get(JobService::class);
        if (!$jobService instanceof JobService) {
            throw WrongServiceContainerMappingException::expectedOtherMapping(
                $jobService,
                JobService::class
            );
        }

        return $jobService;
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
     * @throws WrongServiceContainerMappingException
     * @throws \Exception
     */
    public function getJobMapper(JobBase $job) : BaseMapper
    {
        try {
            return $this->getJobMapperFromContainer($job);
        } catch (NoMapperForJob $e) {
            return $this->getJobMapperFromAutoload($job);
        }
    }

    /**
     * @param JobBase $job
     * @return BaseMapper
     * @throws NoMapperForJob
     * @throws WrongServiceContainerMappingException
     * @throws \Exception
     */
    private function getJobMapperFromContainer(JobBase $job)
    {
        $class = get_class($job);

        if (false === $this->container->has($class)) {
            throw new NoMapperForJob($job);
        }

        $mapper = $this->container->get($class);
        if (!$mapper instanceof BaseMapper) {
            throw WrongServiceContainerMappingException::expectedOtherMapping($job, BaseMapper::class);
        }

        return $mapper;
    }

    /**
     * @param JobBase $job
     * @return mixed
     * @throws NoMapperForJob
     */
    private function getJobMapperFromAutoload(JobBase $job)
    {
        $class = get_class($job);
        $class = str_replace('\\jobs\\', '\\mappers\\', $class);
        $class .= 'Mapper';

        try {
            return new $class($this->config);
        } catch (\Throwable  $e) {
            throw new NoMapperForJob($job);
        }
    }
}

<?php

namespace mcorten87\messagequeue_management;


use mcorten87\messagequeue_management\exceptions\NoMapperForJob;
use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobCreateVirtualHost;
use mcorten87\messagequeue_management\jobs\JobDeleteVirtualHost;
use mcorten87\messagequeue_management\jobs\JobListVirtualHosts;
use mcorten87\messagequeue_management\mappers\BaseMapper;
use mcorten87\messagequeue_management\mappers\JobCreateVirtualHostMapper;
use mcorten87\messagequeue_management\objects\JobResult;
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

    const JOB_RESULT = 'JobResult';

    const JOB_CREATEVHOST = 'JobCreateVhost';
    const JOB_CREATEVHOSTMAPPER = 'JobCreateVhostMapper';

    const JOB_LISTVHOSTS = 'JobListVhosts';
    const JOB_LISTVHOSTSMAPPER = 'JobListVhostsMapper';

    const JOB_DELETEVHOSTS = 'JobDeleteVhosts';
    const JOB_DELETEVHOSTSMAPPER = 'JobDeleteVhostsMapper';



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

        $this->container->register(self::SERVICE_JOB,'mcorten87\messagequeue_management\services\JobService')
            ->addArgument($this)
            ->addArgument($this->container->get(self::HTTPCLIENT))
        ;



        $this->registerJobs();
    }

    protected function registerJobs() {
        // results
        $definition = new Definition('mcorten87\messagequeue_management\objects\JobResult');
        $definition->setShared(false);
        $this->container->setDefinition(self::JOB_RESULT, $definition);

        // virtual hosts
        $definition = new Definition('mcorten87\messagequeue_management\jobs\JobListVirtualHosts');
        $definition->setShared(false);
        $this->container->setDefinition(self::JOB_LISTVHOSTS, $definition)
            ->addArgument($this->config->getUser())
            ->addArgument($this->config->getPassword())
        ;

        $this->container->register(self::JOB_LISTVHOSTSMAPPER, 'mcorten87\messagequeue_management\mappers\JobListVirtualHostMapper')
            ->addArgument($this->config)
        ;

        $definition = new Definition('mcorten87\messagequeue_management\jobs\JobCreateVirtualHost');
        $definition->setShared(false);
        $this->container->setDefinition(self::JOB_CREATEVHOST, $definition)
            ->addArgument($this->config->getUser())
            ->addArgument($this->config->getPassword())
        ;

        $this->container->register(self::JOB_CREATEVHOSTMAPPER, 'mcorten87\messagequeue_management\mappers\JobCreateVirtualHostMapper')
            ->addArgument($this->config)
        ;

        $definition = new Definition('mcorten87\messagequeue_management\jobs\JobDeleteVirtualHost');
        $definition->setShared(false);
        $this->container->setDefinition(self::JOB_DELETEVHOSTS, $definition)
            ->addArgument($this->config->getUser())
            ->addArgument($this->config->getPassword())
        ;

        $this->container->register(self::JOB_DELETEVHOSTSMAPPER, 'mcorten87\messagequeue_management\mappers\JobDeleteVirtualHostMapper')
            ->addArgument($this->config)
        ;
    }

    public function getJobResult($response) : JobResult {
        /** @var JobResult */
        $result = $this->container->get(self::JOB_RESULT);
        $result->setResponse($response);
        return $result;
    }

    /**
     * @param VirtualHost $vhost
     * @return JobCreateVirtualHost
     */
    public function getJobListVirtualHosts() : JobListVirtualHosts {
        return $this->container->get(self::JOB_LISTVHOSTS);
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
    }

    public function getJobDeleteVirtualHost(VirtualHost $vhost) : JobDeleteVirtualHost {
        $job = $this->container->get(self::JOB_DELETEVHOSTS);
        $job->setVhost($vhost);
        return $job;
    }

    /**
     * Gets a mapper for the job, if non found it throws an NoMapperForJob exception
     *
     * @param JobBase $job
     * @return JobCreateVirtualHostMapper
     * @throws NoMapperForJob
     */
    public function getJobMapper(JobBase $job) : BaseMapper {
        switch ($job) {
            case $job instanceof JobListVirtualHosts:
                return $this->container->get(self::JOB_LISTVHOSTSMAPPER);
                break;
            case $job instanceof JobCreateVirtualHost:
                return $this->container->get(self::JOB_CREATEVHOSTMAPPER);
                break;
            case $job instanceof JobDeleteVirtualHost:
                return $this->container->get(self::JOB_DELETEVHOSTSMAPPER);
                break;
            default:
                throw new NoMapperForJob($job);
        }
    }

    /**
     * @return JobService
     */
    public function getJobService() : JobService {
        return $this->container->get(self::SERVICE_JOB);
    }
}

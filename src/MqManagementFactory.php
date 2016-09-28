<?php

namespace mcorten87\rabbitmq_api;


use GuzzleHttp\Client;
use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingCreateToQueue;
use mcorten87\rabbitmq_api\jobs\JobExchangeCreate;
use mcorten87\rabbitmq_api\jobs\JobExchangeDelete;
use mcorten87\rabbitmq_api\jobs\JobExchangeList;
use mcorten87\rabbitmq_api\jobs\JobExchangeListAll;
use mcorten87\rabbitmq_api\jobs\JobExchangeListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobPermissionDelete;
use mcorten87\rabbitmq_api\jobs\JobPermissionListAll;
use mcorten87\rabbitmq_api\jobs\JobPermissionListUser;
use mcorten87\rabbitmq_api\jobs\JobPermissionListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\jobs\JobQueueListAll;
use mcorten87\rabbitmq_api\jobs\JobQueueListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostList;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostsList;
use mcorten87\rabbitmq_api\mappers\BaseMapper;
use mcorten87\rabbitmq_api\mappers\JobBindingCreateToQueueMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeListMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeListNameMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeListVirtualHostMapper;
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
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\JobResult;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\PasswordHash;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use mcorten87\rabbitmq_api\services\JobService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class MqManagementFactory
{

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

        $this->container->register(Client::class, Client::class);

        $this->container->register(JobService::class, JobService::class)
            ->addArgument($this)
            ->addArgument($this->container->get(Client::class))
        ;

        $this->registerJobs();
    }

    protected function registerJobs() {
        // results
        $definition = new Definition('mcorten87\rabbitmq_api\objects\JobResult');
        $definition->setShared(false);
        $this->container->setDefinition(JobResult::class, $definition);

        // virtual hosts
        $this->container->register(JobVirtualHostListMapper::class, JobVirtualHostListMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobVirtualHostCreateMapper::class, JobVirtualHostCreateMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobVirtualHostDeleteMapper::class, JobVirtualHostDeleteMapper::class)
            ->addArgument($this->config)
        ;

        // queues
        $this->container
            ->register(JobQueueListAllMapper::class, JobQueueListAllMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobQueueListVirtualHostMapper::class, JobQueueListVirtualHostMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobQueueListMapper::class, JobQueueListMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobQueueCreateMapper::class, JobQueueCreateMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobQueueDeleteMapper::class, JobQueueDeleteMapper::class)
            ->addArgument($this->config)
        ;

        // users
        $this->container
            ->register(JobUserListMapper::class, JobUserListMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobUserCreateMapper::class, JobUserCreateMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobUserDeleteMapper::class, JobUserDeleteMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobPermissionListAllMapper::class, JobPermissionListAllMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobPermissionListUserMapper::class, JobPermissionListUserMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobPermissionListVirtualHostMapper::class, JobPermissionListVirtualHostMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobPermissionCreateMapper::class, JobPermissionCreateMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobPermissionDeleteMapper::class, JobPermissionDeleteMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobExchangeListMapper::class, JobExchangeListMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobExchangeListVirtualHostMapper::class, JobExchangeListVirtualHostMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobExchangeListNameMapper::class, JobExchangeListNameMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobExchangeCreateMapper::class, JobExchangeCreateMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobExchangeDeleteMapper::class, JobExchangeDeleteMapper::class)
            ->addArgument($this->config)
        ;

        $this->container
            ->register(JobBindingCreateToQueueMapper::class, JobBindingCreateToQueueMapper::class)
            ->addArgument($this->config)
        ;
    }

    /**
     * @param $response
     * @return JobResult
     */
    public function getJobResult($response) : JobResult {
        /** @var JobResult */
        $result = $this->container->get(JobResult::class);
        $result->setResponse($response);
        return $result;
    }

    /**
     * @param VirtualHost $virtualHost
     * @return JobVirtualHostList
     */
    public function getJobVirtualHostList(VirtualHost $virtualHost = null) : JobVirtualHostList {
        $job = new JobVirtualHostList();
        if ($virtualHost !== null) {
            $job->setVirtualHost($virtualHost);
        }
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @return JobVirtualHostCreate
     */
    public function getJobVirtualHostCreate(VirtualHost $virtualHost) : JobVirtualHostCreate {
        /** @var JobVirtualHostCreate $job */
        $job = new JobVirtualHostCreate($virtualHost);
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @return JobVirtualHostDelete
     */
    public function getJobVirtualHostDelete(VirtualHost $virtualHost) : JobVirtualHostDelete {
        /** @var JobVirtualHostDelete $job */
        $job = new JobVirtualHostDelete($virtualHost);
        return $job;
    }

    /**
     * @return JobQueueListAll
     */
    public function getJobQueuesList() : JobQueueListAll {
        /** @var JobQueueListAll $job */
        $job = new JobQueueListAll();
        return $job;
    }

    /**
     * @param VirtualHost|null $virtualHost
     * @return JobQueueListAll
     */
    public function getJobQueueListVirtualHost(VirtualHost $virtualHost) : JobQueueListVirtualHost {
        /** @var JobQueueListAll $job */
        $job = new JobQueueListVirtualHost($virtualHost);
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @param QueueName $queueName
     * @return JobQueueList
     */
    public function getJobQueueList(VirtualHost $virtualHost, QueueName $queueName) : JobQueueList {
        $job = new JobQueueList($virtualHost, $queueName);
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @param QueueName $queueName
     * @return JobQueueCreate
     */
    public function getJobQueueCreate(VirtualHost $virtualHost, QueueName $queueName) : JobQueueCreate {
        $job = new JobQueueCreate($virtualHost, $queueName);
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @param QueueName $queueName
     * @return JobQueueDelete
     */
    public function getJobQueueDelete(VirtualHost $virtualHost, QueueName $queueName) : JobQueueDelete {
        $job = new JobQueueDelete($virtualHost, $queueName);
        return $job;
    }


    /**
     * @param User|null $user
     * @return JobUserList
     */
    public function getJobUserList(User $user = null) : JobUserList {
        $job = new JobUserList();
        if ($user !== null) {
            $job->setUser($user);
        }
        return $job;
    }

    /**
     * @param User $user
     * @param UserTag $userTag
     * @param Password|null $password
     * @param PasswordHash|null $passwordHash
     * @return JobUserCreate
     */
    public function getJobUserCreate(User $user, UserTag $userTag, Password $password = null, PasswordHash $passwordHash = null) : JobUserCreate {
        $job = new JobUserCreate($user, $userTag);
        if ($password !== null) {
            $job->setPassword($password);
        }
        if ($passwordHash !== null) {
            $job->setPasswordHash($passwordHash);
        }
        return $job;
    }

    /**
     * @param User $user
     * @return JobUserDelete
     */
    public function getJobUserDelete(User $user) : JobUserDelete {
        $job = new JobUserDelete($user);
        return $job;
    }

    /**
     * @return JobPermissionListAll
     */
    public function getJobPermissionList() : JobPermissionListAll {
        $job = new JobPermissionListAll();
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @return JobPermissionListVirtualHost
     */
    public function getJobPermissionListVirtualHost(VirtualHost $virtualHost) : JobPermissionListVirtualHost {
        $job = new JobPermissionListVirtualHost($virtualHost);
        return $job;
    }

    /**
     * @param User $user
     * @return JobPermissionListUser
     */
    public function getJobPermissionListUser(User $user) : JobPermissionListUser {
        $job = new JobPermissionListUser($user);
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @param User $user
     * @return JobPermissionCreate
     */
    public function getJobPermissionCreate(VirtualHost $virtualHost, User $user) : JobPermissionCreate {
        $job = new JobPermissionCreate($virtualHost, $user);
        return $job;
    }

    /**
     * @param VirtualHost $virtualHost
     * @param User $user
     * @return JobPermissionDelete
     */
    public function getJobPermissionDelete(VirtualHost $virtualHost, User $user) : JobPermissionDelete {
        $job = new JobPermissionDelete($virtualHost, $user);
        return $job;
    }

    /**
     * @return JobExchangeListAll
     */
    public function getJobExchangeListAll() : JobExchangeListAll {
        $job = new JobExchangeListAll();
        return $job;
    }

    /**
     * @return JobExchangeVirtualHostListList
     */
    public function getJobExchangesListVirtualHost(VirtualHost $virtualHost) : JobExchangeListVirtualHost {
        $job = new JobExchangeListVirtualHost($virtualHost);
        return $job;
    }

    /**
     * @return JobExchangeList
     */
    public function getJobExchangeList(VirtualHost $virtualHost, ExchangeName $name) : JobExchangeList {
        $job = new JobExchangeList($virtualHost, $name);
        return $job;
    }

    /**
     * @return JobExchangeCreate
     */
    public function getJobCreateExchange(VirtualHost $virtualHost, ExchangeName $name) : JobExchangeCreate {
        $job = new JobExchangeCreate($virtualHost, $name);
        return $job;
    }

    /**
     * @return JobExchangeDelete
     */
    public function getJobDeleteExchange(VirtualHost $virtualHost, ExchangeName $name) : JobExchangeDelete {
        $job = new JobExchangeDelete($virtualHost, $name);
        return $job;
    }

    /**
     * Gets a mapper for the job, if non found it throws an NoMapperForJob exception
     *
     * @param JobBase $job
     * @return BaseMapper
     * @throws NoMapperForJob
     */
    public function getJobMapper(JobBase $job) : BaseMapper {
        $class = get_class($job);
        $class = str_replace('\\jobs\\', '\\mappers\\', $class);
        $class .= 'Mapper';

        try {
            return $this->container->get($class);
        } catch (ServiceNotFoundException $e) {
            throw new NoMapperForJob($job);
        }
    }

    /**
     * @return JobService
     */
    public function getJobService() : JobService {
        return $this->container->get(JobService::class);
    }
}

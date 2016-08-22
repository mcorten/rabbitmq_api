<?php

namespace mcorten87\rabbitmq_api;


use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeCreate;
use mcorten87\rabbitmq_api\jobs\JobExchangeDelete;
use mcorten87\rabbitmq_api\jobs\JobExchangeListAll;
use mcorten87\rabbitmq_api\jobs\JobExchangeList;
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

class MqManagementFactory
{
    const HTTPCLIENT = 'HttpClient';

    const SERVICE_JOB = 'JobService';

    const JOB_RESULT = 'JobResult';

    const JOB_CREATEVHOST = 'JobCreateVhost';
    const JOB_CREATEVHOSTMAPPER = 'JobCreateVhostMapper';

    const JOB_LISTVHOSTS = 'JobListVhosts';
    const JOB_LISTVHOSTSMAPPER = 'JobListVhostsMapper';

    const JOB_LISTVHOST = 'JobListVhost';
    const JOB_LISTVHOSTMAPPER = 'JobListVhostMapper';

    const JOB_DELETEVHOSTS = 'JobDeleteVhosts';
    const JOB_DELETEVHOSTSMAPPER = 'JobDeleteVhostsMapper';

    const JOB_LISTQUEUES = 'JobListQueues';
    const JOB_LISTQUEUESMAPPER = 'JobListQueuesMapper';
    const JOB_LISTQUEUEVIRTUALHOSTMAPPER = 'JobListQueuesVirtualHostMapper';

    const JOB_LISTQUEUE = 'JobListQueue';
    const JOB_LISTQUEUEMAPPER = 'JobListQueueMapper';

    const JOB_CREATEQUEUE = 'JobCreateQueue';
    const JOB_CREATEQUEUEMAPPER = 'JobCreateQueueMapper';

    const JOB_DELETEQUEUEMAPPER = 'JobDeleteQueueMapper';

    const JOB_LISTUSERMAPPER = 'JobListUserMapper';

    const JOB_CREATEUSERMAPPER = 'JobCreateUserMapper';

    const JOB_DELETEUSERMAPPER = 'JobDeleteUserMapper';

    const JOB_LISTPERMISSIONRMAPPER = 'JobListPermissionMapper';

    const JOB_CREATEPERMISSIONRMAPPER = 'JobCreatePermissionMapper';

    const JOB_DELETEPERMISSIONRMAPPER = 'JobDeletePermissionMapper';


    const JOB_LISTEXCHANGEMAPPER = 'JobListExchageMapper';

    const JOB_LISTEXCHANGEVIRTUALHOSTMAPPER = 'JobListExchageVirtualHostMapper';

    const JOB_LISTEXCHANGENAMEMAPPER = 'JobListExchageNameMapper';

    const JOB_CREATEEXCHANGE = 'JobCreateExchangeMapper';

    const JOB_DELETEEXCHANGE = 'JobDeleteExchangeMapper';

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

        $this->container->register(self::HTTPCLIENT, 'GuzzleHttp\Client');

        $this->container->register(self::SERVICE_JOB, 'mcorten87\rabbitmq_api\services\JobService')
            ->addArgument($this)
            ->addArgument($this->container->get(self::HTTPCLIENT))
        ;

        $this->registerJobs();
    }

    protected function registerJobs() {
        // results
        $definition = new Definition('mcorten87\rabbitmq_api\objects\JobResult');
        $definition->setShared(false);
        $this->container->setDefinition(self::JOB_RESULT, $definition);

        // virtual hosts
        $this->container->register(self::JOB_LISTVHOSTMAPPER, 'mcorten87\rabbitmq_api\mappers\JobVirtualHostListMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_CREATEVHOSTMAPPER, 'mcorten87\rabbitmq_api\mappers\JobVirtualHostCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_DELETEVHOSTSMAPPER, 'mcorten87\rabbitmq_api\mappers\JobVirtualHostDeleteMapper')
            ->addArgument($this->config)
        ;

        // queues
        $this->container
            ->register(self::JOB_LISTQUEUESMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueListAllMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_LISTQUEUEVIRTUALHOSTMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueListVirtualHostMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_LISTQUEUEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueListMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_CREATEQUEUEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_DELETEQUEUEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueDeleteMapper')
            ->addArgument($this->config)
        ;

        // users
        $this->container
            ->register(self::JOB_LISTUSERMAPPER, 'mcorten87\rabbitmq_api\mappers\JobUserListMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_CREATEUSERMAPPER, 'mcorten87\rabbitmq_api\mappers\JobUserCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_DELETEUSERMAPPER, 'mcorten87\rabbitmq_api\mappers\JobUserDeleteMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_LISTPERMISSIONRMAPPER, 'mcorten87\rabbitmq_api\mappers\JobPermissionListMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_CREATEPERMISSIONRMAPPER, 'mcorten87\rabbitmq_api\mappers\JobPermissionCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_DELETEPERMISSIONRMAPPER, 'mcorten87\rabbitmq_api\mappers\JobPermissionDeleteMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_LISTEXCHANGEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobExchangeListMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_LISTEXCHANGEVIRTUALHOSTMAPPER, 'mcorten87\rabbitmq_api\mappers\JobExchangeListVirtualHostMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_LISTEXCHANGENAMEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobExchangeListNameMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_CREATEEXCHANGE, 'mcorten87\rabbitmq_api\mappers\JobExchangeCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container
            ->register(self::JOB_DELETEEXCHANGE, 'mcorten87\rabbitmq_api\mappers\JobExchangeDeleteMapper')
            ->addArgument($this->config)
        ;
    }

    /**
     * @param $response
     * @return JobResult
     */
    public function getJobResult($response) : JobResult {
        /** @var JobResult */
        $result = $this->container->get(self::JOB_RESULT);
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
     * @param VirtualHost|null $virtualHost
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
        switch ($job) {
            // virtual host
            case $job instanceof JobVirtualHostList:
                return $this->container->get(self::JOB_LISTVHOSTMAPPER);
            case $job instanceof JobVirtualHostCreate:
                return $this->container->get(self::JOB_CREATEVHOSTMAPPER);
            case $job instanceof JobVirtualHostDelete:
                return $this->container->get(self::JOB_DELETEVHOSTSMAPPER);

            // queue
            case $job instanceof JobQueueListAll:
                return $this->container->get(self::JOB_LISTQUEUESMAPPER);
            case $job instanceof JobQueueListVirtualHost:
                return $this->container->get(self::JOB_LISTQUEUEVIRTUALHOSTMAPPER);
            case $job instanceof JobQueueList:
                return $this->container->get(self::JOB_LISTQUEUEMAPPER);
            case $job instanceof JobQueueCreate:
                return $this->container->get(self::JOB_CREATEQUEUEMAPPER);
            case $job instanceof JobQueueDelete:
                return $this->container->get(self::JOB_DELETEQUEUEMAPPER);

            // user
            case $job instanceof JobUserList:
                return $this->container->get(self::JOB_LISTUSERMAPPER);
            case $job instanceof JobUserCreate:
                return $this->container->get(self::JOB_CREATEUSERMAPPER);
            case $job instanceof JobUserDelete:
                return $this->container->get(self::JOB_DELETEUSERMAPPER);

            // permission
            case $job instanceof JobPermissionListAll:
            case $job instanceof JobPermissionListVirtualHost:
            case $job instanceof JobPermissionListUser:
                return $this->container->get(self::JOB_LISTPERMISSIONRMAPPER);
            case $job instanceof JobPermissionCreate:
                return $this->container->get(self::JOB_CREATEPERMISSIONRMAPPER);
            case $job instanceof JobPermissionDelete:
                return $this->container->get(self::JOB_DELETEPERMISSIONRMAPPER);


            // exchange
            case $job instanceof JobExchangeListAll:
                return $this->container->get(self::JOB_LISTEXCHANGEMAPPER);
            case $job instanceof JobExchangeListVirtualHost:
                return $this->container->get(self::JOB_LISTEXCHANGEVIRTUALHOSTMAPPER);
            case $job instanceof JobExchangeList:
                return $this->container->get(self::JOB_LISTEXCHANGENAMEMAPPER);
            case $job instanceof JobExchangeCreate:
                return $this->container->get(self::JOB_CREATEEXCHANGE);
            case $job instanceof JobExchangeDelete:
                return $this->container->get(self::JOB_DELETEEXCHANGE);


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

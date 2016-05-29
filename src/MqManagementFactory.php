<?php

namespace mcorten87\rabbitmq_api;


use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobPermissionList;
use mcorten87\rabbitmq_api\jobs\JobPermissionUserList;
use mcorten87\rabbitmq_api\jobs\JobPermissionVirtualHostList;
use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\jobs\JobQueuesList;
use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostList;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostsList;
use mcorten87\rabbitmq_api\mappers\BaseMapper;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostCreateMapper;
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

    const JOB_LISTQUEUE = 'JobListQueue';
    const JOB_LISTQUEUEMAPPER = 'JobListQueueMapper';

    const JOB_CREATEQUEUE = 'JobCreateQueue';
    const JOB_CREATEQUEUEMAPPER = 'JobCreateQueueMapper';

    const JOB_DELETEQUEUEMAPPER = 'JobDeleteQueueMapper';

    const JOB_LISTUSERMAPPER = 'JobListUserMapper';

    const JOB_CREATEUSERMAPPER = 'JobCreateUserMapper';

    const JOB_DELETEUSERMAPPER = 'JobDeleteUserMapper';

    const JOB_LISTPERMISSIONRMAPPER = 'JobListPermissionMapper';


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

        $this->container->register(self::SERVICE_JOB,'mcorten87\rabbitmq_api\services\JobService')
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

        $this->container->register(self::JOB_CREATEVHOSTMAPPER, 'mcorten87\rabbitmq_api\mappers\JobVirtualHostCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container->register(self::JOB_DELETEVHOSTSMAPPER, 'mcorten87\rabbitmq_api\mappers\JobVirtualHostDeleteMapper')
            ->addArgument($this->config)
        ;

        // queues
        $this->container->register(self::JOB_LISTQUEUESMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueuesListMapper')
            ->addArgument($this->config)
        ;

        $this->container->register(self::JOB_LISTQUEUEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueListMapper')
            ->addArgument($this->config)
        ;

        $this->container->register(self::JOB_CREATEQUEUEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container->register(self::JOB_DELETEQUEUEMAPPER, 'mcorten87\rabbitmq_api\mappers\JobQueueDeleteMapper')
            ->addArgument($this->config)
        ;

        // users
        $this->container->register(self::JOB_LISTUSERMAPPER, 'mcorten87\rabbitmq_api\mappers\JobUserListMapper')
            ->addArgument($this->config)
        ;

        $this->container->register(self::JOB_CREATEUSERMAPPER, 'mcorten87\rabbitmq_api\mappers\JobUserCreateMapper')
            ->addArgument($this->config)
        ;

        $this->container->register(self::JOB_DELETEUSERMAPPER, 'mcorten87\rabbitmq_api\mappers\JobUserDeleteMapper')
            ->addArgument($this->config)
        ;

        $this->container->register(self::JOB_LISTPERMISSIONRMAPPER, 'mcorten87\rabbitmq_api\mappers\JobPermissionListMapper')
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
     * @return JobVirtualHostList
     */
    public function getJobListVirtualHost(VirtualHost $virtualHost = null) : JobVirtualHostList {
        $job = new JobVirtualHostList();
        if ($virtualHost !== null) { $job->setVirtualHost($virtualHost); }
        return $job;
    }

    /**
     * @param VirtualHost $vhost
     * @return JobVirtualHostCreate
     */
    public function getJobCreateVirtualHost(VirtualHost $virtualHost) : JobVirtualHostCreate {
        /** @var JobVirtualHostCreate $job */
        $job = new JobVirtualHostCreate($virtualHost);
        return $job;
    }

    public function getJobDeleteVirtualHost(VirtualHost $virtualHost) : JobVirtualHostDelete {
        /** @var JobVirtualHostDelete $job */
        $job = new JobVirtualHostDelete($virtualHost);
        return $job;
    }

    public function getJobListQueues(VirtualHost $virtualHost = null) : JobQueuesList {
        /** @var JobQueuesList $job */
        $job = new JobQueuesList();
        if ($virtualHost !== null) { $job->setVirtualhost($virtualHost); }
        return $job;
    }

    public function getJobListQueue(VirtualHost $virtualHost, QueueName $queueName) : JobQueueList {
        $job = new JobQueueList($virtualHost, $queueName);
        return $job;
    }

    public function getJobCreateQueue(VirtualHost $virtualHost, QueueName $queueName) : JobQueueCreate {
        $job = new JobQueueCreate($virtualHost, $queueName);
        return $job;
    }

    public function getJobDeleteQueue(VirtualHost $virtualHost, QueueName $queueName) : JobQueueDelete {
        $job = new JobQueueDelete($virtualHost, $queueName);
        return $job;
    }

    public function getJobListUser(User $user = null) : JobUserList {
        $job = new JobUserList();
        if ($user !== null) { $job->setUser($user); }
        return $job;
    }

    public function getJobCreateUser(User $user, UserTag $userTag, Password $password = null, PasswordHash $passwordHash = null) : JobUserCreate {
        $job = new JobUserCreate($user, $userTag);
        if ($password !== null) { $job->setPassword($password); }
        if ($passwordHash !== null) { $job->setPasswordHash($passwordHash); }
        return $job;
    }

    public function getJobDeleteUser(User $user) : JobUserDelete {
        $job = new JobUserDelete($user);
        return $job;
    }

    public function getJobListPermission() : JobPermissionList {
        $job = new JobPermissionList();
        return $job;
    }

    public function getJobListVirtualHostPermission(VirtualHost $virtualHost) : JobPermissionVirtualHostList {
        $job = new JobPermissionVirtualHostList($virtualHost);
        return $job;
    }

    public function getJobListUserPermission(User $user) : JobPermissionUserList {
        $job = new JobPermissionUserList($user);
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
            case $job instanceof JobVirtualHostsList:
                return $this->container->get(self::JOB_LISTVHOSTSMAPPER);
                break;
            case $job instanceof JobVirtualHostList:
                return $this->container->get(self::JOB_LISTVHOSTMAPPER);
                break;
            case $job instanceof JobVirtualHostCreate:
                return $this->container->get(self::JOB_CREATEVHOSTMAPPER);
                break;
            case $job instanceof JobVirtualHostDelete:
                return $this->container->get(self::JOB_DELETEVHOSTSMAPPER);
                break;

            // queue
            case $job instanceof JobQueuesList:
                return $this->container->get(self::JOB_LISTQUEUESMAPPER);
                break;
            case $job instanceof JobQueueList:
                return $this->container->get(self::JOB_LISTQUEUEMAPPER);
                break;
            case $job instanceof JobQueueCreate:
                return $this->container->get(self::JOB_CREATEQUEUEMAPPER);
                break;
            case $job instanceof JobQueueDelete:
                return $this->container->get(self::JOB_DELETEQUEUEMAPPER);
                break;

            // user
            case $job instanceof JobUserList:
                return $this->container->get(self::JOB_LISTUSERMAPPER);
                break;
            case $job instanceof JobUserCreate:
                return $this->container->get(self::JOB_CREATEUSERMAPPER);
                break;
            case $job instanceof JobUserDelete:
                return $this->container->get(self::JOB_DELETEUSERMAPPER);
                break;
            default:
                throw new NoMapperForJob($job);

            // permission
            case $job instanceof JobPermissionList:
            case $job instanceof JobPermissionVirtualHostList:
            case $job instanceof JobPermissionUserList:
                return $this->container->get(self::JOB_LISTPERMISSIONRMAPPER);
                break;
        }
    }

    /**
     * @return JobService
     */
    public function getJobService() : JobService {
        return $this->container->get(self::SERVICE_JOB);
    }
}

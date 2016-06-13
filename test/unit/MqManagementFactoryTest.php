<?php

namespace mcorten87\rabbitmq_api\test\unit;

use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobPermissionDelete;
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
use mcorten87\rabbitmq_api\mappers\JobPermissionCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionListMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobQueueListMapper;
use mcorten87\rabbitmq_api\mappers\JobQueuesListMapper;
use mcorten87\rabbitmq_api\mappers\JobUserCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobUserDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobUserListMapper;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostListMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\MqManagementFactory;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use mcorten87\rabbitmq_api\test\unit\jobs\mocks\JobDoesNotExist;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 13-6-2016
 * Time: 20:39
 */
class MqManagementFactoryTest extends TestCase
{
    /** @var  MqManagementFactory */
    private $factory;

    /** @var  MqManagementConfig */
    private $config;

    /**
     * MqManagementFactoryTest constructor.
     * setUp gets called after the datapProvicers, in this case it is not good enough
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $url = new Url('http://localhost:15672/api/');
        $user = new User('admin');
        $password = new Password('admin');

        $this->config = new MqManagementConfig($user, $password, $url);

        $factory = new MqManagementFactory();
        $factory->register($this->config);
        $this->factory = $factory;

        parent::__construct($name, $data, $dataName);
    }


    public function providerGetJobMapper() {
        $ret = [];
        $ret = array_merge($ret, $this->providerGetJobVirtaulHostMapper());
        $ret = array_merge($ret, $this->providerGetJobQueueMapper());
        $ret = array_merge($ret, $this->providerGetJobUserMapper());
        $ret = array_merge($ret, $this->providerGetJobPermissionMapper());
        return $ret;
    }

    private function providerGetJobVirtaulHostMapper() {
        $virtualHost = new VirtualHost('/test/');

        return [
            [new JobVirtualHostList(), new JobVirtualHostListMapper($this->config)],
            [new JobVirtualHostCreate($virtualHost), new JobVirtualHostCreateMapper($this->config)],
            [new JobVirtualHostDelete($virtualHost), new JobVirtualHostDeleteMapper($this->config)],
        ];
    }

    private function providerGetJobQueueMapper() {
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName('test');

        return [
            [new JobQueueList($virtualHost, $queueName), new JobQueueListMapper($this->config)],
            [new JobQueuesList(), new JobQueuesListMapper($this->config)],
            [new JobQueueCreate($virtualHost, $queueName), new JobQueueCreateMapper($this->config)],
            [new JobQueueDelete($virtualHost, $queueName), new JobQueueDeleteMapper($this->config)],
        ];
    }

    private function providerGetJobUserMapper() {
        $user = new User('test');
        $userTag = new UserTag(UserTag::MONITORING);

        return [
            [new JobUserList(), new JobUserListMapper($this->config)],
            [new JobUserCreate($user,$userTag), new JobUserCreateMapper($this->config)],
            [new JobUserDelete($user), new JobUserDeleteMapper($this->config)],
        ];
    }

    private function providerGetJobPermissionMapper() {
        $virtualHost = new VirtualHost('/test/');
        $user = new User('test');

        return [
            [new JobPermissionList(), new JobPermissionListMapper($this->config)],
            [new JobPermissionVirtualHostList($virtualHost), new JobPermissionListMapper($this->config)],
            [new JobPermissionUserList($user), new JobPermissionListMapper($this->config)],
            [new JobPermissionCreate($virtualHost, $user), new JobPermissionCreateMapper($this->config)],
            [new JobPermissionDelete($virtualHost, $user), new JobPermissionDeleteMapper($this->config)],
        ];
    }


    /**
     * Tests if we get the right mapper if we insert a job
     *
     * @dataProvider providerGetJobMapper
     */
    public function testGetJobMapper($job, $mapperExpected) {
        $mapper = $this->factory->getJobMapper($job);
        $this->assertTrue(get_class($mapperExpected) === get_class($mapper));
    }

    /**
     * Tests if we get the right mapper if we insert a job
     *
     * @expectedException \mcorten87\rabbitmq_api\exceptions\NoMapperForJob
     */
    public function testNonExistingJob() {
        $job = new JobDoesNotExist();
        $this->factory->getJobMapper($job);
    }
}

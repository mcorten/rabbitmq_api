<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\jobs\JobQueuesList;
use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\mappers\JobQueueDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobQueuesListMapper;
use mcorten87\rabbitmq_api\mappers\JobUserCreateMapper;
use mcorten87\rabbitmq_api\mappers\JobUserDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobUserListMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\PasswordHash;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobUserListMapperTest extends TestCase
{

    /** @var  MqManagementConfig */
    private $config;

    /**
     * MqManagementFactoryTest constructor.
     * setUp gets called after the datapProvicers, in this case it is not good enough
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $url = new Url('http://localhost:15672/api/');
        $user = new User('us@#$%^&*()-=[]\'\;/.,er');
        $password = new Password('passwo@#$%^&*()-=[]\'\;/.,rd');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testBasicJob() {
        $job = new JobUserList();

        $mapper = new JobUserListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('users', $mapResult->getUrl());

        $user = new User('t@#$%^&*()-=[]\'\;/.,est');
        $job->setUser($user);

        $mapResult = $mapper->map($job);

        $this->assertEquals('users/'.urlencode($user), $mapResult->getUrl());
    }

}

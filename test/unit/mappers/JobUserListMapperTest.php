<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\mappers\JobUserListMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
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

        $this->assertEquals(Method::GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('users', $mapResult->getUrl());

        $user = new User('t@#$%^&*()-=[]\'\;/.,est');
        $job->setUser($user);

        $mapResult = $mapper->map($job);

        $this->assertEquals('users/'.urlencode($user), $mapResult->getUrl());
    }

}

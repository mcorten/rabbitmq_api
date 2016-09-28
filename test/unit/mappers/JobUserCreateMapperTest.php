<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\mappers\JobUserCreateMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\PasswordHash;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use PHPUnit\Framework\TestCase;

class JobUserCreateMapperTest extends TestCase
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
        $user = new User('u@#$%^&*()-=[]\'\;/.,ser');
        $password = new Password('passw@#$%^&*()-=[]\'\;/.,ord');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testBasicJob() {
        $user = new User('@#$%^&*()-=[]\'\;/.,test');
        $userTag = new UserTag(UserTag::MONITORING);
        $job = new JobUserCreate($user, $userTag);

        $password = new Password('test@#$%^&*()-=[]\'\;/.,');
        $passwordHash = new PasswordHash('t@#$%^&*()-=[]\'\;/.,est2');
        $job->setPasswordHash($passwordHash);

        $mapper = new JobUserCreateMapper($this->config);
        $mapResult = $mapper->map($job);
        $config = $mapResult->getConfig();

        $this->assertEquals(Method::METHOD_PUT, $mapResult->getMethod()->getValue());
        $this->assertEquals('users/'.urlencode($user), $mapResult->getUrl());
        $this->assertEquals($passwordHash->getValue(), $config['json']['password_hash']);

        // password overrules the passwordhash
        $job->setPassword($password);

        $mapResult = $mapper->map($job);
        $config = $mapResult->getConfig();

        $this->assertEquals($password->getValue(), $config['json']['password']);
        $this->assertTrue(!isset($config['json']['password_hash']));
    }

}

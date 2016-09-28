<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\mappers\JobUserDeleteMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use PHPUnit\Framework\TestCase;

class JobUserDeleteMapperTest extends TestCase
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
        $user = new User('use@#$%^&*()-=[]\'\;/.,r');
        $password = new Password('p@#$%^&*()-=[]\'\;/.,assword');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testBasicJob() {
        $user = new User('test');
        $job = new JobUserDelete($user);

        $mapper = new JobUserDeleteMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_DELETE, $mapResult->getMethod()->getValue());
        $this->assertEquals('users/'.urlencode($user), $mapResult->getUrl());
    }

}

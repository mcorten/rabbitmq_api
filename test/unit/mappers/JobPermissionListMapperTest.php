<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionDelete;
use mcorten87\rabbitmq_api\jobs\JobPermissionList;
use mcorten87\rabbitmq_api\jobs\JobPermissionUserList;
use mcorten87\rabbitmq_api\jobs\JobPermissionVirtualHostList;
use mcorten87\rabbitmq_api\mappers\JobPermissionDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobPermissionListMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use mcorten87\rabbitmq_api\test\unit\jobs\mocks\JobDoesNotExist;
use PHPUnit\Framework\TestCase;

class JobPermissionListMapperTest extends TestCase
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
        $user = new User('user');
        $password = new Password('password');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testJobPermissionList() {
        $job = new JobPermissionList();

        $mapper = new JobPermissionListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('permissions', $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals('application/json', $config['headers']['content-type']);
    }

    public function testJobPermissionVirtualHostList() {
        $virtualHost = new VirtualHost('/test/');
        $job = new JobPermissionVirtualHostList($virtualHost);

        $mapper = new JobPermissionListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('vhosts/%2Ftest%2F/permissions', $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals('application/json', $config['headers']['content-type']);
    }

    public function testJobPermissionUserList() {
        $user = new User('test');
        $job = new JobPermissionUserList($user);

        $mapper = new JobPermissionListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('users/test/permissions', $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals('application/json', $config['headers']['content-type']);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidJob() {
        $job = new JobDoesNotExist();

        $mapper = new JobPermissionListMapper($this->config);
        $mapper->map($job);
    }
}
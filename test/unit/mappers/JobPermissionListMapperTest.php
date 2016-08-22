<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionListAll;
use mcorten87\rabbitmq_api\jobs\JobPermissionListUser;
use mcorten87\rabbitmq_api\jobs\JobPermissionListVirtualHost;
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
        $user = new User('user!@#$%^&*()-=[]\'\;/.,mM<');
        $password = new Password('!@#$%^&*()-=[]\'\;/.,mM<password');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testJobPermissionList() {
        $job = new JobPermissionListAll();

        $mapper = new JobPermissionListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('permissions', $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals('application/json', $config['headers']['content-type']);
    }

    public function testJobPermissionVirtualHostList() {
        $virtualHost = new VirtualHost('/te!@#$%^&*()-=[]\'\;/.,mst/');
        $job = new JobPermissionListVirtualHost($virtualHost);

        $mapper = new JobPermissionListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('vhosts/'.urlencode($virtualHost).'/permissions', $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals('application/json', $config['headers']['content-type']);
    }

    public function testJobPermissionUserList() {
        $user = new User('te!@#$%^&*()-=[]\'\;/.,mst');
        $job = new JobPermissionListUser($user);

        $mapper = new JobPermissionListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('users/'.urlencode($user).'/permissions', $mapResult->getUrl()->getValue());

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

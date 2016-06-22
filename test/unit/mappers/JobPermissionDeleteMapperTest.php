<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionDelete;
use mcorten87\rabbitmq_api\mappers\JobPermissionDeleteMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobPermissionDeleteMapperTest extends TestCase
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


    public function test_basicConfig() {
        $job = new JobPermissionDelete(new VirtualHost('/test/'), new User('test'));

        $mapper = new JobPermissionDeleteMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_DELETE, $mapResult->getMethod()->getValue());
        $this->assertEquals('permissions/'.urlencode($job->getVirtualHost()).'/'.urlencode($job->getUser()), $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals($this->config->getUser(), $config['auth'][0]);
        $this->assertEquals($this->config->getPassword(), $config['auth'][1]);
        $this->assertEquals('application/json', $config['headers']['content-type']);
    }
}

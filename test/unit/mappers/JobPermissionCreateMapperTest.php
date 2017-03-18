<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\mappers\JobPermissionCreateMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobPermissionCreateMapperTest extends TestCase
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
        $user = new User('!@#456us!@#$%^&*()-=[]\'\;/.,mer&*(^%%$');
        $password = new Password('%^*&(passw!@#$%^&*()-=[]\'\;/.,mord+_)(789');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testBasicConfig() {
        $virtualHost = new VirtualHost('/te!@#$%^&*()-=[]\'\;/.,mst/');
        $user = new User('te!@#$%^&*()-=[]\'\;/.,mst');
        $job = new JobPermissionCreate($virtualHost, $user);

        $mapper = new JobPermissionCreateMapper($this->config);
        $mapResult = $mapper->map($job);

        $url = 'permissions/'
            .urlencode($job->getVirtualHost())
            .'/'.urlencode($job->getUser());

        $this->assertEquals(Method::PUT, $mapResult->getMethod()->getValue());
        $this->assertEquals($url, $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals($this->config->getUser(), $config['auth'][0]);
        $this->assertEquals($this->config->getPassword(), $config['auth'][1]);
        $this->assertEquals('application/json', $config['headers']['content-type']);

        $this->assertEquals('.*', $config['json']['configure']);
        $this->assertEquals('.*', $config['json']['write']);
        $this->assertEquals('.*', $config['json']['read']);
    }
}

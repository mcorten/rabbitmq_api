<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\test\unit\jobs\mocks\JobDoesNotExist;
use mcorten87\rabbitmq_api\test\unit\mappers\mocks\Mapper;
use PHPUnit\Framework\TestCase;

class BaseMapperTest extends TestCase
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
        $user = new User('u!@#$%^&*()-=[]\'\;/.,mser');
        $password = new Password('passw!@#$%^&*()-=[]\'\;/.,mord');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testAuth()
    {
        $job = new JobDoesNotExist();

        $mapper = new Mapper($this->config);
        $mapResult = $mapper->map($job);

        $config = $mapResult->getConfig();
        $this->assertEquals($this->config->getUser(), $config['auth'][0]);
        $this->assertEquals($this->config->getPassword(), $config['auth'][1]);
    }
}

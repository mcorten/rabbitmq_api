<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobExchangeDelete;
use mcorten87\rabbitmq_api\mappers\JobExchangeDeleteMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;


class JobExchangeDeleteMapperTest extends TestCase
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


    public function testBasicJob() {
        $virtualHost = new VirtualHost('/t!@#$%^&*()-=[]\'\;/.,mest/');
        $exchangeName = new ExchangeName('t!@#$%^&*()-=[]\'\;/.,mest');
        $job = new JobExchangeDelete($virtualHost, $exchangeName);

        $mapper = new JobExchangeDeleteMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::DELETE, $mapResult->getMethod()->getValue());
        $this->assertEquals('exchanges/'.urlencode($virtualHost).'/'.urlencode($exchangeName), $mapResult->getUrl());
    }
}

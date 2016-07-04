<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\jobs\JobQueuesList;
use mcorten87\rabbitmq_api\mappers\JobQueueDeleteMapper;
use mcorten87\rabbitmq_api\mappers\JobQueuesListMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobQueuesListMapperTest extends TestCase
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
        $job = new JobQueuesList();

        $mapper = new JobQueuesListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('queues', $mapResult->getUrl());
    }

    public function testWIthVirtualHost() {
        $virtualHost = new VirtualHost('/test/');
        $job = new JobQueuesList();
        $job->setVirtualhost($virtualHost);

        $mapper = new JobQueuesListMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals('queues/'.urlencode($virtualHost), $mapResult->getUrl());
    }
}

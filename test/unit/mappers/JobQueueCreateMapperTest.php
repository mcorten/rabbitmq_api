<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\mappers\JobQueueCreateMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobQueueCreateMapperTest extends TestCase
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
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName('test');
        $job = new JobQueueCreate($virtualHost, $queueName);

        $mapper = new JobQueueCreateMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_PUT, $mapResult->getMethod()->getValue());
        $this->assertEquals('queues/%2Ftest%2F/test', $mapResult->getUrl()->getValue());

        $config = $mapResult->getConfig();

        $this->assertEquals('application/json', $config['headers']['content-type']);
        $this->assertFalse($config['json']['auto_delete']);
        $this->assertTrue($config['json']['durable']);
    }

    public function testAutoDeleteAndDureable() {
        $virtualHost = new VirtualHost('/test/');
        $queueName = new QueueName('test');

        $job = new JobQueueCreate($virtualHost, $queueName);
        $job->setDurable(false);
        $job->setAutoDelete(true);

        $mapper = new JobQueueCreateMapper($this->config);
        $mapResult = $mapper->map($job);

        $config = $mapResult->getConfig();

        $this->assertTrue($config['json']['auto_delete']);
        $this->assertFalse($config['json']['durable']);
    }
}

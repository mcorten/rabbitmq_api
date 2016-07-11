<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\mappers\JobQueueCreateMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\QueueArgument;
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
        $user = new User('!@#$%^&*()-=[]\'\;/.,mM<user');
        $password = new Password('passw!@#$%^&*()-=[]\'\;/.,mM<ord');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testJobPermissionList() {
        $virtualHost = new VirtualHost('/te!@#$%^&*()-=[]\'\;/.,mst/');
        $queueName = new QueueName('t!@#$%^&*()-=[]\'\;/.,mest');
        $job = new JobQueueCreate($virtualHost, $queueName);

        $mapper = new JobQueueCreateMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::METHOD_PUT, $mapResult->getMethod()->getValue());
        $this->assertEquals('queues/'
                                .urlencode($virtualHost).'/'
                                .urlencode($queueName)
                            , $mapResult->getUrl()->getValue()
                            );

        $config = $mapResult->getConfig();

        $this->assertEquals('application/json', $config['headers']['content-type']);
        $this->assertFalse($config['json']['auto_delete']);
        $this->assertTrue($config['json']['durable']);

        // test setters
        $job->setDurable(false);
        $job->setAutoDelete(true);

        $mapResult = $mapper->map($job);
        $config = $mapResult->getConfig();

        $this->assertTrue($config['json']['auto_delete']);
        $this->assertFalse($config['json']['durable']);
    }

    public function testAddArguments() {
        $virtualHost = new VirtualHost('/tes!@#$%^&*()-=[]\'\;/.,mt/');
        $queueName = new QueueName('t!@#$%^&*()-=[]\'\;/.,mest');

        $argument1 = new QueueArgument(QueueArgument::MAX_LENGTH, 10);
        $argument2 = new QueueArgument(QueueArgument::MESSAGE_TTL, 1000);

        $job = new JobQueueCreate($virtualHost, $queueName);
        $job->addArgument($argument1);
        $job->addArgument($argument2);

        $arguments = $job->getArguments();
        $this->assertEquals($argument1, $arguments[0]);
        $this->assertEquals($argument2, $arguments[1]);

        $mapper = new JobQueueCreateMapper($this->config);
        $mapResult = $mapper->map($job);

        $config = $mapResult->getConfig();

        $this->assertEquals($argument1->getValue(), $config['json']['arguments'][$argument1->getArgumentName()]);
        $this->assertEquals($argument2->getValue(), $config['json']['arguments'][$argument2->getArgumentName()]);
    }
}

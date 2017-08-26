<?php
use mcorten87\rabbitmq_api\jobs\JobBindingToQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobExchangeCreate;
use mcorten87\rabbitmq_api\jobs\JobExchangeDelete;
use mcorten87\rabbitmq_api\jobs\JobExchangeList;
use mcorten87\rabbitmq_api\jobs\JobExchangeListAll;
use mcorten87\rabbitmq_api\jobs\JobExchangeListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobExchangePublish;
use mcorten87\rabbitmq_api\jobs\JobOverviewList;
use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\objects\DeliveryMode;
use mcorten87\rabbitmq_api\objects\ExchangeArgument;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\Message;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
class OverviewTest extends TestCase
{

    public function testListOverview()
    {
        $job = new JobOverviewList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);

        $this->assertTrue($response->isSuccess());

    }


}

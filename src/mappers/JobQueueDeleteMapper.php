<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueDeleteMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::METHOD_DELETE);
    }

    /**
     * @param JobQueueDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        return new Url('queues/'.urlencode($job->getVirtualhost()).'/'.urlencode($job->getQueueName()));
    }
}

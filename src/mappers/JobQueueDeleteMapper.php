<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueDeleteMapper extends BaseMapper
{

    /**
     * @param JobQueueDelete $job
     * @return Method
     */
    protected function mapMethod(JobQueueDelete $job) : Method {
        return new Method(Method::METHOD_DELETE);
    }

    /**
     * @param JobQueueDelete $job
     * @return Url
     */
    protected function mapUrl(JobQueueDelete $job) : Url {
        return new Url('queues/'.urlencode($job->getVirtualhost()).'/'.urlencode($job->getQueueName()));
    }
}

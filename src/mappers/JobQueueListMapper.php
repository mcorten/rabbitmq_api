<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueListMapper  extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobQueueList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {

        $url = 'queues';
        $url .= '/'.urlencode($job->getVirtualhost());
        $url .= '/'.urlencode($job->getQueueName());

        return new Url($url);
    }
}

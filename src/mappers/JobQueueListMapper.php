<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueListMapper  extends BaseMapper
{

    /**
     * @param JobQueueList $job
     * @return Method
     */
    protected function mapMethod(JobQueueList $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobQueueList $job
     * @return Url
     */
    protected function mapUrl(JobQueueList $job) : Url {

        $url = 'queues';
        $url .= '/'.urlencode($job->getVirtualhost());
        $url .= '/'.urlencode($job->getQueueName());

        return new Url($url);
    }
}

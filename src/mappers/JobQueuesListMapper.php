<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueuesListMapper  extends BaseMapper
{
    protected function mapMethod(JobBase $job) : Method
    {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobQueueList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'queues';
        if ($job->getVirtualhost() !== null) {
            $url .= '/'.urlencode($job->getVirtualhost());
        }
        return new Url($url);
    }
}

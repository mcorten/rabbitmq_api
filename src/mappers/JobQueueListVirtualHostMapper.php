<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueListVirtualHostMapper  extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobQueueListVirtualHostMapper $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'queues';
        $url .= '/'.urlencode($job->getVirtualhost());

        return new Url($url);
    }
}

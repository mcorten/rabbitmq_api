<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueListAll;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueListAllMapper  extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobQueueListAll $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'queues';
        return new Url($url);
    }
}

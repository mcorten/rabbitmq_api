<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingListQueue;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingListQueueMapper  extends BaseMapper
{

    /**
     * @param JobBindingListQueue $job
     * @return Method
     */
    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobBindingListQueue $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'queues';
        $url .= sprintf('/%1$s', urlencode($job->getVirtualHost()));
        $url .= sprintf('/%1$s', urlencode($job->getQueueName()));
        $url .= '/bindings';
        return new Url($url);
    }
}

<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingListExchange;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingListExchangeMapper  extends BaseMapper
{

    /**
     * @param JobBindingListExchange $job
     * @return Method
     */
    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobBindingListExchange $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'exchanges';
        $url .= sprintf('/%1$s', urlencode($job->getVirtualHost()));
        $url .= sprintf('/%1$s', urlencode($job->getExchangeName()));
        $url .= '/bindings/source';
        return new Url($url);
    }
}

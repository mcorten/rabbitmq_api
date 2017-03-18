<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeListVirtualHost;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobExchangeListVirtualHostMapper  extends BaseMapper
{

    protected function mapMethod() : Method {
        return new Method(Method::GET);
    }

    /**
     * @param JobExchangeListVirtualHost $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'exchanges';
        $url .= '/'.urlencode($job->getVirtualHost());
        return new Url($url);
    }
}

<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingListVirtualHost;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingListVirtualHostMapper  extends BaseMapper
{

    /**
     * @param JobBindingListVirtualHost $job
     * @return Method
     */
    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobBindingListVirtualHost $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'bindings';
        $url .= sprintf('/%1$s', urlencode($job->getVirtualHost()));
        return new Url($url);
    }
}

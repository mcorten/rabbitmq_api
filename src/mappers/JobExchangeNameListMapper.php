<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeNameList;
use mcorten87\rabbitmq_api\jobs\JobExchangeVirtualHostList;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobExchangeNameListMapper  extends BaseMapper
{

    /**
     * @param JobUserList $job
     * @return Method
     */
    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobExchangeNameList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'exchanges';
        $url .= '/'.urlencode($job->getVirtualHost());
        $url .= '/'.urlencode($job->getExchangeName());
        return new Url($url);
    }
}

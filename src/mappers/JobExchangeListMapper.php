<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeListAll;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobExchangeListMapper  extends BaseMapper
{

    protected function mapMethod() : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobExchangeListAll $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'exchanges';
        return new Url($url);
    }
}

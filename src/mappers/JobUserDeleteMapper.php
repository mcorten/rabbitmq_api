<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobUserDeleteMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::METHOD_DELETE);
    }


    /**
     * @param JobUserDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'users';
        $url .= '/'.urlencode($job->getUser());

        return new Url($url);
    }
}

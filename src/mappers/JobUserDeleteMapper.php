<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobUserDeleteMapper extends BaseMapper
{

    /**
     * @param JobUserDelete $job
     * @return Method
     */
    protected function mapMethod(JobUserDelete $job) : Method {
        return new Method(Method::METHOD_DELETE);
    }

    /**
     * @param JobUserDelete $job
     * @return Url
     */
    protected function mapUrl(JobUserDelete $job) : Url {
        $url = 'users';
        $url .= '/'.$job->getUser();

        return new Url($url);
    }
}

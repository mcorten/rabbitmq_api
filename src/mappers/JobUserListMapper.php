<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobUserListMapper  extends BaseMapper
{

    /**
     * @param JobUserList $job
     * @return Method
     */
    protected function mapMethod(JobUserList $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobUserList $job
     * @return Url
     */
    protected function mapUrl(JobUserList $job) : Url {

        $url = 'users';
        if ($job->getUser() !== null) { $url .= '/'.$job->getUser(); }

        return new Url($url);
    }
}

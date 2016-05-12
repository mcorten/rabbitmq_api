<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobQueueCreate;
use mcorten87\messagequeue_management\jobs\JobUserCreate;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

class JobUserDeleteMapper extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_DELETE);
    }

    /**
     * @param JobUserCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'users';
        $url .= '/'.$job->getUser();

        return new Url($url);
    }
}

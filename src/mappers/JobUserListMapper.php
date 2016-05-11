<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobQueueList;
use mcorten87\messagequeue_management\jobs\JobUserList;
use mcorten87\messagequeue_management\jobs\JobVirtualHostCreate;
use mcorten87\messagequeue_management\objects\MapResult;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

class JobUserListMapper  extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobUserList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {

        $url = 'users';
        if ($job->getUser() !== null) { $url .= '/'.$job->getUser(); }

        return new Url($url);
    }
}

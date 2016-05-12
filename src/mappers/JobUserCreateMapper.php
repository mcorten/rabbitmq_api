<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobQueueCreate;
use mcorten87\messagequeue_management\jobs\JobUserCreate;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

class JobUserCreateMapper extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_PUT);
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

    /**
     * @param JobUserCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        $password = null;
        if ($job->hasPassword()) { }
        elseif ($job->hasPasswordHash()) { $password = $job->getPasswordHash(); }


        $body = [
            'password'   => (string)$password,
            'tags'       => implode($job->getUserTags(),','),
        ];

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

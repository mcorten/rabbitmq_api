<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobUserCreateMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::PUT);
    }

    /**
     * @param JobUserCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'users';
        $url .= '/'.urlencode($job->getUser());

        return new Url($url);
    }

    /**
     * @param JobUserCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        $body = [
            'tags'       => implode($job->getUserTags(), ','),
        ];

        if ($job->hasPassword()) {
            $body['password'] = $job->getPassword()->getValue();
        }
        elseif ($job->hasPasswordHash()) {
            $body['password_hash'] = $job->getPasswordHash()->getValue();
        }

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

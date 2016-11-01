<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobPermissionListAll;
use mcorten87\rabbitmq_api\jobs\JobPermissionListVirtualHost;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobPermissionListAllMapper extends BaseMapper
{

    protected function mapMethod() : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobPermissionListAll|JobPermissionListVirtualHost $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if (!$job instanceof JobPermissionListAll) {
            throw new \RuntimeException('Invalid parameter type $job');
        }

        $url = 'permissions';
        return new Url($url);
    }
}

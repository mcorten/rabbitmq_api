<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobPermissionList;
use mcorten87\rabbitmq_api\jobs\JobPermissionUserList;
use mcorten87\rabbitmq_api\jobs\JobPermissionVirtualHostList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobPermissionListMapper  extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobPermissionList|JobPermissionVirtualHostList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if ($job instanceof JobPermissionList) {
            return $this->mapPermissionList($job);
        } elseif ($job instanceof JobPermissionVirtualHostList) {
            return $this->mapPermissionVirtualHostList($job);
        } elseif ($job instanceof JobPermissionUserList) {
            return $this->mapPermissionUserList($job);
        } else {
            throw new \RuntimeException('Invalid parameter type $job');
        }
    }

    /**
     * @param JobPermissionList $job
     * @return Url
     */
    private function mapPermissionList(JobPermissionList $job) : Url {
        $url = 'permissions';
        return new Url($url);
    }

    /**
     * @param JobPermissionVirtualHostList $job
     * @return Url
     */
    private function mapPermissionVirtualHostList(JobPermissionVirtualHostList $job) : Url {
        $url = 'vhosts';
        $url .= '/'.urlencode($job->getVirtualHost());
        $url .= '/permissions';
        return new Url($url);
    }

    /**
     * @param JobPermissionUserList $job
     * @return Url
     */
    private function mapPermissionUserList(JobPermissionUserList $job) : Url {
        $url = 'users';
        $url .= '/'.urlencode($job->getUser());
        $url .= '/permissions';
        return new Url($url);
    }
}

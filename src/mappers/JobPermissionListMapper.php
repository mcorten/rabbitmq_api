<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobPermissionListAll;
use mcorten87\rabbitmq_api\jobs\JobPermissionListUser;
use mcorten87\rabbitmq_api\jobs\JobPermissionListVirtualHost;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobPermissionListMapper extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobPermissionListAll|JobPermissionListVirtualHost $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if ($job instanceof JobPermissionListAll) {
            return $this->mapPermissionList();
        } elseif ($job instanceof JobPermissionListVirtualHost) {
            return $this->mapPermissionVirtualHostList($job);
        } elseif ($job instanceof JobPermissionListUser) {
            return $this->mapPermissionUserList($job);
        } else {
            throw new \RuntimeException('Invalid parameter type $job');
        }
    }

    /**
     * @return Url
     */
    private function mapPermissionList() : Url {
        $url = 'permissions';
        return new Url($url);
    }

    /**
     * @param JobPermissionListVirtualHost $job
     * @return Url
     */
    private function mapPermissionVirtualHostList(JobBase $job) : Url {
        $url = 'vhosts';
        $url .= '/'.urlencode($job->getVirtualHost());
        $url .= '/permissions';
        return new Url($url);
    }

    /**
     * @param JobPermissionListUser $job
     * @return Url
     */
    private function mapPermissionUserList(JobBase $job) : Url {
        $url = 'users';
        $url .= '/'.urlencode($job->getUser());
        $url .= '/permissions';
        return new Url($url);
    }
}

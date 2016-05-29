<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\objects\MapResult;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

/**
 * Lists details about a given virtual host
 *
 * Class JobListVirtualHostMapper
 * @package mcorten87\rabbitmq_api\mappers
 */
class JobVirtualHostListMapper extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    protected function mapUrl(JobBase $job) : Url {
        $url = 'vhosts';
        if (!empty($job->hasVirtualHost())) { $url .= '/'.urlencode($job->getVirtaulHost()); }
        return new Url($url);
    }
}

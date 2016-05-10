<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobVirtualHostCreate;
use mcorten87\messagequeue_management\objects\MapResult;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

/**
 * Lists details about a given virtual host
 *
 * Class JobListVirtualHostMapper
 * @package mcorten87\messagequeue_management\mappers
 */
class JobVirtualHostListMapper extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    protected function mapUrl(JobBase $job) : Url {
        return new Url('vhosts/'.urlencode($job->getVirtaulHost()));
    }
}

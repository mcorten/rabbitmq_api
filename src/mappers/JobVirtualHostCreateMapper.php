<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

class JobVirtualHostCreateMapper extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_PUT);
    }

    protected function mapUrl(JobBase $job) : Url {
        return new Url('vhosts/'.urlencode($job->getVirtualHost()));
    }
}

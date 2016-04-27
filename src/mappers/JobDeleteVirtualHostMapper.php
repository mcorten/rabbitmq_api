<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobCreateVirtualHost;
use mcorten87\messagequeue_management\objects\MapResult;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

class JobDeleteVirtualHostMapper extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_DELETE);
    }

    protected function mapUrl(JobBase $job) : Url {
        return new Url('vhosts/'.urlencode($job->getVhost()));
    }

    protected function mapConfig(JobBase $job) : array {
        return $config = [
            'auth'    => array($this->config->getUser(), $this->config->getPassword()),
            'headers'  => ['content-type' => 'application/json'],
        ];
    }
}

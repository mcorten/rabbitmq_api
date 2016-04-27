<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobQueueList;
use mcorten87\messagequeue_management\jobs\JobVirtualHostCreate;
use mcorten87\messagequeue_management\objects\MapResult;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

class JobQueueListMapper  extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobQueueList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {

        $url = 'queues';
        if ($job->getVirtualhost() !== null) {
            $url .= '/'.urlencode($job->getVirtualhost());
            if ($job->getQueueName() !== null) {
                $url .= '/'.urlencode($job->getQueueName());
            }
        }
        return new Url($url);
    }

    protected function mapConfig(JobBase $job) : array {
        return $config = [
            'auth'    => array($this->config->getUser(), $this->config->getPassword()),
        ];
    }
}

<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobExchangeListMapper  extends BaseMapper
{
    protected function mapMethod() : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobExchangeList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if (!$job instanceof JobExchangeList) {
            throw new WrongArgumentException($job, JobExchangeList::class);
        }

        $url = 'exchanges';
        $url .= '/'.urlencode($job->getVirtualHost());
        $url .= '/'.urlencode($job->getExchangeName());
        return new Url($url);
    }
}

<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobVirtualHostCreateMapper extends BaseMapper
{

    /**
     * @param JobVirtualHostCreate $job
     * @return Method
     */
    protected function mapMethod() : Method {
        return new Method(Method::METHOD_PUT);
    }

    /**
     * @param JobVirtualHostCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        return new Url('vhosts/'.urlencode($job->getVirtualHost()));
    }
}

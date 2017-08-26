<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobPermissionDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobPermissionDeleteMapper extends BaseMapper
{

    protected function mapMethod() : Method {
        return new Method(Method::DELETE);
    }

    /**
     * @param JobPermissionDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        return new Url('permissions/'
            .urlencode((string)$job->getVirtualHost())
            .'/'.urlencode((string)$job->getUser())
        );
    }
}

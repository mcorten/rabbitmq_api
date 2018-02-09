<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobVirtualHostCreateMapper extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method
    {
        return new Method(Method::PUT);
    }

    /**
     * @param JobVirtualHostCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        return new Url(
            'vhosts/'
            .urlencode((string)$job->getVirtualHost())
        );
    }
}

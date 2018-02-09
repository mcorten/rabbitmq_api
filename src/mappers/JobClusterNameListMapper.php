<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobClusterNameListMapper extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobBase $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        $url = 'cluster-name';
        return new Url($url);
    }
}

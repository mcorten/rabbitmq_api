<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobDefinitionListVirtualHost;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobDefinitionListVirtualHostMapper extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobDefinitionListVirtualHost $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        $url = sprintf('definitions');
        $url .= sprintf('/%1$s', urlencode((string)$job->getVirtualHost()));
        return new Url($url);
    }
}

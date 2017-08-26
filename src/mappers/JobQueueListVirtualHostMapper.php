<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueListVirtualHost;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueListVirtualHostMapper  extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobQueueListVirtualHost $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'queues';
        $url .= '/'.urlencode((string)$job->getVirtualhost());

        return new Url($url);
    }
}

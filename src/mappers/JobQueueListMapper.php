<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobQueueListMapper  extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobQueueList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {

        $url = 'queues';
        $url .= '/'.urlencode((string)$job->getVirtualhost());
        $url .= '/'.urlencode((string)$job->getQueueName());

        return new Url($url);
    }
}

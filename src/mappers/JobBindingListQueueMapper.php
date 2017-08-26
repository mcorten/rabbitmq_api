<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingListQueue;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingListQueueMapper  extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method {
        return new Method(Method::GET);
    }

    /**
     * @param JobBindingListQueue $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if (!$job instanceof JobBindingListQueue) {
            throw new WrongArgumentException($job, JobBindingListQueue::class);
        }

        $url = 'queues';
        $url .= sprintf('/%1$s', urlencode((string)$job->getVirtualHost()));
        $url .= sprintf('/%1$s', urlencode((string)$job->getQueueName()));
        $url .= '/bindings';
        return new Url($url);
    }
}

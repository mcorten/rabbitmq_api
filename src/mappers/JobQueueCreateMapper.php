<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueCreateMapper extends BaseMapper
{
    protected function mapMethod(JobBase $job) : Method
    {
        return new Method(Method::METHOD_PUT);
    }

    protected function mapUrl(JobBase $job) : Url
    {
        return new Url('queues/'.urlencode($job->getVirtualHost()).'/'.urlencode($job->getQueueName()));
    }

    /**
     * @param JobQueueCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        $body = [
            'auto_delete'   => $job->isAutoDelete(),
            'durable'       => $job->isDurable(),
            'arguments'     => []   // TODO
        ];

        foreach($job->getArguments() as $argument) {
            $body['arguments'][$argument->getArgumentName()] = $argument->getValue();
        };

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

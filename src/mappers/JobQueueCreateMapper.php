<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobQueueCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobQueueCreateMapper extends BaseMapper
{

    /**
     * @param JobQueueCreate $job
     * @return Method
     */
    protected function mapMethod(JobQueueCreate $job) : Method {
        return new Method(Method::METHOD_PUT);
    }

    /**
     * @param JobQueueCreate $job
     * @return Url
     */
    protected function mapUrl(JobQueueCreate $job) : Url {
        return new Url('queues/'.urlencode($job->getVirtualHost()).'/'.urlencode($job->getQueueName()));
    }

    /**
     * @param JobQueueCreate $job
     * @return array
     */
    protected function mapConfig(JobQueueCreate $job) : array {
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

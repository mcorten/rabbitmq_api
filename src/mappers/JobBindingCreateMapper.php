<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JoBindingCreateMapper extends BaseMapper
{
    protected function mapMethod(JobBase $job) : Method
    {
        return new Method(Method::METHOD_POST);
    }

    /**
     * @param JobBindingCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        return new Url('bindings/'
            .urlencode($job->getVirtualHost()).'/'
            .urlencode($job->getQueueName()).'/'
            .urlencode($job->getExchangeName()).'/'
            .urlencode($job->getBindingName())
        );
    }

    /**
     * @param JobBindingCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        $body = [
            'arguments'         => [],
            'destination'       => $job->getQueueName(),    // TODO depends on destination_type
            'destination_type'  => 'q', // TODO add exchange as destination
            'routing_key'       => '',  // TODO
            'source'            => $job->getExchangeName(),
            'vhost'             => $job->getVirtualHost(),
        ];

        foreach ($job->getArguments() as $argument) {
            $body['arguments'][$argument->getArgumentName()] = $argument->getValue();
        };

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

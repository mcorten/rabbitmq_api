<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingToQueueCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingToQueueCreateMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::METHOD_POST);
    }

    /**
     * @param JobBindingToQueueCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        if (!$job instanceof JobBindingToQueueCreate) {
            throw new WrongArgumentException($job, self::class);
        }

        return new Url('bindings/'
            .urlencode($job->getVirtualHost()).'/'
            .'e/'
            .urlencode($job->getExchangeName()).'/'
            .$job->getDestinationType().'/'
            .urlencode($job->getQueueName())
        );
    }

    /**
     * @param JobBindingToQueueCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        if (!$job instanceof JobBindingToQueueCreate) {
            throw new \RuntimeException('Wrong argument');
        }

        $body = [
            'arguments'         => [],
            'destination'       => (string)$job->getQueueName(),
            'destination_type'  => $job->getDestinationType(),
            'routing_key'       => (string)$job->getRoutingKey(),
            'source'            => (string)$job->getExchangeName(),
            'vhost'             => $job->getVirtualHost(),
        ];

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

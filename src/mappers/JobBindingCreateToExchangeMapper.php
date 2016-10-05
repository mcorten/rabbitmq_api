<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingCreateToExchange;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingCreateToExchangeMapper extends BaseMapper
{
    protected function mapMethod(JobBase $job) : Method
    {
        return new Method(Method::METHOD_POST);
    }

    /**
     * @param JobBindingCreateToExchange $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        return new Url('bindings/'
            .urlencode($job->getVirtualHost()).'/'
            .'e/'
            .urlencode($job->getExchangeName()).'/'
            .$job->getDestinationType().'/'
            .urlencode($job->getToExchange())
        );
    }

    /**
     * @param JobBindingCreateToExchange $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        $body = [
            'arguments'         => [],
            'destination'       => (string)$job->getToExchange(),
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

<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingToExchangeCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingToExchangeDeleteMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::METHOD_DELETE);
    }

    /**
     * @param JobBindingToExchangeCreate $job
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
            .'/'.(!empty((string) $job->getRoutingKey()) ? (string) $job->getRoutingKey() : '~')
        );
    }

    /**
     * @param JobBindingToExchangeCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        $body = [
            'destination'       => (string)$job->getToExchange(),
            'destination_type'  => $job->getDestinationType(),
            'properties_key'       => (string)$job->getRoutingKey(),
            'source'            => (string)$job->getExchangeName(),
            'vhost'             => $job->getVirtualHost(),
        ];

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

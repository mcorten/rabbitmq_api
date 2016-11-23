<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingToExchangeCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingToExchangeCreateMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::METHOD_POST);
    }

    /**
     * @param JobBindingToExchangeCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        if (!$job instanceof JobBindingToExchangeCreate) {
            throw new WrongArgumentException($job, JobBindingToExchangeCreate::class);
        }

        return new Url('bindings/'
            .urlencode($job->getVirtualHost()).'/'
            .'e/'
            .urlencode($job->getExchangeName()).'/'
            .$job->getDestinationType().'/'
            .urlencode($job->getToExchange())
        );
    }

    /**
     * @param JobBindingToExchangeCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        if (!$job instanceof JobBindingToExchangeCreate) {
            throw new WrongArgumentException($job, JobBindingToExchangeCreate::class);
        }

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

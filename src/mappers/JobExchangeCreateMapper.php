<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobExchangeCreateMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::METHOD_PUT);
    }

    /**
     * @param JobExchangeCreate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        if (!$job instanceof JobExchangeCreate) {
            throw new WrongArgumentException($job, JobExchangeCreate::class);
        }

        return new Url('exchanges/'.urlencode($job->getVirtualHost()).'/'.urlencode($job->getExchangeName()));
    }

    /**
     * @param JobExchangeCreate $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        if (!$job instanceof JobExchangeCreate) {
            throw new WrongArgumentException($job, JobExchangeCreate::class);
        }

        $body = [
            'auto_delete'   => $job->isAutoDelete(),
            'durable'       => $job->isDurable(),
            'arguments'     => []
        ];

        foreach ($job->getArguments() as $argument) {
            $body['arguments'][$argument->getArgumentName()] = $argument->getValue();
        };

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

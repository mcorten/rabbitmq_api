<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobClusterNameUpdate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobClusterNameUpdateMapper extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method
    {
        return new Method(Method::PUT);
    }

    /**
     * @param JobClusterNameUpdate $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        $url = 'cluster-name';
        return new Url($url);
    }

    /**
     * @param JobClusterNameUpdate $job
     * @return array
     */
    protected function mapConfig(JobBase $job): array
    {
        $body = [
            'name' => $job->getName(),
        ];

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}

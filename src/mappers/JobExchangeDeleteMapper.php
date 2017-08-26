<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobExchangeDeleteMapper  extends BaseMapper
{

    protected function mapMethod() : Method {
        return new Method(Method::DELETE);
    }

    /**
     * @param JobExchangeDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if (!$job instanceof JobExchangeDelete) {
            throw new WrongArgumentException($job, JobExchangeDelete::class);
        }

        $url = 'exchanges';
        $url .= '/'.urlencode((string)$job->getVirtualHost());
        $url .= '/'.urlencode((string)$job->getExchangeName());
        return new Url($url);
    }
}

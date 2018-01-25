<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExtensionsList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobExtensionsListMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobExtensionsList $job
     * @return Url
     * @throws WrongArgumentException
     */
    protected function mapUrl(JobBase $job) : Url
    {
        if (false === $job instanceof JobExtensionsList) {
            throw new WrongArgumentException($job, JobExtensionsList::class);
        }

        $url = 'extensions';
        return new Url($url);
    }
}

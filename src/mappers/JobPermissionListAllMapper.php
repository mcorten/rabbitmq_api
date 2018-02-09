<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobPermissionListAll;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobPermissionListAllMapper extends BaseMapper
{

    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobBase $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        if (!$job instanceof JobPermissionListAll) {
            throw new \RuntimeException('Invalid parameter type $job');
        }

        $url = 'permissions';
        return new Url($url);
    }
}

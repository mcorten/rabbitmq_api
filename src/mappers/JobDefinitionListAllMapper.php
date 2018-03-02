<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobDefinitionListAll;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobDefinitionListAllMapper extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method
    {
        return new Method(Method::GET);
    }

    /**
     * @param JobDefinitionListAll $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        $url = 'definitions';
        return new Url($url);
    }
}

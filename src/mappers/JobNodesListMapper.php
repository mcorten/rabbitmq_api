<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingListAll;
use mcorten87\rabbitmq_api\jobs\JobClusterNameList;
use mcorten87\rabbitmq_api\jobs\JobNodesList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobNodesListMapper extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method {
        return new Method(Method::GET);
    }

    /**
     * @param JobNodesList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'nodes';
        return new Url($url);
    }
}

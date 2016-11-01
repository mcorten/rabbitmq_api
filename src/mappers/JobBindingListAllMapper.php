<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingListAll;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingListAllMapper  extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobBindingListAll $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'bindings';
        return new Url($url);
    }
}

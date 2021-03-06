<?php

namespace mcorten87\rabbitmq_api\test\unit\mappers\mocks;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\mappers\BaseMapper;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class Mapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::PUT);
    }

    protected function mapUrl(JobBase $job) : Url
    {
        return new Url("http://www.test.nl");
    }

}

<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobUserListMapper  extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method {
        return new Method(Method::GET);
    }

    /**
     * @param JobUserList $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {

        $url = 'users';
        if ($job->hasUser()) {
            $url .= '/'.urlencode((string)$job->getUser());
        }

        return new Url($url);
    }
}

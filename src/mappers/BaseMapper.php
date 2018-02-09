<?php
declare(strict_types=1);

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\MapResult;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

abstract class BaseMapper
{
    /** @var MqManagementConfig */
    protected $config;

    public function __construct(MqManagementConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param JobBase $job
     * @return MapResult
     */
    public function map(JobBase $job) : MapResult
    {
        return new MapResult(
            $this->mapMethod(),
            $this->mapUrl($job),
            $this->mapConfig($job)
        );
    }

    /**
     * Created a HTTP method
     *
     * @return Method
     */
    abstract protected function mapMethod() : Method;

    /**
     * Determens which url to call
     *
     * @param JobBase $job
     * @return Url
     * @throws
     */
    abstract protected function mapUrl(JobBase $job) : Url ;

    /**
     * Maps the basic config of every API call
     *
     * @param JobBase $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array
    {
        return [
            'auth'      =>  array($this->config->getUser(), $this->config->getPassword()),
            'headers'   =>  ['content-type' => 'application/json']
        ];
    }
}

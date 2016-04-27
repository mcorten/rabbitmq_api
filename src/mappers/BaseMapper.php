<?php

namespace mcorten87\messagequeue_management\mappers;

use GuzzleHttp\Client;
use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\MqManagementConfig;
use mcorten87\messagequeue_management\objects\MapResult;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;

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
    public function map(JobBase $job) : MapResult {
        return new MapResult(
            $this->mapMethod($job),
            $this->mapUrl($job),
            $this->mapConfig($job)
        );
    }

    abstract protected function mapMethod(JobBase $job) : Method;

    abstract protected function mapUrl(JobBase $job) : Url;

    abstract protected function mapConfig(JobBase $job) : array;
}
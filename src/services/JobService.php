<?php

namespace mcorten87\messagequeue_management\services;

use GuzzleHttp\Client;
use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\MqManagementFactory;
use mcorten87\messagequeue_management\objects\JobResult;

class JobService
{
    /** @var MqManagementFactory */
    private $factory;

    /** @var Client */
    private $client;

    public function __construct(MqManagementFactory $factory, Client $client)
    {
        $this->factory = $factory;
        $this->client = $client;
    }

    /**
     * @param JobBase $job
     * @return JobResult
     * @throws \mcorten87\messagequeue_management\exceptions\NoMapperForJob
     */
    public function execute(JobBase $job) : JobResult {
        $mapper = $this->factory->getJobMapper($job);

        $mapResult = $mapper->map($job);
        $res = $this->client->request($mapResult->getMethod(), $this->factory->getConfig()->getUrl().$mapResult->getUrl(), $mapResult->getConfig());

        $jobResult = $this->factory->getJobResult($res);
        return $jobResult;
    }
}

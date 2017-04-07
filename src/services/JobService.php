<?php

namespace mcorten87\rabbitmq_api\services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\MqManagementFactory;
use mcorten87\rabbitmq_api\objects\JobResult;

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
     * @throws \mcorten87\rabbitmq_api\exceptions\NoMapperForJob
     */
    public function execute(JobBase $job) : JobResult
    {
        $mapper = $this->factory->getJobMapper($job);

        $mapResult = $mapper->map($job);

        try {
            $res = $this->client->request(
                $mapResult->getMethod(),
                $this->factory->getConfig()->getUrl().$mapResult->getUrl(),
                $mapResult->getConfig()
            );

            return new JobResult($res);
        } catch (ClientException $e) {
            return JobResult::populateFromClientException($e);
        }
    }
}

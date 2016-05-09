<?php

namespace mcorten87\messagequeue_management\services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
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

        try {
            $res = $this->client->request($mapResult->getMethod(), $this->factory->getConfig()->getUrl().$mapResult->getUrl(), $mapResult->getConfig());
        } catch (ClientException $e) {
            $data = json_decode($e->getResponse()->getBody());

            // find out what kind of error happend and give some extra help
            if (strpos($data->reason,'inequivalent arg \'durable\'') !== false) {
                $data->cause = 'Queue already exists with different durable stat, delete the queue first';
                $res = new Response($e->getCode(),$e->getResponse()->getHeaders(), json_encode($data));
            } else {
                throw $e;
            }

        }
        $jobResult = $this->factory->getJobResult($res);
        return $jobResult;
    }
}

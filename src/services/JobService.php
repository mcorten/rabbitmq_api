<?php

namespace mcorten87\messagequeue_management\services;

use GuzzleHttp\Client;
use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\MqManagementFactory;

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

    public function execute(JobBase $job) {
        $mapper = $this->factory->getJobCreateVirtualHostMapper();

        $mapResult = $mapper->map($job);
        $res = $this->client->request($mapResult->getMethod(), $this->factory->getConfig()->getUrl().$mapResult->getUrl(), $mapResult->getConfig());

        var_dump($res->getBody()->getContents());
    }
}
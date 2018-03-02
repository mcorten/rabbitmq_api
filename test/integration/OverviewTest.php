<?php

namespace mcorten87\rabbitmq_api\test\integration;

use mcorten87\rabbitmq_api\jobs\JobOverviewList;
use PHPUnit\Framework\TestCase;

class OverviewTest extends TestCase
{

    public function testListOverview()
    {
        $job = new JobOverviewList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);

        $this->assertTrue($response->isSuccess());
    }
}

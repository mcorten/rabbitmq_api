<?php

namespace mcorten87\rabbitmq_api\test\integration;

use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobNodesList;
use PHPUnit\Framework\TestCase;

class NodesTest extends TestCase
{

    /**
     * @throws NoMapperForJob
     * @throws \Exception
     */
    public function testList()
    {
        $job = new JobNodesList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertTrue(isset($body[0]));
    }
}

<?php

namespace mcorten87\rabbitmq_api\test\integration;

use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobExtensionsList;
use PHPUnit\Framework\TestCase;

class ExtensionsTest extends TestCase
{
    /**
     * @throws NoMapperForJob
     */
    public function testList()
    {
        $job = new JobExtensionsList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertTrue(isset($body[0]));

        $this->assertTrue(is_object($body[0]));
    }
}

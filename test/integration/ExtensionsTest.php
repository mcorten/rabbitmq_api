<?php

use mcorten87\rabbitmq_api\exceptions\NoMapperForJob;
use mcorten87\rabbitmq_api\jobs\JobExtensionsList;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
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

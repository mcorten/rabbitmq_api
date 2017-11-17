<?php

use mcorten87\rabbitmq_api\jobs\JobClusterNameList;
use mcorten87\rabbitmq_api\jobs\JobClusterNameUpdate;
use mcorten87\rabbitmq_api\jobs\JobNodesList;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
class NodesTest extends TestCase
{


    public function testListClusterName()
    {
        $job = new JobNodesList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_array($body));
        $this->assertTrue(isset($body[0]));

        $this->assertTrue(is_string($body[0]->os_pid));
        $this->assertNotEmpty($body[0]->os_pid);
    }


}

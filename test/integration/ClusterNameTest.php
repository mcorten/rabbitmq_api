<?php

namespace mcorten87\rabbitmq_api\test\integration;

use mcorten87\rabbitmq_api\jobs\JobClusterNameList;
use mcorten87\rabbitmq_api\jobs\JobClusterNameUpdate;
use PHPUnit\Framework\TestCase;

class ClusterNameTest extends TestCase
{
    public static function tearDownAfterClass()
    {
        $job = new JobClusterNameUpdate('rabbit@ubuntu-zesty');
        Bootstrap::getFactory()->getJobService()->execute($job);
    }

    public function testListClusterName()
    {
        $job = new JobClusterNameList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertTrue(is_string($body->name));
        $this->assertNotEmpty($body->name);

        return $body->name;
    }

    /**
     * @depends testListClusterName
     * @param $currentName
     */
    public function testUpdateClusterName($currentName)
    {
        $newName = $currentName.'1';

        $job = new JobClusterNameUpdate($newName);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $jobListClusterName = new JobClusterNameList();
        $response = Bootstrap::getFactory()->getJobService()->execute($jobListClusterName);
        $body = $response->getBody();
        $this->assertTrue(is_string($body->name));
        $this->assertNotEmpty($body->name);
        $this->assertEquals($newName, $body->name);
    }
}

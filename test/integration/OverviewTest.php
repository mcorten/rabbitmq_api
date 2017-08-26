<?php

use mcorten87\rabbitmq_api\jobs\JobOverviewList;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
class OverviewTest extends TestCase
{

    public function testListOverview()
    {
        $job = new JobOverviewList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);

        $this->assertTrue($response->isSuccess());

    }


}

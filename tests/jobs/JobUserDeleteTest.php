<?php
namespace mcorten87\rabbitmq_api\tests\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobUserDeleteTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function test_dependencyInjection() {
        $user = new User('test');

        $job = new JobUserDelete($user);

        $this->assertEquals($user, $job->getUser());
    }
}

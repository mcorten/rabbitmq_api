<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionUserList;
use mcorten87\rabbitmq_api\objects\User;
use PHPUnit\Framework\TestCase;

class JobPermissionUserListTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection() {
        $user = new User('test');

        $job = new JobPermissionUserList($user);

        $this->assertEquals($user, $job->getUser());
    }
}

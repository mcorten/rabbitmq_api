<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\PasswordHash;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use PHPUnit\Framework\TestCase;

class JobUserCreateTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection() {
        $user = new User('test');
        $tag = new UserTag(UserTag::MONITORING);

        $job = new JobUserCreate($user, $tag);

        $this->assertEquals($user, $job->getUser());
        $this->assertEquals($tag, $job->getUserTags()[0]);
    }

    /**
     * Tests if addUserTag is working like we want it to
     */
    public function testSetters() {
        $user = new User('test');
        $tag1 = new UserTag(UserTag::MONITORING);
        $tag2 = new UserTag(UserTag::ADMINISTRATOR);

        $job = new JobUserCreate($user, $tag1);
        $job->addUserTag($tag2);

        $this->assertEquals($tag1, $job->getUserTags()[0]);
        $this->assertEquals($tag2, $job->getUserTags()[1]);

        $password = new Password('test');
        $job->setPassword($password);
        $this->assertTrue($job->hasPassword());
        $this->assertEquals($password, $job->getPassword());

        $passwordHash = new PasswordHash('test');
        $job->setPasswordHash($passwordHash);
        $this->assertTrue($job->hasPasswordHash());
        $this->assertEquals($passwordHash, $job->getPasswordHash());
    }
}

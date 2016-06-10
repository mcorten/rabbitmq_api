<?php
namespace mcorten87\rabbitmq_api\tests\jobs;

use mcorten87\rabbitmq_api\jobs\JobQueueList;
use mcorten87\rabbitmq_api\jobs\JobQueuesList;
use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\PasswordHash;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobUserCreateTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function test_dependencyInjection() {
        $user = new User('test');
        $tag = new UserTag(UserTag::MONITORING);

        $job = new JobUserCreate($user, $tag);

        $this->assertEquals($user, $job->getUser());
        $this->assertEquals($tag, $job->getUserTags()[0]);
    }

    /**
     * Tests if addUserTag is working like we want it to
     */
    public function test_setters() {
        $user = new User('test');
        $tag1 = new UserTag(UserTag::MONITORING);
        $tag2 = new UserTag(UserTag::ADMINISTRATOR);

        $job = new JobUserCreate($user, $tag1);
        $job->addUserTag($tag2);

        $this->assertEquals($tag1, $job->getUserTags()[0]);
        $this->assertEquals($tag2, $job->getUserTags()[1]);

        $password = new Password('test');
        $job->setPassword($password);
        $this->assertEquals($password, $job->getPassword());

        $passwordHash = new PasswordHash('test');
        $job->setPasswordHash($passwordHash);
        $this->assertEquals($passwordHash, $job->getPasswordHash());
    }
}

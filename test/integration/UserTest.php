<?php

use mcorten87\rabbitmq_api\jobs\JobUserCreate;
use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\PasswordHash;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\UserTag;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 26-3-17
 * Time: 21:14
 */
class UserTest extends TestCase
{
    private static $user;
    private static $userTag;
    private static $password;

    public static function setUpBeforeClass()
    {
        self::$user = new User(sprintf('integration-test-%1$s-%2$s', __CLASS__, time()));
        self::$userTag = new UserTag(UserTag::MONITORING);
        self::$password = new Password(time().rand(1, 1000));
    }

    public static function tearDownAfterClass()
    {
        // clean up the test user that was created
        $job = new JobUserDelete(new User((string)self::$user . '-'));
        Bootstrap::getFactory()->getJobService()->execute($job);
    }

    public function listUser()
    {
        $job = new JobUserList();
        $job->setUser(self::$user);
        return Bootstrap::getFactory()->getJobService()->execute($job);
    }

    public function testListUserEmpty()
    {
        $response = $this->listUser();
        $this->assertFalse($response->isSuccess());
    }

    public function testCreateUser()
    {
        $job = new JobUserCreate(self::$user, self::$userTag);
        $job->setPassword(self::$password);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());
    }

    public function testListUser()
    {
        $response = $this->listUser();
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $this->assertEquals((string)self::$user, $body->name);
        $this->assertEquals((string)self::$userTag, $body->tags);
        $this->assertNotEmpty($body->password_hash);
    }

    public function testCreateUserWithPasswordHash()
    {
        // get the password hash of the current user
        $responseUserList = $this->listUser();
        $this->assertTrue($responseUserList->isSuccess());
        $userListBody = $responseUserList->getBody();

        // create a new user with the same password hash
        $job = new JobUserCreate(new User((string)self::$user . '-'), self::$userTag);
        $job->setPasswordHash(new PasswordHash($userListBody->password_hash));
        $responseUserCreate = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($responseUserCreate->isSuccess());

        // get the new users data
        $responseNewUserList = $this->listUser();
        $this->assertTrue($responseNewUserList->isSuccess());
        $newUserListBody = $responseNewUserList->getBody();

        // make sure the new user has the same password as the old user
        $this->assertEquals((string)self::$user, $newUserListBody->name);
        $this->assertEquals((string)self::$userTag, $newUserListBody->tags);
        $this->assertEquals($userListBody->password_hash, $newUserListBody->password_hash);
    }

    public function testListAllUsers()
    {
        $job = new JobUserList();
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $body = $response->getBody();
        $userFound = false;
        foreach ($body as $user) {
            if ((string)self::$user === $user->name) {
                $userFound = true;
                break;
            }
        }
        $this->assertTrue($userFound);
    }

    public function testDeleteUser()
    {
        $job = new JobUserDelete(self::$user);
        $response = Bootstrap::getFactory()->getJobService()->execute($job);
        $this->assertTrue($response->isSuccess());

        $response = $this->listUser();
        $this->assertFalse($response->isSuccess());
    }
}

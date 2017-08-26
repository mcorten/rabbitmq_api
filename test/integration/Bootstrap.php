<?php

use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\MqManagementFactory;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\services\MqManagermentService;

chdir(__DIR__);
chdir('../../src/');

require '../vendor/autoload.php';

class Bootstrap
{
    private static $factory;

    /**
     * @return MqManagementFactory
     */
    public static function getFactory()
    {
        return self::$factory;
    }

    private static $config;

    /**
     * @return MqManagementConfig
     */
    public static function getConfig()
    {
        return self::$config;
    }

    public static function setup()
    {
        $config = self::setupLocalDev();
        if (getenv('TRAVIS') !== false) {
            $config = self::setupTravis();
        }

        if (getenv('SCRUTINIZER') !== false) {
            $config = self::setupScrutenizer();
        }

        $factory = new MqManagementFactory();
        $mqManagement = new MqManagermentService($factory, $config);

        self::$factory = $factory;
        self::$config = $config;
    }

    private static function setupLocalDev()
    {
        $url = new Url('http://192.168.33.11:15672/api/');
        $user = new User('admin');
        $password = new Password('admin');

        return new MqManagementConfig($user, $password, $url);
    }

    private static function setupTravis()
    {
        $url = new Url('http://127.0.0.1:15672/api/');
        $user = new User('guest');
        $password = new Password('guest');

        return new MqManagementConfig($user, $password, $url);
    }

    private static function setupScrutenizer()
    {
        $url = new Url('http://127.0.0.1:15672/api/');
        $user = new User('guest');
        $password = new Password('guest');

        return new MqManagementConfig($user, $password, $url);
    }
}

Bootstrap::setup();

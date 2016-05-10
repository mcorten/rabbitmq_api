<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 19:09
 */

namespace mcorten87\messagequeue_management\jobs;


use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobVirtualHostList extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /** @return VirtualHost */
    public function getVirtaulHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    public function __construct(VirtualHost $virtualHost)
    {
        $this->virtualHost = $virtualHost;
    }
}

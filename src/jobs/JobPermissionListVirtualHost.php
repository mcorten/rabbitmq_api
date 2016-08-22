<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 21:14
 */

namespace mcorten87\rabbitmq_api\jobs;


use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobPermissionListVirtualHost extends JobBase
{

    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /**
     * @return VirtualHost
     */
    public function getVirtualHost()
    {
        return $this->virtualHost;
    }


    /**
     * @param VirtualHost $virtualHost
     */
    public function __construct(VirtualHost $virtualHost)
    {
        $this->virtualHost = $virtualHost;
    }
}

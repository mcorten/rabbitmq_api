<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 21:14
 */

namespace mcorten87\rabbitmq_api\jobs;


use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobQueueListVirtualHost extends JobBase
{
    private $virtualhost;

    /**
     * @return VirtualHost
     */
    public function getVirtualhost()
    {
        return $this->virtualhost;
    }

    /**
     * @param VirtualHost $virtualhost
     */
    public function __construct(VirtualHost $virtualhost)
    {
        $this->virtualhost = $virtualhost;
    }
}

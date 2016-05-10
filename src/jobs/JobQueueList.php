<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 27-4-2016
 * Time: 21:14
 */

namespace mcorten87\messagequeue_management\jobs;


use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\QueueName;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobQueueList extends JobBase
{
    private $queueName;

    private $virtualhost;

    /**
     * @return QueueName
     */
    public function getQueueName() : QueueName
    {
        return $this->queueName;
    }

    /**
     * @return VirtualHost
     */
    public function getVirtualhost()
    {
        return $this->virtualhost;
    }

    public function __construct(VirtualHost $virtualHost, QueueName $queueName)
    {
        $this->virtualhost = $virtualHost;
        $this->queueName = $queueName;
    }
}

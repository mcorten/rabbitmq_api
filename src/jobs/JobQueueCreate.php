<?php

namespace mcorten87\messagequeue_management\jobs;

use mcorten87\messagequeue_management\objects\Password;
use mcorten87\messagequeue_management\objects\QueueName;
use mcorten87\messagequeue_management\objects\User;
use mcorten87\messagequeue_management\objects\VirtualHost;

class JobQueueCreate extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /**
     * @var QueueName
     */
    private $queueName;

    /**
     * @var bool
     */
    private $autoDelete = false;

    /**
     * @var bool
     */
    private $durable = false;

    // arguments, TODO
    private $maxPriority;
    private $messageTtl;


    /**
     * @param boolean $autoDelete
     */
    public function setAutoDelete($autoDelete)
    {
        $this->autoDelete = $autoDelete;
    }

    /**
     * @param boolean $durable
     */
    public function setDurable($durable)
    {
        $this->durable = $durable;
    }

    /** @return VirtualHost */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    /**
     * @return QueueName
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * @return boolean
     */
    public function isAutoDelete()
    {
        return $this->autoDelete;
    }

    /**
     * @return boolean
     */
    public function isDurable()
    {
        return $this->durable;
    }

    public function __construct(VirtualHost $virtualHost, QueueName $queueName)
    {
        $this->virtualHost = $virtualHost;
        $this->queueName = $queueName;
    }
}

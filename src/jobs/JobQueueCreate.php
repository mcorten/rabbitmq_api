<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;

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

    /**
     * @var QueueArgument[]
     */
    private $arguments = [];


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

    /**
     * @return \mcorten87\rabbitmq_api\objects\QueueArgument[]
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param QueueArgument $newArgument
     */
    public function addArgument(QueueArgument $newArgument)
    {
        $this->arguments[] = $newArgument;
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

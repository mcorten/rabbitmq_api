<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;

/**
 * Lists the details of a specific exchange
 */
class JobBindingListQueue extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /**
     * @var QueueName
     */
    private $queueName;


    /** @return VirtualHost */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    /**
     * @return QueueName
     */
    public function getQueueName(): QueueName
    {
        return $this->queueName;
    }

    public function __construct(VirtualHost $virtualHost, QueueName $queueName)
    {
        $this->virtualHost = $virtualHost;
        $this->queueName = $queueName;
    }
}

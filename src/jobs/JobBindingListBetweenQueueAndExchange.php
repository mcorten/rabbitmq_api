<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;

/**
 * Lists the details of a specific exchange
 */
class JobBindingListBetweenQueueAndExchange extends JobBase
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
     * @var ExchangeName
     */
    private $exchangeName;

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

    /**
     * @return ExchangeName
     */
    public function getExchangeName(): ExchangeName
    {
        return $this->exchangeName;
    }

    public function __construct(VirtualHost $virtualHost, QueueName $queueName, ExchangeName $exchangeName)
    {
        $this->virtualHost = $virtualHost;
        $this->queueName = $queueName;
        $this->exchangeName = $exchangeName;
    }
}

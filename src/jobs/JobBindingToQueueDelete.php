<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\DestinationType;
use mcorten87\rabbitmq_api\objects\Exchange;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobBindingToQueueDelete extends JobBase
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

    /**
     * @var DestinationType
     */
    private $destinationType;

    /**
     * @var RoutingKey
     */
    private $routingKey;

    /**
     * @return VirtualHost
     */
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
    public function getExchangeName()
    {
        return $this->exchangeName;
    }

    /**
     * @return DestinationType
     */
    public function getDestinationType(): string
    {
        return (string)$this->destinationType;
    }

    /**
     * @return RoutingKey
     */
    public function getRoutingKey()
    {
        return $this->routingKey;
    }

    /**
     * JobExchangeCreate constructor.
     * @param VirtualHost $virtualHost
     * @param ExchangeName $exchangeName
     */
    public function __construct(VirtualHost $virtualHost, QueueName $queueName, ExchangeName $exchangeName, RoutingKey $routingKey = null)
    {
        $this->virtualHost = $virtualHost;
        $this->queueName = $queueName;
        $this->exchangeName = $exchangeName;

        $this->destinationType = new DestinationType(DestinationType::QUEUE);
        $this->routingKey = $routingKey !== null ? $routingKey : new RoutingKey('');
    }
}

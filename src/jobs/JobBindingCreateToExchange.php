<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\DestinationType;
use mcorten87\rabbitmq_api\objects\Exchange;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobBindingCreateToExchange extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;


    /**
     * @var ExchangeName
     */
    private $exchange;

    /**
     * @var ExchangeName
     */
    private $toExchange;

    /**
     * @var DestinationType
     */
    private $destinationType;

    /**
     * @var RoutingKey
     */
    private $routingKey;

    /**
     * @param RoutingKey $routingKey
     */
    public function setRoutingKey(RoutingKey $routingKey)
    {
        $this->routingKey = $routingKey;
    }

    /** @return VirtualHost */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    /**
     * @return ExchangeName
     */
    public function getExchangeName()
    {
        return $this->exchangeName;
    }

    /**
     * @return ExchangeName
     */
    public function getToExchange(): ExchangeName
    {
        return $this->toExchange;
    }

    /**
     * @return string
     */
    public function getDestinationType(): string
    {
        return $this->destinationType;
    }

    /**
     * @return mixed
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
    public function __construct(VirtualHost $virtualHost, ExchangeName $exchangeName, ExchangeName $to)
    {
        $this->virtualHost = $virtualHost;
        $this->exchangeName = $exchangeName;
        $this->toExchange = $to;

        $this->destinationType = new DestinationType(DestinationType::EXCHANGE);
        $this->routingKey = new RoutingKey('');
    }
}

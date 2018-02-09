<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\DestinationType;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobBindingToExchangeCreate extends JobBase
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
     * @return VirtualHost
     */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    /**
     * @return ExchangeName
     */
    public function getExchangeName()
    {
        return $this->exchange;
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
        return (string)$this->destinationType;
    }

    /**
     * @return mixed
     */
    public function getRoutingKey()
    {
        return $this->routingKey;
    }

    /**
     * JobBindingToExchangeCreate constructor.
     * @param VirtualHost $virtualHost
     * @param ExchangeName $exchange
     * @param ExchangeName $to
     * @param RoutingKey|null $routingKey
     */
    public function __construct(
        VirtualHost $virtualHost,
        ExchangeName $exchange,
        ExchangeName $to,
        RoutingKey $routingKey = null
    ) {
        $this->virtualHost = $virtualHost;
        $this->exchange = $exchange;
        $this->toExchange = $to;

        $this->destinationType = new DestinationType(DestinationType::EXCHANGE);
        $this->routingKey = $routingKey !== null ? $routingKey : new RoutingKey('');
    }
}

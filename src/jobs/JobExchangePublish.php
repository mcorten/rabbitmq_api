<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\DeliveryMode;
use mcorten87\rabbitmq_api\objects\Exchange;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\Message;
use mcorten87\rabbitmq_api\objects\RoutingKey;
use mcorten87\rabbitmq_api\objects\RoutingKeyUnknown;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobExchangePublish extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /**
     * @var ExchangeName
     */
    private $exchangeName;

    /** @var  DeliveryMode */
    private $deliveryMode;

    /** @var Message */
    private $message;

    /** @var  RoutingKey */
    private $routingKey;

       /** @return VirtualHost */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    /**
     * @return ExchangeName
     */
    public function getExchangeName() : ExchangeName
    {
        return $this->exchangeName;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @return DeliveryMode
     */
    public function getDeliveryMode(): DeliveryMode
    {
        return $this->deliveryMode;
    }

    /**
     * @return RoutingKey
     */
    public function getRoutingKey(): RoutingKey
    {
        return $this->routingKey;
    }

    /**
     * JobExchangeCreate constructor.
     * @param VirtualHost $virtualHost
     * @param ExchangeName $exchangeName
     */
    public function __construct(
        VirtualHost $virtualHost,
        ExchangeName $exchangeName,
        Message $message,
        DeliveryMode $deliveryMode,
        RoutingKey $routingKey = null
    ) {
        if ($routingKey === null) {
            $routingKey = new RoutingKeyUnknown();
        }

        $this->virtualHost = $virtualHost;
        $this->exchangeName = $exchangeName;
        $this->message = $message;

        $this->deliveryMode = $deliveryMode;
        $this->routingKey = $routingKey;
    }
}

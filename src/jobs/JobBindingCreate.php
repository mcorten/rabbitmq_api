<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\Exchange;
use mcorten87\rabbitmq_api\objects\ExchangeArgument;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\QueueName;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobBindingCreate extends JobBase
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
     * @var string
     */
    private $bindingName;


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
    public function getExchangeName()
    {
        return $this->exchangeName;
    }

    /**
     * @return string
     */
    public function getBindingName(): string
    {
        return $this->bindingName;
    }

    /**
     * JobExchangeCreate constructor.
     * @param VirtualHost $virtualHost
     * @param ExchangeName $exchangeName
     */
    public function __construct(VirtualHost $virtualHost, QueueName $queueName, ExchangeName $exchangeName, string $bindingName)
    {
        $this->virtualHost = $virtualHost;
        $this->queueName = $queueName;
        $this->exchangeName = $exchangeName;
        $this->bindingName = $bindingName;
    }
}

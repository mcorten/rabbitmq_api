<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\Exchange;
use mcorten87\rabbitmq_api\objects\ExchangeArgument;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\QueueArgument;
use mcorten87\rabbitmq_api\objects\VirtualHost;

class JobExchangeCreate extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /**
     * @var ExchangeName
     */
    private $exchangeName;

    /**
     * @var bool
     */
    private $autoDelete = false;

    /**
     * @var bool
     */
    private $durable = true;

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
     * @return \mcorten87\rabbitmq_api\objects\ExchangeArgument[]
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param ExchangeArgument $newArgument
     */
    public function addArgument(ExchangeArgument $argument)
    {
        $this->arguments[] = $argument;
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

    /**
     * JobExchangeCreate constructor.
     * @param VirtualHost $virtualHost
     * @param ExchangeName $exchangeName
     */
    public function __construct(VirtualHost $virtualHost, ExchangeName $exchangeName)
    {
        $this->virtualHost = $virtualHost;
        $this->exchangeName = $exchangeName;
    }
}

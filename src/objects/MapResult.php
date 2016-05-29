<?php

namespace mcorten87\rabbitmq_api\objects;

class MapResult
{
    /**
     * @var Method
     */
    private $method;

    /** @return Method */
    public function getMethod() { return $this->method; }

    /**
     * @var Url
     */
    private $url;

    /** @return Url */
    public function getUrl() { return $this->url; }

    /**
     * @var array
     */
    private $config;

    /** @return array */
    public function getConfig() { return $this->config; }

    public function __construct(Method $method, Url $url, array $config)
    {
        $this->method = $method;
        $this->url = $url;
        $this->config = $config;
    }
}

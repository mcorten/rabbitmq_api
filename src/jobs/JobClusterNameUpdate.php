<?php

namespace mcorten87\rabbitmq_api\jobs;

class JobClusterNameUpdate extends JobBase
{
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

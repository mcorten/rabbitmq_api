<?php

namespace mcorten87\rabbitmq_api\objects;

use mcorten87\rabbitmq_api\exceptions\InvalidDataException;

class BaseObject
{
    private $value;

    /**
     * @return mixed
     */
    public function getValue() : string
    {
        return $this->value;
    }


    protected function __construct(String $value)
    {
        $this->value = $value;

        if (!$this->validate($this->value)) {
            throw new InvalidDataException();
        }
    }

    protected function validate($value) : bool {
        return true;
    }

    public function __toString() : string
    {
        return $this->value;
    }

    public function __toInt() : int
    {
        return (int)$this->value;
    }
}

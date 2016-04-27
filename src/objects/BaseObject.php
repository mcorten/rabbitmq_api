<?php

namespace mcorten87\messagequeue_management\objects;

use mcorten87\messagequeue_management\exceptions\InvalidDataException;

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
            throw new InvalidDataException("", $this->value);
        }
    }

    protected function validate($value) : bool {
        return true;
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
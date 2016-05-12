<?php

namespace mcorten87\messagequeue_management\objects;

class PasswordHash extends BaseObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}

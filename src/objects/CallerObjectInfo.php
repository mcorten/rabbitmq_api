<?php

namespace mcorten87\messagequeue_management\objects;

class CallerObjectInfo extends BaseObject
{
    protected $file;

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }


    public function __construct(string $file, string $value)
    {
        $this->file = $file;
        parent::__construct($value);
    }
}
<?php

namespace mcorten87\rabbitmq_api\objects;

class ExchangeArgument extends BaseObject
{
    /**
     * @var integer
     * If messages to this exchange cannot otherwise be routed, send them to the alternate exchange named here.
     */
    const ALTERNATE_EXCHAGE = 'alternate-exchange';


    private $argumentName;

    /**
     * @return String
     */
    public function getArgumentName()
    {
        return $this->argumentName;
    }

    public function __construct(String $argument, string $value)
    {
        $this->argumentName = $argument;

        parent::__construct($value);
    }

    public function validate($value) : bool
    {
        if (empty($this->getArgumentName()) || empty($value)) {
            return false;
        }


        switch ($this->argumentName) {
            case self::ALTERNATE_EXCHAGE:
                return true;

            default:
                return false;
        }
    }
}

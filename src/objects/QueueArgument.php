<?php

namespace mcorten87\rabbitmq_api\objects;

class QueueArgument extends BaseObject
{
    /**
     * @var integer
     * How long a message published to a queue can live before it is discarded (milliseconds).
     */
    const MESSAGE_TTL = 'message-ttl';

    /**
     * @var integer
     * How long a queue can be unused for before it is automatically deleted (milliseconds).
     */
    const EXPIRES = 'expires';

    /**
     * @var integer
     * How many (ready) messages a queue can contain before it starts to drop them from its head.
     */
    const MAX_LENGTH = 'max-length';

    /**
     * @var integer
     * Total body size for ready messages a queue can contain before it starts to drop them from its head.
     */
    const MAX_BYTES = 'max-length-bytes';

    /**
     * @var string
     * Name of an exchange to which messages will be republished if they are rejected or expire.
     */
    const MAX_DEAD_LETTER_EXCHAGE = 'dead-letter-exchange';

    /**
     * @var string
     * Replacement routing key to use when a message is dead-lettered. If this is not set, the message's original routing key will be used.
     */
    const MAX_DEAD_LETTER_ROUTING_KEY = 'dead-letter-routing-key';

    /**
     * @var integer
     * Maximum number of priority levels for the queue to support;
     *      if not set, the queue will not support message priorities.
     */
    const MAX_PRIORITY = 'max-priority';

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
        if (empty($this->getArgumentName())) {
            return false;
        }

        switch ($this->argumentName) {
            case self::MESSAGE_TTL:
            case self::EXPIRES:
            case self::MAX_LENGTH:
            case self::MAX_BYTES:
            case self::MAX_PRIORITY:
                return is_numeric($this->getValue()) && $this->getValue() >= 0;

            case self::MAX_DEAD_LETTER_EXCHAGE:
            case self::MAX_DEAD_LETTER_ROUTING_KEY:
                return !empty($value);

            default:
                return false;
        }
    }
}

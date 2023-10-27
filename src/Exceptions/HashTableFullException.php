<?php


namespace PHPAlchemist\Exceptions;


/**
 * When a HashTable has reached the fixed limit and an attempt to add data has been made.
 *
 * @package PHPAlchemist\Exceptions;
 */
class HashTableFullException extends \Exception
{
    const ERROR_UNMATCHED_CLASS = "HashTable data has reached defined limit.";


    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if( empty($message))
            $this->message = self::ERROR_UNMATCHED_CLASS;

        parent::__construct($message, $code, $previous);
    }

}
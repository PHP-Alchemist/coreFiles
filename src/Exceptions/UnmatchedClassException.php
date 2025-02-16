<?php

namespace PHPAlchemist\Exceptions;

/**
 * When a deserialized object doesn't match the deserializing class.
 */
class UnmatchedClassException extends \Exception
{
    const ERROR_UNMATCHED_CLASS = 'Unmatched class type on deserialization';

    public function __construct(
        $message = self::ERROR_UNMATCHED_CLASS,
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

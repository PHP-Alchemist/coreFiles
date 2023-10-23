<?php

namespace PHPAlchemist\Core\Exceptions;

class UnmatchedClassException extends \Exception
{
    const ERROR_UNMATCHED_CLASS = "Unmatched class type on deserialization";

    public function __construct(string $message = self::ERROR_UNMATCHED_CLASS, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
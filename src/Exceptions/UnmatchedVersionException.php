<?php

namespace PHPAlchemist\Exceptions;

/**
 * When a deserialized object doesn't match the deserializing version
 *
 * @package PHPAlchemist\Exceptions;
 */
class UnmatchedVersionException extends \Exception
{
    const ERROR_WRONG_VERSION = "Unmatched version on deserialization";

    public function __construct(string $message = self::ERROR_WRONG_VERSION, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php

namespace PHPAlchemist\Exceptions;

/**
 * When a deserialized object doesn't match the deserializing version.
 *
 * @package PHPAlchemist\Exception
 */
class UnmatchedVersionException extends \Exception
{
    const ERROR_WRONG_VERSION = 'Unmatched version on deserialization';

    public function __construct(
        $message = self::ERROR_WRONG_VERSION,
        $code = 0,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

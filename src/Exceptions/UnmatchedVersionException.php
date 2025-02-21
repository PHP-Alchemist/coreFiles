<?php

namespace PHPAlchemist\Exceptions;

/**
 * When a deserialized object doesn't match the deserializing version.
 */
class UnmatchedVersionException extends \Exception
{
    const ERROR_WRONG_VERSION = 'Unmatched version on deserialization';

    public function __construct(
        #[LanguageLevelTypeAware(['8.0' => 'string'], default: self::ERROR_WRONG_VERSION)] $message = self::ERROR_WRONG_VERSION,
        #[LanguageLevelTypeAware(['8.0' => 'int'], default: '')] $code = 0,
        #[LanguageLevelTypeAware(['8.0' => 'Throwable|null'], default: 'Throwable')] $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

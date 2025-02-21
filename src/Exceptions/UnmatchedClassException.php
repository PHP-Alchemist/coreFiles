<?php

namespace PHPAlchemist\Exceptions;

/**
 * When a deserialized object doesn't match the deserializing class.
 */
class UnmatchedClassException extends \Exception
{
    const ERROR_UNMATCHED_CLASS = 'Unmatched class type on deserialization';

    public function __construct(
        #[LanguageLevelTypeAware(['8.0' => 'string'], default: self::ERROR_UNMATCHED_CLASS)] $message = self::ERROR_UNMATCHED_CLASS,
        #[LanguageLevelTypeAware(['8.0' => 'int'], default: '')] $code = 0,
        #[LanguageLevelTypeAware(['8.0' => 'Throwable|null'], default: 'Throwable')] $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

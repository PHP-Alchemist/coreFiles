<?php

namespace PHPAlchemist\Exceptions;

/**
 * When a HashTable has reached the fixed limit and an attempt to add data has been made.
 */
class HashTableFullException extends \Exception
{
    const ERROR_UNMATCHED_CLASS = 'HashTable data has reached defined limit.';

    public function __construct(
        #[LanguageLevelTypeAware(['8.0' => 'string'], default: self::ERROR_UNMATCHED_CLASS)] $message = self::ERROR_UNMATCHED_CLASS,
        #[LanguageLevelTypeAware(['8.0' => 'int'], default: '')] $code = 0,
        #[LanguageLevelTypeAware(['8.0' => 'Throwable|null'], default: 'Throwable')] $previous = null
    ) {
        if (empty($message)) {
            $this->message = self::ERROR_UNMATCHED_CLASS;
        }

        parent::__construct($message, $code, $previous);
    }
}

<?php

namespace PHPAlchemist\Exceptions;

class BadJsonException extends \Exception
{
    const DEFAULT_MESSAGE = 'Invalid JSON';

    public function __construct(
      $message = self::DEFAULT_MESSAGE,
      $code = 0,
      $previous = null
    ) {
        if (empty($message)) {
            $this->message = self::DEFAULT_MESSAGE;
        }

        parent::__construct($message, $code, $previous);
    }
}
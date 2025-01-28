<?php

namespace PHPAlchemist\ValueObjects\Model;

use InvalidArgumentException;
use PHPAlchemist\Types\Twine;
use PHPAlchemist\ValueObjects\Abstracts\AbstractString;

final class Email extends AbstractString
{
    public function __construct(protected string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address.");
        }
    }
    public function getDomain() : Twine
    {
        $parts = explode('@', $this->value, 2);

        return new Twine(array_pop($parts));
    }

    public function getTLD() : Twine
    {
        $parts = explode('.', $this->value);

        return new Twine(array_pop($parts));
    }
}
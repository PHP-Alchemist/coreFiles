<?php

namespace PHPAlchemist\ValueObject\Model;

use InvalidArgumentException;
use PHPAlchemist\Types\Twine;
use PHPAlchemist\ValueObject\Abstract\AbstractString;

final class Email extends AbstractString
{
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address.');
        }

        $this->value = $value;
    }

    public function getUser() : Twine
    {
        $parts = explode('@', $this->value, 2);

        return new Twine(array_shift($parts));
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

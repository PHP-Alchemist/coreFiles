<?php

namespace PHPAlchemist\ValueObject\Model;

use InvalidArgumentException;
use PHPAlchemist\Type\Twine;
use PHPAlchemist\ValueObject\Abstract\AbstractVOString;

final class Email extends AbstractVOString
{
    private const string INVALID_EMAIL_MESSAGE = 'Invalid email address: %s';

    public function __construct(string $value)
    {
        $this->validateEmail($value);
        $this->value = $value;
    }

    private function validateEmail(string $email) : void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf(self::INVALID_EMAIL_MESSAGE, $email)
            );
        }
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

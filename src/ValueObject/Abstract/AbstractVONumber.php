<?php

namespace PHPAlchemist\ValueObject\Abstract;

use PHPAlchemist\ValueObject\Contract\VONumberInterface;

abstract class AbstractVONumber implements VONumberInterface
{
    protected readonly int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function equals(VONumberInterface $number) : bool
    {
        if (
            $number === $this
            && $number->getValue() === $this->getValue()
        ) {
            return true;
        }

        return false;
    }

    public function getValue() : int|float
    {
        return $this->value;
    }
}

<?php

namespace PHPAlchemist\ValueObjects\Abstracts;

use PHPAlchemist\ValueObjects\Contracts\VONumberInterface;

abstract readonly class AbstractNumber implements VONumberInterface
{
    public function getValue() : int|float
    {
        return $this->value;
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

}
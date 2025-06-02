<?php

namespace PHPAlchemist\ValueObject\Abstract;

use PHPAlchemist\ValueObject\Contract\VONumberInterface;

abstract class AbstractVONumber implements VONumberInterface
{
    /**
     * Below is the value store for the VO Number object. In v3.0 this will be protected readonly.
     * Currently, this is only set to maintain compatibility for v2.x.
     *
     * @var int $value the value store for the VO Number object
     */
    // PHP 8.4+ ONLY -> protected readonly int $value;
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

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

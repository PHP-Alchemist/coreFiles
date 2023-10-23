<?php

namespace PHPAlchemist\Core\Type\Base;

use PHPAlchemist\Core\Type\Base\Contracts\NumberInterface;

class AbstractNumber implements NumberInterface
{
    private int|float $data;

    public function __construct(int|float $number)
    {
        $this->data = $number;
    }

    public function get(): int|float
    {
        return $this->data;
    }

    public function __toString(): string
    {
        return (string)$this->data;
    }
}
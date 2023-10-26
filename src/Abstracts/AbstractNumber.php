<?php

namespace PHPAlchemist\Abstracts;

use PHPAlchemist\Contracts\NumberInterface;

/**
 * Abstract Class for Number classes
 * @package PHPAlchemist\Abstracts
 */
abstract class AbstractNumber implements NumberInterface
{
    private int|float $data;

    public function __construct(int|float $number)
    {
        $this->data = $number;
    }

    public function get() : int|float
    {
        return $this->data;
    }

    public function __toString() : string
    {
        return (string)$this->data;
    }
}
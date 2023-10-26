<?php

namespace PHPAlchemist\Type\Base;

use PHPAlchemist\Type\Base\Contracts\NumberInterface;

/**
 * @package PHPAlchemist\Type\Base
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
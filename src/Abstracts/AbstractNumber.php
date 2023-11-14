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

    /**
     * Return Number value
     *
     * @return int|float
     */
    public function get() : int|float
    {
        return $this->data;
    }

    /**
     * Add to Number value
     *
     * @param int|float $number
     * @return void
     */
    public function add(int|float $number) : void
    {
        $this->data += $number;
    }

    /**
     * Subtract from Number Value
     *
     * @param int|float $number
     * @return void
     */
    public function subtract(int|float $number) : void
    {
       $this->data -= $number;
    }

    /**
     * Perform modulus operation (division remainder) of number divided by
     * input.
     *
     * @param int|float $divideBy
     * @return int
     */
    public function modulus(int|float $divideBy) : int
    {
        return  $this->data % $divideBy;
    }

    public function __toString() : string
    {
        return (string)$this->data;
    }
}
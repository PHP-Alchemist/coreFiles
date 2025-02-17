<?php

namespace PHPAlchemist\Contract;

/**
 * @package PHPAlchemist\Contract
 */
interface NumberInterface
{
    public function get() : int|float;

    public function add(int|float $number) : void;

    public function equals(int|float $number) : bool;

    public function subtract(int|float $number) : void;

    public function modulus(int|float $divideBy) : int;
}

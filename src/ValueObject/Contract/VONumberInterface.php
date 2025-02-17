<?php

namespace PHPAlchemist\ValueObject\Contract;

/**
 * @package PHPAlchemist\Contract
 */
interface VONumberInterface
{
    public function getValue() : int|float;

    public function equals(self $number) : bool;
}
<?php

namespace PHPAlchemist\ValueObjects\Contracts;

/**
 * @package PHPAlchemist\Contracts
 */
interface VONumberInterface
{
    public function getValue() : int|float;

    public function equals(self $number) : bool;
}
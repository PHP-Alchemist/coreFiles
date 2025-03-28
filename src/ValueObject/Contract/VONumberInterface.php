<?php

namespace PHPAlchemist\ValueObject\Contract;

interface VONumberInterface
{
    public function getValue() : int|float;

    public function equals(self $number) : bool;
}

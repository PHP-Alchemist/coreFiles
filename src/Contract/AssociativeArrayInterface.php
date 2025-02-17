<?php

namespace PHPAlchemist\Contract;

/**
 * Array
 * @package PHPAlchemist\Contract
 */
interface AssociativeArrayInterface extends ArrayInterface
{
    public function add(mixed $key, mixed $value) : AssociativeArrayInterface;

    public function get(mixed $key) : mixed;

    public function getKeys() : array;

    public function getValues() : array;

    public function count() : int;

    public function isReadOnly() : bool;
}

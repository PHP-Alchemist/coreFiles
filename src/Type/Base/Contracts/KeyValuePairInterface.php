<?php

namespace PHPAlchemist\Type\Base\Contracts;

use ArrayAccess;
use Iterator;

/**
 * @package PHPAlchemist\Type\Base\Contracts
 */
interface KeyValuePairInterface extends ArrayAccess, Iterator
{
    // Iterator
    function current(): mixed;

    function key(): mixed;

    function next(): void;

    // Not part of Iterator
    function prev(): void;

    function valid(): bool;

    function rewind(): void;
    // END Iterator

    // ArrayAccess
    function offsetUnset($offset): void;

    function offsetSet($offset, $value): void;

    function offsetGet($offset): mixed;

    function offsetExists($offset): bool;
    // END ArrayAccess

    // Class Specific
    function setData(array $data): KeyValuePairInterface;

    function getData(): array;

    function count(): int;

    function add($key, $value): KeyValuePairInterface;

    function set($key, $value): KeyValuePairInterface;

    function get($key): mixed;

    function getKeys(): array;

    function getValues(): array;


}
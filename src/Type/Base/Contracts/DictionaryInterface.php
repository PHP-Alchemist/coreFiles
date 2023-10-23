<?php

namespace PHPAlchemist\Core\Type\Base\Contracts;

use ArrayAccess;
use Iterator;

interface DictionaryInterface extends ArrayAccess, Iterator
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
    function setData(array $data): DictionaryInterface;

    function getData(): array;

    function count(): int;

    function add($key, $value): DictionaryInterface;

    function set($key, $value): DictionaryInterface;

    function get($key): mixed;

    function getKeys(): array;

    function getValues(): array;


}
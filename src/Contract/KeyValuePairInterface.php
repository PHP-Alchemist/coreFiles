<?php

namespace PHPAlchemist\Contract;

/**
 * Key Value Pair Interface.
 */
interface KeyValuePairInterface extends ArrayInterface
{
    // Iterator
    public function current(): mixed;

    public function key(): mixed;

    public function next(): void;

    // Not part of Iterator
    public function prev(): void;

    public function valid(): bool;

    public function rewind(): void;
    // END Iterator

    // ArrayAccess
    public function offsetUnset($offset): void;

    public function offsetSet($offset, $value): void;

    public function offsetGet($offset): mixed;

    public function offsetExists($offset): bool;
    // END ArrayAccess

    // Class Specific
    public function setData(array $data): KeyValuePairInterface;

    public function getData(): array;

    public function count(): int;

    public function add($key, $value): KeyValuePairInterface;

    public function set($key, $value): KeyValuePairInterface;

    public function get($key): mixed;

    public function getKeys(): array;

    public function getValues(): array;

    public function isEmpty() : bool;
}

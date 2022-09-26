<?php

namespace PHPAlchemist\Type\Base\Contracts;

use ArrayAccess;
use Iterator;

interface CollectionInterface extends ArrayAccess, Iterator
{


    // Iterator
    function current() : mixed;

    function key() : mixed;

    function next() : void;

    // Not part of Iterator
    function prev() : void;

    function valid() : bool;

    function rewind() : void;
    // END Iterator

    // ArrayAccess
    function offsetUnset(mixed $offset) : void;

    function offsetSet(mixed $offset, mixed $value) : void;

    function offsetGet(mixed $offset) : mixed;

    function offsetExists(mixed $offset) : bool;
    // END ArrayAccess

    // Class Specific
    function setData(array $data) : CollectionInterface;

    function isStrict() : bool;

    function count(): int;
}

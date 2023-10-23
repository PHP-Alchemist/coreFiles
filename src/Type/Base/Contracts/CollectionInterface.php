<?php

namespace PHPAlchemist\Core\Type\Base\Contracts;

use ArrayAccess;
use Iterator;

interface CollectionInterface extends ArrayAccess, Iterator
{
    // Class Specific
    function setData(array $data) : CollectionInterface;

    function isStrict() : bool;

    function count() : int;

    function push(mixed $data) : CollectionInterface;

    function add(mixed $data) : CollectionInterface;

    function pop() : mixed;

    function get(mixed $key) : mixed;


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

    function first() : mixed;

}

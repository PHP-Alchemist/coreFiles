<?php


namespace PHPAlchemist\Type\Base\Contracts;

use ArrayAccess;
use Iterator;

/**
 * Array
 * @package PHPAlchemist\Type\Base\Contracts
 */
interface AssociativeArrayInterface extends ArrayAccess, Iterator
{
    function add($key, $value) : AssociativeArrayInterface;

    function get($key) : mixed;

    function getKeys() : array;

    function getValues() : array;

    function count() : int;

    function isReadOnly() : bool;

    // Iterator
    function rewind() : void;

    function valid() : bool;

    function key() : mixed;

    function next() : void;

    // not part of Iterator
    function prev() : void;

    function current() : mixed;
    // END Iterator

    // ArrayAccess
    function offsetUnset($offset) : void;

    function offsetSet($offset, $value) : void;

    function offsetGet($offset) : mixed;

    function offsetExists($offset) : bool;
    // END ArrayAccess

}
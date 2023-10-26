<?php

namespace PHPAlchemist\Type\Base\Contracts;

use ArrayAccess;
use Iterator;

/**
 *
 * @package PHPAlchemist\Type\Base\Contracts
 */
interface CollectionInterface extends ArrayAccess, Iterator
{
    // Class Specific
    /**
     * @param array $data
     * @return CollectionInterface
     */
    function setData(array $data) : CollectionInterface;

    /**
     * @return bool
     */
    function isStrict() : bool;

    /**
     * @return int
     */
    function count() : int;

    /**
     * @param mixed $data
     * @return CollectionInterface
     */
    function push(mixed $data) : CollectionInterface;

    /**
     * @param mixed $data
     * @return CollectionInterface
     */
    function add(mixed $data) : CollectionInterface;

    /**
     * @return mixed
     */
    function pop() : mixed;

    /**
     * @param mixed $key
     * @return mixed
     */
    function get(mixed $key) : mixed;


    // Iterator

    /**
     * @inheritDoc
     */
    function current() : mixed;

    /**
     * @inheritDoc
     */
    function key() : mixed;

    /**
     * @inheritDoc
     */
    function next() : void;

    // Not part of Iterator

    /**
     * Move forward to previous element
     *
     * @return void Any returned value is ignored.
     */
    function prev() : void;

    /**
     * @return bool
     */
    function valid() : bool;

    /*
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    /**
     * @return void
     */
    function rewind() : void;
    // END Iterator

    // ArrayAccess
    /**
     * @inheritDoc
     */
    function offsetUnset(mixed $offset) : void;

    /**
     * @inheritDoc
     */
    function offsetSet(mixed $offset, mixed $value) : void;

    /**
     * @inheritDoc
     */
    function offsetGet(mixed $offset) : mixed;

    /**
     * @inheritDoc
     */
    function offsetExists(mixed $offset) : bool;

    // END ArrayAccess

    /**
     * Returns the first element of the collection
     *
     * @return mixed
     */
    function first() : mixed;

}

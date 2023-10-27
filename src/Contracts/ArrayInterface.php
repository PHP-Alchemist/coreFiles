<?php

namespace PHPAlchemist\Contracts;

use ArrayAccess;
use Iterator;

/**
 * Parental Array Interface
 * @package PHPAlchemist\Contracts
 */
interface ArrayInterface extends ArrayAccess, Iterator
{
    // Iterator
    /**
     * @inheritDoc
     */
    function valid() : bool;

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

    /**
     * Move forward to previous element
     *
     * @return void Any returned value is ignored.
     */
    function prev() : void;


    // ArrayAccess
    /**
     * @inheritDoc
     */
    function offsetUnset($offset) : void;

    /**
     * @inheritDoc
     */
    function offsetSet($offset, $value) : void;

    /**
     * @inheritDoc
     */
    function offsetGet($offset) : mixed;

    /**
     * @inheritDoc
     */
    function offsetExists($offset) : bool;
    // END ArrayAccess
}
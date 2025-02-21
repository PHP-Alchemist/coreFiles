<?php

namespace PHPAlchemist\Contracts;

use ArrayAccess;
use Iterator;

/**
 * Parental Array Interface.
 *
 * @template-extends  ArrayAccess<int, mixed>
 * @template-extends  Iterator<mixed, mixed>
 */
interface ArrayInterface extends ArrayAccess, Iterator
{
    // region Additions
    public function extract(mixed $key) : mixed;

    /**
     * Move forward to previous element.
     *
     * @return void Any returned value is ignored.
     */
    public function prev() : void;

    // endregion

    // region Iterator
    /**
     * @inheritDoc
     */
    public function valid() : bool;

    /**
     * @inheritDoc
     */
    public function current() : mixed;

    /**
     * @inheritDoc
     */
    public function key() : mixed;

    /**
     * @inheritDoc
     */
    public function next() : void;

    /*
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    /**
     * @return void
     */
    public function rewind() : void;

    // endregion Iterator

    // region ArrayAccess
    /**
     * @inheritDoc
     */
    public function offsetUnset($offset) : void;

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value) : void;

    /**
     * @inheritDoc
     */
    public function offsetGet($offset) : mixed;

    /**
     * @inheritDoc
     */
    public function offsetExists($offset) : bool;
    // endregion ArrayAccess
}

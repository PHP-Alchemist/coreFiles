<?php

namespace PHPAlchemist\Contracts;

interface IndexedArrayInterface extends ArrayInterface
{
    // Class Specific
    /**
     * @param array $data
     *
     * @return IndexedArrayInterface
     */
    public function setData(array $data) : IndexedArrayInterface;

    /**
     * @return bool
     */
    public function isStrict() : bool;

    /**
     * @return int
     */
    public function count() : int;

    /**
     * @param mixed $data
     *
     * @return IndexedArrayInterface
     */
    public function push(mixed $data) : IndexedArrayInterface;

    /**
     * @param mixed $data
     *
     * @return IndexedArrayInterface
     */
    public function add(mixed $data) : IndexedArrayInterface;

    /**
     * @return mixed
     */
    public function pop() : mixed;

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function get(mixed $key) : mixed;

    /**
     * Returns the first element of the collection.
     *
     * @return mixed
     */
    public function first() : mixed;

    /**
     * Tells if the object is empty.
     *
     * @return bool
     */
    public function isEmpty() : bool;
}

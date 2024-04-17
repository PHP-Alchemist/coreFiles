<?php

namespace PHPAlchemist\Contracts;

use PHPAlchemist\Traits\ArrayInterface;

/**
 *
 * @package PHPAlchemist\Contracts
 */
interface IndexedArrayInterface extends ArrayInterface
{
    // Class Specific
    /**
     * @param array $data
     * @return IndexedArrayInterface
     */
    function setData(array $data) : IndexedArrayInterface;

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
     * @return IndexedArrayInterface
     */
    function push(mixed $data) : IndexedArrayInterface;

    /**
     * @param mixed $data
     * @return IndexedArrayInterface
     */
    function add(mixed $data) : IndexedArrayInterface;

    /**
     * @return mixed
     */
    function pop() : mixed;

    /**
     * @param mixed $key
     * @return mixed
     */
    function get(mixed $key) : mixed;

    /**
     * Returns the first element of the collection
     *
     * @return mixed
     */
    function first() : mixed;

}

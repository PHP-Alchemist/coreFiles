<?php

namespace PHPAlchemist\Trait\Array;

trait ArrayInteratorFunctions
{
    /**
     * Return the current element.
     *
     * @link https://php.net/manual/en/iterator.current.php
     *
     * @return mixed Can return any type.
     *
     * @since  5.0.0
     */
    public function current() : mixed
    {
        return ($this->valid()) ? array_values($this->data)[$this->position] : false;
    }

    /**
     * Move forward to next element.
     *
     * @link https://php.net/manual/en/iterator.next.php
     *
     * @return void Any returned value is ignored.
     *
     * @since  5.0.0
     */
    public function next() : void
    {
        $this->position++;
    }

    /**
     * Return the key of the current element.
     *
     * @link   https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure.
     *
     * @since  5.0.0
     */
    public function key() : mixed
    {
        return array_keys($this->data)[$this->position];
    }

    /**
     * Checks if current position is valid.
     *
     * @link   https://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     *
     * @since  5.0.0
     */
    public function valid() : bool
    {
        return isset(array_values($this->data)[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @link   https://php.net/manual/en/iterator.rewind.php
     *
     * @return void Any returned value is ignored.
     *
     * @since  5.0.0
     */
    public function rewind() : void
    {
        $this->position = 0;
    }

    /**
     * Move back to previous element.
     * not part of Iterator
     *
     * @return void Any returned value is ignored.
     */
    public function prev() : void
    {
        $this->position--;
    }

}
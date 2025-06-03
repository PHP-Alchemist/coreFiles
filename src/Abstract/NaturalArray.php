<?php

namespace PHPAlchemist\Abstract;

use PHPAlchemist\Trait\Array\OnClearTrait;
use PHPAlchemist\Trait\Array\OnInsertTrait;
use PHPAlchemist\Trait\Array\OnRemoveTrait;
use PHPAlchemist\Trait\Array\OnSetTrait;

abstract class NaturalArray
{
    use OnInsertTrait;
    use OnRemoveTrait;
    use OnClearTrait;
    use OnSetTrait;

    /**
     * Whether a offset exists.
     *
     * @link   https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned.
     *
     * @since  5.0.0
     */
    public function offsetExists(mixed $offset) : bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet(mixed $offset) : mixed
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }

        return null;
    }

    public function count() : int
    {
        return count($this->data);
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function isEmpty() : bool
    {
        return empty($this->data);
    }

    public function current() : mixed
    {
        return ($this->valid()) ? array_values($this->data)[$this->position] : false;
    }

    public function next() : void
    {
        $this->position++;
    }

    public function key() : mixed
    {
        return array_keys($this->data)[$this->position];
    }

    public function valid() : bool
    {
        return isset(array_values($this->data)[$this->position]);
    }

    public function rewind() : void
    {
        $this->position = 0;
    }

    /**
     * Move back to previous element.
     *
     * @return void Any returned value is ignored.
     */
    public function prev() : void
    {
        $this->position--;
    }

    public function clear() : void
    {
        if (isset($this->onClear) && is_callable($this->onClear)) {
            $onClear = $this->onClear;
            $onClear($this->data);
        }

        $this->data = [];
        $this->rewind();

        if (isset($this->onClearComplete) && is_callable($this->onClearComplete)) {
            $onClearComplete = $this->onClearComplete;
            $onClearComplete($this->data);
        }
    }

    public function first() : mixed
    {
        return $this->data[array_key_first($this->data)];
    }

    public function extract(mixed $key) : mixed
    {
        $returnValue = $this->data[$key];
        $this->delete($key);
        return $returnValue;
    }

    public function delete(mixed $key) : void
    {
        if (array_key_exists($key, $this->data)) {
            $this->offsetUnset($key);
        }
    }

}
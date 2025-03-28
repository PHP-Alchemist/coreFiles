<?php

namespace PHPAlchemist\Abstract;

/**
 * Abstract class for List (Roll) Objectified array class.
 */
abstract class AbstractList extends AbstractIndexedArray
{
    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset) : void
    {
        parent::offsetUnset($offset);
        if (!$this->isList()) {
            $this->rebalanceData();
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetset(mixed $offset, mixed $value) : void
    {
        parent::offsetSet($offset, $value);
        if (!$this->isList()) {
            $this->rebalanceData();
        }
    }

    /**
     * Reset the keys to 0,1,2,3,...
     *
     * @return void
     */
    protected function rebalanceData() : void
    {
        $this->data = array_values($this->data);
    }

    /**
     * Determine if array is a List.
     *
     * @return bool
     */
    protected function isList() : bool
    {
        return array_is_list($this->data) && ($this instanceof AbstractList);
    }

    /**
     * Uses generator to step through List data.
     *
     * @return mixed
     */
    public function parseData() : mixed
    {
        foreach ($this->data as $data) {
            yield $data;
        }
    }
}

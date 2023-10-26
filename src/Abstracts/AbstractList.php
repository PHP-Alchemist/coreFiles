<?php

namespace PHPAlchemist\Abstracts;


/**
 * Abstract class for List (Roll) Objectified array class
 * @package PHPAlchemist\Abstracts
 */
abstract class AbstractList extends AbstractIndexedArray
{
    public function offsetUnset(mixed $offset) : void
    {
        parent::offsetUnset($offset);
        if (!$this->isList()) {
            $this->rebalanceData();
        }
    }

    public function offsetset(mixed $offset, mixed $value) : void
    {
        parent::offsetSet($offset, $value);
        if (!$this->isList()) {
            $this->rebalanceData();
        }
    }

    protected function rebalanceData() : void
    {
        $this->data = array_values($this->data);
    }

    protected function isList() : bool
    {
        return array_is_list($this->data);
    }

}
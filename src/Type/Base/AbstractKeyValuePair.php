<?php

namespace PHPAlchemist\Type\Base;

class AbstractKeyValuePair
{
    protected $key;

    protected $value;

    public function __construct($key, $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->value;
    }


}
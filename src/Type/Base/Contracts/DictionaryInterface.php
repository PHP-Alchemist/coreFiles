<?php

namespace PHPAlchemist\Type\Base\Contracts;

interface DictionaryInterface extends ArrayInterface
{
    function add($key, $value);

    function set($key, $value);

    function get($key);

    function getKeys();

    function getValues();

    function setData($data = []);

    function getData();

}
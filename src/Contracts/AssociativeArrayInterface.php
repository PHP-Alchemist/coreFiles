<?php


namespace PHPAlchemist\Contracts;

use PHPAlchemist\Traits\ArrayInterface;

/**
 * Array
 * @package PHPAlchemist\Contracts
 */
interface AssociativeArrayInterface extends  ArrayInterface
{
    function add(mixed $key, mixed $value) : AssociativeArrayInterface;

    function get(mixed $key) : mixed;

    function getKeys() : array;

    function getValues() : array;

    function count() : int;

    function isReadOnly() : bool;



}
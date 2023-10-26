<?php


namespace PHPAlchemist\Contracts;

/**
 * Array
 * @package PHPAlchemist\Contracts
 */
interface AssociativeArrayInterface extends  ArrayInterface
{
    function add($key, $value) : AssociativeArrayInterface;

    function get($key) : mixed;

    function getKeys() : array;

    function getValues() : array;

    function count() : int;

    function isReadOnly() : bool;



}
<?php

namespace PHPAlchemist\Type\Base\Contracts;

interface StringInterface extends \Stringable
{

    /**
     * @param mixed $needle
     * @return mixed
     */
    public function contains(mixed $needle) : bool;

    public function startsWith(mixed $needle) : bool;

    public function endsWith(mixed $needle) : bool;

    /**
     * @return int
     */
    public function length() : int;

    /**
     * Explode to  CollectionInterface object
     *
     * @param string $delimiter
     * @param int $limit
     *
     * @return CollectionInterface
     */
    public function explode($delimiter = '', $limit = PHP_INT_MAX) : CollectionInterface;

    /**
     * Determine if string has value
     *
     * @return bool
     */
    public function hasValue() : bool;

    /**
     * Get value of String object0
     *
     * @return string
     */
    public function getValue() : string;

    /**
     * @param string $value
     *
     * @return StringInterface
     */
    public function setValue($value) : StringInterface;

    /**
     * @return string
     */
    public function __toString() : string;
}
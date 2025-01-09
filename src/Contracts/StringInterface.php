<?php

namespace PHPAlchemist\Contracts;

use PHPAlchemist\Types\Base\Contracts\Twine;

/**
 * @package PHPAlchemist\Contracts
 */
interface StringInterface extends \Stringable
{
    /**
     * @return string
     */
    public function __toString() : string;

    /**
     * @param mixed $needle
     * @return mixed
     */
    public function contains(mixed $needle, bool $caseInsensitive = false) : bool;

    public function endsWith(mixed $needle) : bool;

    /**
     * @param string|StringInterface $comparitive
     * @return bool
     */
    public function equals(string|self $comparitive) : bool;

    /**
     * Explode to  CollectionInterface object
     *
     * @param string $delimiter
     * @param int $limit
     *
     * @return IndexedArrayInterface
     */
    public function explode($delimiter = '', $limit = PHP_INT_MAX) : IndexedArrayInterface;

    /**
     * Get value of String object0
     *
     * @return string
     */
    public function getValue() : ?string;

    /**
     * Determine if string has value
     *
     * @return bool
     */
    public function hasValue() : bool;

    /**
     * @param string $needle
     * @param int $startIndex
     * @return false|int
     */
    public function indexOf(string $needle, int $startIndex = 0) : int|false;

    /**
     * @param string $insertion
     * @param int $offset
     * @return void
     */
    public function insert(string $insertion, int $offset) : void;

    /**
     * @return bool
     */
    public function isNullOrEmpty() : bool;

    /**
     * @param string $needle
     * @param int $startIndex
     * @return int|false
     */
    public function lastIndexOf(string $needle, int $startIndex = 0) : int|false;

    /**
     * @return int
     */
    public function length() : int;

    /**
     * @param int $length
     * @param string $padValue
     * @return void
     */
    public function padBoth(int $length, string $padValue = ' ') : void;

    /**
     * @param int $length
     * @param string $padValue
     * @return void
     */
    public function padLeft(int $length, string $padValue = ' ') : void;

    /**
     * @param int $length
     * @param string $padValue
     * @return void
     */
    public function padRight(int $length, string $padValue = ' ') : void;

    /**
     * @param string $value
     *
     * @return StringInterface
     */
    public function setValue($value) : StringInterface;

    /**
     * @param mixed $needle
     * @return bool
     */
    public function startsWith(mixed $needle) : bool;

    /**
     * @param int $offset
     * @param int|null $length
     * @return StringInterface
     */
    public function substring(int $offset, ?int $length) : StringInterface;

    /**
     * @param int $offset
     * @param int $length
     * @return void
     */
    public function remove(int $offset, int $length) : void;


    /**
     * Determines if a StringInterface object is empty and has no value
     *
     * @return bool
     */
    public function isEmpty() : bool;
}


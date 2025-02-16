<?php

namespace PHPAlchemist\ValueObjects\Contracts;

use PHPAlchemist\Contracts\IndexedArrayInterface;
use PHPAlchemist\Types\Base\Contracts\Twine;

/**
 * @package PHPAlchemist\ValueObjects\Contracts
 */
interface VOStringInterface extends \Stringable
{
    /** @return string */
    public function __toString() : string;

    /**
     * @param mixed $needle
     * @param bool $caseInsensitive
     *
     * @return bool
     */
    public function contains(mixed $needle, bool $caseInsensitive = false) : bool;

    public function endsWith(mixed $needle) : bool;

    /**
     * @param VOStringInterface $comparitive
     * @return bool
     */
    public function equals(self $comparitive) : bool;

    /**
     * Get value of String object
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
     * @param string $needle
     * @param int $startIndex
     * @return int|false
     */
    public function lastIndexOf(string $needle, int $startIndex = 0) : int|false;

    public function length() : VONumberInterface;


    /**
     * @param mixed $needle
     * @return bool
     */
    public function startsWith(mixed $needle) : bool;

    /**
     * @param int $offset
     * @param int|null $length
     * @return VOStringInterface
     */
    public function substring(int $offset, ?int $length) : VOStringInterface;
}


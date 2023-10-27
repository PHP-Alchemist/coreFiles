<?php

namespace PHPAlchemist\Abstracts;

use PHPAlchemist\Contracts\IndexedArrayInterface;
use PHPAlchemist\Contracts\StringInterface;
use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\Twine;

/**
 * Abstract class for String
 * @package PHPAlchemist\Abstracts
 */
abstract class AbstractString implements StringInterface
{
    const BEGINNING_OF_STRING_POSITION = 0;

    protected $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function __toString() : string
    {
        return $this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function setValue($value) : StringInterface
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function contains(mixed $needle, bool $caseInsensitive = false) : bool
    {
        if ($caseInsensitive)
            return str_contains(mb_strtolower($this->value), mb_strtolower($needle));

        return str_contains($this->value, $needle);
    }

    /** @inheritDoc */
    public function endsWith(mixed $needle) : bool
    {
        return str_ends_with($this->value, $needle);
    }

    /** @inheritDoc */
    public function equals(string|StringInterface $comparitive) : bool
    {
        return (string)$comparitive === $this->value;
    }

    /**
     * @inheritDoc
     */
    public function hasValue() : bool
    {
        return !(is_null($this->value));
    }

    /** @inheritDoc */
    public function indexOf(string $needle, int $startIndex = 0) : int|false
    {
        return strpos($this->value, $needle, $startIndex);
    }

    /** @inheritDoc */
    public function insert(string $insertion, int $offset) : void
    {
        $explosion[0] = substr($this->value, 0, $offset);
        $explosion[1] = $insertion;
        $explosion[2] = substr($this->value, $offset);

        $this->value = implode('', $explosion);
    }

    /** @inheritDoc */
    public function isNullOrEmpty() : bool
    {
        return (is_null($this->value) || empty($this->value));
    }

    /** @inheritDoc */
    public function lastIndexOf(string $needle, int $startIndex = 0) : int|false
    {
        return strrpos($this->value, $needle, $startIndex);
    }

    /**
     * @inheritDoc
     */
    public function length() : int
    {
        return strlen($this->value);
    }

    /**
     * Convert string to lower case
     *
     * @return string
     */
    public function lower() : string
    {
        return mb_strtolower($this->getValue());
    }

    /** @inheritDoc */
    public function padBoth(int $length, string $padValue = ' ') : void
    {
        $this->value = str_pad($this->value, $length, $padValue, STR_PAD_BOTH);
    }

    /** @inheritDoc */
    public function padLeft(int $length, string $padValue = ' ') : void
    {
        $this->value = str_pad($this->value, $length, $padValue, STR_PAD_LEFT);
    }

    /** @inheritDoc */
    public function padRight(int $length, string $padValue = ' ') : void
    {
        $this->value = str_pad($this->value, $length, $padValue, STR_PAD_RIGHT);
    }

    /** @inheritDoc */
    public function remove(int $offset, int $length) : void
    {
        $temp[] = substr($this->value, 0, $offset);
        $temp[] = substr($this->value, ($offset + $length));

        $this->value = implode('', $temp);
    }

    /**
     * Convenience function for explode
     *
     * @param $delimiter
     * @param $limit
     * @return IndexedArrayInterface
     */
    public function splitOn($delimiter = '', $limit = PHP_INT_MAX) : IndexedArrayInterface
    {
        return $this->explode($delimiter, $limit);
    }

    public function splitAt(int $position) : IndexedArrayInterface
    {
        $split1 = substr($this->value, self::BEGINNING_OF_STRING_POSITION, $position);
        $split2 = substr($this->value, $position);

        return new Collection([$split1, $split2]);
    }

    /**
     * @inheritDoc
     */
    public function explode($delimiter = '', $limit = PHP_INT_MAX) : IndexedArrayInterface
    {
        return new Collection(explode($delimiter, $this->getValue(), $limit));
    }

    /** @inheritDoc */
    public function startsWith(mixed $needle) : bool
    {
        return str_starts_with($this->value, $needle);
    }

    /** @inheritDoc */
    public function substring(int $offset, ?int $length = null) : StringInterface
    {
        return new Twine(substr($this->value, $offset, $length));
    }

    /**
     * Convert string to UPPER CASE
     *
     * @return string
     */
    public function upper() : string
    {
        return mb_strtoupper($this->getValue());
    }

    public function replace(string|array $needle, string|array $replacement) : void
    {
        if (is_string($needle)) {
            $needle = "/{$needle}/";
        }
        $this->value = preg_replace($needle, $replacement, $this->value);
    }
}

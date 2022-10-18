<?php

namespace PHPAlchemist\Type\Base;

use PHPAlchemist\Type\Collection;
use PHPAlchemist\Type\Base\Contracts\CollectionInterface;
use PHPAlchemist\Type\Base\Contracts\TwineInterface;
use PHPAlchemist\Type\Twine;

class AbstractTwine implements TwineInterface
{
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
    public function setValue($value) : TwineInterface
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function contains(mixed $needle) : bool
    {
        return str_contains($this->value, $needle);
    }

    /** @inheritDoc */
    public function endsWith(mixed $needle) : bool
    {
        return str_ends_with($this->value, $needle);
    }

    /** @inheritDoc */
    public function equals(string|TwineInterface $comparitive) : bool
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
     * @return CollectionInterface
     */
    public function split($delimiter = '', $limit = PHP_INT_MAX) : CollectionInterface
    {
        return $this->explode($delimiter, $limit);
    }

    /**
     * @inheritDoc
     */
    public function explode($delimiter = '', $limit = PHP_INT_MAX) : CollectionInterface
    {
        return new Collection(explode($delimiter, $this->getValue(), $limit));
    }

    /** @inheritDoc */
    public function startsWith(mixed $needle) : bool
    {
        return str_starts_with($this->value, $needle);
    }

    /** @inheritDoc */
    public function substring(int $offset, ?int $length = null) : TwineInterface
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
}
<?php

namespace PHPAlchemist\Type\Base;

use PHPAlchemist\Type\Collection;
use PHPAlchemist\Type\Base\Contracts\{CollectionInterface, StringInterface};

class AbstractString implements StringInterface
{
    protected $value;

    public function __construct($value = null)
    {
        $this->value = $value;
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

    /**
     * @inheritDoc
     */
    public function length(): int
    {
        return strlen($this->value);
    }

    /**
     * Convert string to UPPER CASE
     *
     * @return string
     */
    public function upper(): string
    {
        return strtoupper($this->getValue());
    }

    /**
     * Convert string to lower case
     *
     * @return string
     */
    public function lower(): string
    {
        return strtolower($this->getValue());
    }

    /**
     * @inheritDoc
     */
    public function explode($delimiter = '', $limit = PHP_INT_MAX): CollectionInterface
    {
        return new Collection(explode($delimiter, $this->getValue(), $limit));
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function hasValue(): bool
    {
        return !(is_null($this->value));
    }

    /**
     * @inheritDoc
     */
    public function setValue($value): StringInterface
    {
        $this->value = $value;

        return $this;
    }

    /** @inheritDoc */
    public function startsWith(mixed $needle) : bool
    {
        return str_starts_with($this->value, $needle);
    }

}
<?php

namespace PHPAlchemist\ValueObject\Abstract;

use PHPAlchemist\Types\Twine;
use PHPAlchemist\ValueObject\Contract\VONumberInterface;
use PHPAlchemist\ValueObject\Contract\VOStringInterface;
use PHPAlchemist\ValueObject\Model\VONumber;

abstract class AbstractVOString implements VOStringInterface
{
    /**
     * Below is the value store for the VO String object. In v3.0 this will be protected readonly.
     * Currently, this is only set to maintain compatibility for v2.x.
     *
     * @var string $value the value store for the VO String object
     */
    // PHP 8.4 ONLY -> protected readonly string $value;
    protected string $value;

    public function __toString() : string
    {
        return ($this->getValue()) ?: '';
    }

    public function getValue() : ?string
    {
        return $this->value;
    }

    public function contains(mixed $needle, bool $caseInsensitive = false) : bool
    {
        if ($caseInsensitive) {
            return str_contains(mb_strtolower($this->value), mb_strtolower($needle));
        }

        return str_contains($this->value, $needle);
    }

    /** @inheritDoc */
    public function endsWith(mixed $needle) : bool
    {
        return str_ends_with($this->value, $needle);
    }

    /** @inheritDoc */
    public function equals(VOStringInterface $comparitive) : bool
    {
        return $comparitive->getValue() === $this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function hasValue() : bool
    {
        return !is_null($this->value);
    }

    /** @inheritDoc */
    public function indexOf(string $needle, int $startIndex = 0) : int|false
    {
        return strpos($this->value, $needle, $startIndex);
    }

    public function lastIndexOf(string $needle, int $startIndex = 0) : int|false
    {
        return strrpos($this->value, $needle, $startIndex);
    }

    /**
     * @inheritDoc
     */
    public function length() : VONumberInterface
    {
        $length = strlen($this->value);

        return new VONumber($length);
    }

    /**
     * Convert string to lower case.
     *
     * @return string
     */
    public function lower() : string
    {
        return mb_strtolower($this->getValue());
    }

    /** @inheritDoc */
    public function startsWith(mixed $needle) : bool
    {
        return str_starts_with($this->value, $needle);
    }

    /** @inheritDoc */
    public function substring(int $offset, ?int $length = null) : VOStringInterface
    {
        return new Twine(substr($this->value, $offset, $length));
    }
}

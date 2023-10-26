<?php

namespace PHPAlchemist\Type\Base;

use PHPAlchemist\Exceptions\InvalidKeyTypeException;
use PHPAlchemist\Exceptions\UnmatchedClassException;
use PHPAlchemist\Exceptions\UnmatchedVersionException;
use PHPAlchemist\Traits\ArrayTrait;
use PHPAlchemist\Type\Base\Contracts\IndexedArrayInterface;
use PHPAlchemist\Type\Base\Contracts\StringInterface;
use PHPAlchemist\Type\Collection;
use PHPAlchemist\Type\Roll;
use PHPAlchemist\Type\Twine;

/**
 * Abstract class Collection (Objectified Array Class)
 * @package PHPAlchemist\Type\Base
 */
abstract class AbstractIndexedArray implements IndexedArrayInterface
{
    public static $serializeVersion = 1;

    use ArrayTrait;

    /** @var boolean $strict */
    protected bool $strict;

    /** @var int $position position sentinel variable */
    protected int $position;

    /** @var array $data */
    protected array $data;

    public function __construct(array $data = [], bool $strict = true)
    {
        $this->strict = $strict;
        if (!$this->validateKeys($data)) {
            throw new InvalidKeyTypeException("Invalid Key type for Array");
        }
        $this->data     = $data;
        $this->position = 0;
    }

    /**
     * @inheritDoc
     */
    public function count() : int
    {
        return count($this->data);
    }


    /**
     * @inheritDoc
     */
    public function prev() : void
    {
        --$this->position;
    }

    /**
     * @param string $glue default: ' '
     *
     * @return StringInterface
     */
    public function implode($glue = ' ') : StringInterface
    {
        return new Twine(join($glue, $this->data));
    }

    // region Contractual Obligations

    /**
     * Build Array from data for serialization
     *
     * @return array
     */
    public function __serialize() : array
    {
        // Check version and if mismatch call conversion method
        return [
            'version' => static::$serializeVersion,
            'model'   => get_class($this),
            'data'    => $this->data,
        ];
    }

    /**
     * Take Deserialized Array and populate object with that data
     *
     * @param array $data
     * @return void
     * @throws UnmatchedClassException
     * @throws UnmatchedVersionException
     */
    public function __unserialize(array $data) : void
    {
        // Check version and if mismatch call conversion method
        if ($data['model'] !== get_class($this)) {
            throw new UnmatchedClassException();
        }

        if ($data['version'] !== static::$serializeVersion) {
            throw new UnmatchedVersionException();
        }

        $this->data = $data['data'];
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists(mixed $offset) : bool
    {
        return (isset($this->data[$offset]));
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet(mixed $offset) : mixed
    {
        return $this->data[$offset];
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet(mixed $offset, mixed $value) : void
    {
        if ($this->isStrict() && !$this->validateKey($offset)) {
            throw new InvalidKeyTypeException(sprintf("Invalid Key type (%s) for Array", gettype($offset)));
        }

        $this->data[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset(mixed $offset) : void
    {
        unset($this->data[$offset]);
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current() : mixed
    {
        return ($this->valid()) ? array_values($this->data)[$this->position] : false;
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() : void
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() : mixed
    {
        return array_keys($this->data)[$this->position];
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() : bool
    {
        return isset(array_values($this->data)[$this->position]);
    }


    /**
     * @inheritDoc
     */
    public function rewind() : void
    {
        $this->position = 0;
    }
    // endRegion

    /**
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function setData(array $data) : IndexedArrayInterface
    {
        $this->data = $data;

        return $this;
    }

    public function isStrict() : bool
    {
        return $this->strict;
    }

    protected function validateKeys(array $dataSet) : bool
    {
        if ($this->isStrict()) {
            foreach (array_keys($dataSet) as $key) {
                if (!($this->validateKey($key))) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function validateKey($key) : bool
    {
        return is_int($key);
    }

    public function merge(IndexedArrayInterface|array $collection) : void
    {
        $this->data = array_merge($this->data, $collection);
    }

    public function push(mixed $data) : IndexedArrayInterface
    {
        $this->data[] = $data;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(mixed $data) : IndexedArrayInterface
    {
        $this->data[] = $data;

        return $this;
    }

    /**
     * Find intersection of this and another collection - I would really like to explore putting this into the
     * CollectionInterface but for now  it's going to be a non-contracted function. I also REALLY would like to make a
     * strict option that allows for type matching.
     *
     * @param Collection $secondCollection
     * @return Collection
     * @throws InvalidKeyTypeException
     */
    public function intersection(Collection $secondCollection) : Collection
    {
        return new Collection(array_values(
                array_intersect($this->data, $secondCollection->getData())
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function pop() : mixed
    {
        $value = array_pop($this->data);

        if (is_string($value)) {
            return new Twine($value);
        }

        if (is_array($value)) {
            return new Collection($value);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function get(mixed $key) : mixed
    {
        return $this->offsetGet($key);
    }

    /**
     * @inheritDoc
     */
    public function first() : mixed
    {
        return $this->data[array_key_first($this->data)];
    }

    /**
     * Convert AbstractCollection to a AbstractList (Roll)
     *
     * @param Collection $indexes
     * @param $rollClass Default: \PHPAlchemist\Type\Roll
     * @return AbstractList
     * @throws \Exception
     */
    public function toRoll(Collection $indexes = new Collection(), $rollClass = Roll::class) : AbstractList
    {
        if ($indexes->count() > 0 && $indexes->count() !== $this->count()) {
            throw new \Exception("Indexes count mismatch");
        }

        if ($indexes->count() === 0) {
            $indexes->setData(range(0, ($this->count() - 1)));
        }

        return new $rollClass(array_combine($indexes->getData(), $this->getData()));
    }
}

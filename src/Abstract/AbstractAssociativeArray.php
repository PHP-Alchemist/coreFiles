<?php

namespace PHPAlchemist\Abstract;

use Exception;
use PHPAlchemist\Contract\AssociativeArrayInterface;
use PHPAlchemist\Contract\StringInterface;
use PHPAlchemist\Exception\HashTableFullException;
use PHPAlchemist\Exception\InvalidKeyTypeException;
use PHPAlchemist\Exception\ReadOnlyDataException;
use PHPAlchemist\Exception\UnmatchedClassException;
use PHPAlchemist\Exception\UnmatchedVersionException;
use PHPAlchemist\Trait\ArrayTrait;
use PHPAlchemist\Type\Twine;

/**
 * Abstract class for Associative Array (Objectified Array Class).
 */
abstract class AbstractAssociativeArray extends NaturalArray implements AssociativeArrayInterface
{
    use ArrayTrait;

    public static $serializeVersion = 1;

    /**
     * @var bool
     */
    protected $readOnly;

    /**
     * @var int position sentinel variable
     */
    protected $position;

    /**
     * @var array<string, mixed>
     */
    protected $data;

    /**
     * @var int locking a HashTable to a fixed size
     */
    protected $fixedSize;

    public function __construct(array $data = [], $readOnly = false, $fixedSize = null)
    {
        if (!$this->validateKeys($data)) {
            throw new InvalidKeyTypeException('Invalid Key type for HashTable');
        }

        if (is_int($fixedSize)) {
            if (count($data) < $fixedSize) {
                $data = array_pad($data, $fixedSize, 0);
            } elseif (count($data) > $fixedSize) {
                throw new Exception('HashTable data size is larger than defined size');
            }
        } elseif (is_bool($fixedSize) && $fixedSize) {
            $fixedSize = count($data);
        }

        $this->data      = $data;
        $this->position  = 0;
        $this->readOnly  = $readOnly;
        $this->fixedSize = $fixedSize;
    }

    public function __serialize() : array
    {
        return [
          'version' => static::$serializeVersion,
          'model'   => get_class($this),
          'data'    => $this->data,
        ];
    }

    public function __unserialize(array $data) : void
    {
        if ($data['model'] !== get_class($this)) {
            throw new UnmatchedClassException();
        }

        if ($data['version'] !== static::$serializeVersion) {
            throw new UnmatchedVersionException();
        }

        $this->setData($data);
    }

    /**
     * Add.
     *
     * @param mixed $key key to add to array
     * @param mixed $value value to add to array
     *
     * @return $this
     */
    public function add(mixed $key, mixed $value) : AssociativeArrayInterface
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get(mixed $key) : mixed
    {
        return $this->offsetGet($key);
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
     * Offset to set.
     *
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     *
     * @throws HashTableFullException
     * @throws InvalidKeyTypeException
     * @throws ReadOnlyDataException
     *
     * @return void
     *
     * @since  5.0.0
     */
    public function offsetSet(mixed $offset, mixed $value) : void
    {
        if ($this->isReadOnly()) {
            throw new ReadOnlyDataException('Invalid call to offsetSet on read-only ' . __CLASS__ . '.');
        }

        if (!$this->offsetExists($offset)
          && $this->isFixedSize()
          && $this->count() == $this->fixedSize
        ) {
            throw new HashTableFullException('Invalid call to offsetSet on ' . __CLASS__ . 'where Size is Fixed and HashTable full.');
        }

        if (!$this->validateKey($offset)) {
            throw new InvalidKeyTypeException(sprintf('Invalid Key type (%s) for HashTable', gettype($offset)));
        }

        if (isset($this->onInsert) && is_callable($this->onInsert)) {
            $onInsert = $this->onInsert;
            [
              $offset,
              $value,
            ] = $onInsert($offset, $value);
        }

        $this->data[$offset] = $value;

        if (isset($this->onInsertComplete) && is_callable($this->onInsertComplete)) {
            $onInsertComplete = $this->onInsertComplete;
            $onInsertComplete($this->data);
        }
    }

    /**
     * Offset to unset.
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset The offset to unset.
     *
     * @return void
     *
     * @since  5.0.0
     */
    public function offsetUnset(mixed $offset) : void
    {
        if (isset($this->onRemove) && is_callable($this->onRemove)) {
            $onRemove = $this->onRemove;
            $onRemove($offset, $this->data[$offset]);
        }

        unset($this->data[$offset]);

        if (isset($this->onRemoveComplete) && is_callable($this->onRemoveComplete)) {
            $onRemoveComplete = $this->onRemoveComplete;
            $onRemoveComplete($this->data);
        }
    }
    // endRegion

    /**
     * @param array $data
     */
    public function setData(array $data) : AssociativeArrayInterface
    {
        if (isset($this->onSet) && is_callable($this->onSet)) {
            $onSet = $this->onSet;
            $onSet($data);
        }

        $this->data = $data;

        if (isset($this->onSetComplete) && is_callable($this->onSetComplete)) {
            $onSetComplete = $this->onSetComplete;
            $onSetComplete($this->data);
        }

        return $this;
    }

    /**
     * Return an array of keys.
     *
     * @return array
     */
    public function getKeys() : array
    {
        return array_keys($this->data);
    }

    /**
     * Return an array of values.
     *
     * @return array
     */
    public function getValues() : array
    {
        return array_values($this->data);
    }

    /**
     * Is this HashTable readOnly?
     *
     * @return bool
     */
    public function isReadOnly() : bool
    {
        return $this->readOnly;
    }

    /**
     * Locks HashTable to current size.
     *
     * @return $this
     */
    public function lockSize()
    {
        $this->fixedSize = $this->count();

        return $this;
    }

    /**
     * Determine if HashTable is of a fixed size.
     *
     * @return bool
     */
    public function isFixedSize() : bool
    {
        return !is_null($this->fixedSize);
    }

    /**
     * @param array $dataSet
     *
     * @return bool
     */
    protected function validateKeys(array $dataSet) : bool
    {
        foreach (array_keys($dataSet) as $key) {
            if (!$this->validateKey($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    protected function validateKey($key) : bool
    {
        return is_string($key);
    }

    /**
     * Find the key for $value.
     *
     * @param mixed $value the value to search the array for
     *
     * @return mixed
     */
    public function search(mixed $value) : mixed
    {
        return array_search($value, $this->data);
    }
}

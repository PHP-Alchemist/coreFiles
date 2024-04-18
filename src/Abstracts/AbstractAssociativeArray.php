<?php

namespace PHPAlchemist\Abstracts;

use Exception;
use PHPAlchemist\Contracts\AssociativeArrayInterface;
use PHPAlchemist\Contracts\StringInterface;
use PHPAlchemist\Exceptions\HashTableFullException;
use PHPAlchemist\Exceptions\InvalidKeyTypeException;
use PHPAlchemist\Exceptions\ReadOnlyDataException;
use PHPAlchemist\Exceptions\UnmatchedClassException;
use PHPAlchemist\Exceptions\UnmatchedVersionException;
use PHPAlchemist\Traits\Array\OnClearTrait;
use PHPAlchemist\Traits\Array\OnInsertTrait;
use PHPAlchemist\Traits\Array\OnRemoveTrait;
use PHPAlchemist\Traits\Array\OnSetTrait;
use PHPAlchemist\Traits\ArrayTrait;
use PHPAlchemist\Types\Twine;

/**
 * Abstract class for Associative Array (Objectified Array Class)
 *
 * @package PHPAlchemist\Abstracts
 */
abstract class AbstractAssociativeArray implements AssociativeArrayInterface
{
    use ArrayTrait;
    use OnInsertTrait;
    use OnRemoveTrait;
    use OnClearTrait;
    use OnSetTrait;

    public static $serializeVersion = 1;

    /**
     * @var bool $readOnly
     */
    protected $readOnly;

    /**
     * @var int $position position sentinel variable
     */
    protected $position;

    /**
     * @var array $data
     */
    protected $data;

    /**
     * @var int $fixedSize locking a HashTable to a fixed size
     */
    protected $fixedSize;

    public function __construct(array $data = [], $readOnly = false, $fixedSize = null)
    {
        if (!$this->validateKeys($data)) {
            throw new InvalidKeyTypeException("Invalid Key type for HashTable");
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
     * Add
     *
     * @param string $key key to add to array
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
     * Get a count of the elements of the array
     *
     * @return int
     */
    public function count() : int
    {
        return count($this->data);
    }

    public function delete(mixed $key) : void
    {
        if (array_key_exists($key, $this->data)) {
            $this->offsetUnset($key);
        }
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

    /**
     * Move back to previous element
     *
     * @return void Any returned value is ignored.
     */
    public function prev() : void
    {
        --$this->position;
    }

    // region Contractual Obligations

    /**
     * Whether a offset exists
     *
     * @link   https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     *                       An offset to check for.
     *                       </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since  5.0.0
     */
    public function offsetExists(mixed $offset) : bool
    {
        return (isset($this->data[$offset]));
    }

    /**
     * Offset to retrieve
     *
     * @link   https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     *                       The offset to retrieve.
     *                       </p>
     * @return mixed Can return all value types.
     * @since  5.0.0
     */
    public function offsetGet(mixed $offset) : mixed
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }

        return false;
    }

    /**
     * Offset to set
     *
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     *
     * @return void
     * @since  5.0.0
     * @throws HashTableFullException
     * @throws InvalidKeyTypeException
     * @throws ReadOnlyDataException
     */
    public function offsetSet(mixed $offset, mixed $value) : void
    {
        if ($this->isReadOnly()) {
            throw new ReadOnlyDataException("Invalid call to offsetSet on read-only " . __CLASS__ . ".");
        }

        if (!$this->offsetExists($offset)
            && $this->isFixedSize()
            && $this->count() == $this->fixedSize
        ) {
            throw new HashTableFullException("Invalid call to offsetSet on " . __CLASS__ . "where Size is Fixed and HashTable full.");
        }

        if (!$this->validateKey($offset)) {
            throw new InvalidKeyTypeException(sprintf("Invalid Key type (%s) for HashTable", gettype($offset)));
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
     * Offset to unset
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset The offset to unset.
     *
     * @return void
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

    /**
     * Return the current element
     *
     * @link https://php.net/manual/en/iterator.current.php
     *
     * @return mixed Can return any type.
     * @since  5.0.0
     */
    public function current() : mixed
    {
        return ($this->valid()) ? array_values($this->data)[$this->position] : false;
    }

    /**
     * Move forward to next element
     *
     * @link https://php.net/manual/en/iterator.next.php
     *
     * @return void Any returned value is ignored.
     * @since  5.0.0
     */
    public function next() : void
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     *
     * @link   https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since  5.0.0
     */
    public function key() : mixed
    {
        return array_keys($this->data)[$this->position];
    }

    /**
     * Checks if current position is valid
     *
     * @link   https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since  5.0.0
     */
    public function valid() : bool
    {
        return isset(array_values($this->data)[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link   https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since  5.0.0
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
     * Return an array of keys
     *
     * @return array
     */
    public function getKeys() : array
    {
        return array_keys($this->data);
    }

    /**
     * Return an array of values
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
     * Locks HashTable to current size
     *
     * @return $this
     */
    public function lockSize()
    {
        $this->fixedSize = $this->count();

        return $this;
    }

    /**
     * Determine if HashTable is of a fixed size
     *
     * @return bool
     */
    public function isFixedSize() : bool
    {
        return !(is_null($this->fixedSize));
    }

    /**
     * @param array $dataSet
     *
     * @return bool
     */
    protected function validateKeys(array $dataSet) : bool
    {
        foreach (array_keys($dataSet) as $key) {
            if (!($this->validateKey($key))) {
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
     * Get the value of a specified key and remove from
     * array.
     *
     * @param mixed $key
     * @return mixed
     */
    public function extract(mixed $key) : mixed
    {
        $returnValue = $this->data[$key];
        $this->delete($key);

        return $returnValue;
    }

    public function clear() : void
    {
        if (isset($this->onClear) && is_callable($this->onClear)) {
            $onClear = $this->onClear;
            $onClear($this->data);
        }

        $this->data = [];
        $this->rewind();

        if (isset($this->onClearComplete) && is_callable($this->onClearComplete)) {
            $onClearComplete = $this->onClearComplete;
            $onClearComplete($this->data);
        }

    }

    /**
     * Find the key for $value
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

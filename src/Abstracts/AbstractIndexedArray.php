<?php

namespace PHPAlchemist\Abstracts;

use PHPAlchemist\Contracts\IndexedArrayInterface;
use PHPAlchemist\Contracts\StringInterface;
use PHPAlchemist\Exceptions\InvalidKeyTypeException;
use PHPAlchemist\Exceptions\UnmatchedClassException;
use PHPAlchemist\Exceptions\UnmatchedVersionException;
use PHPAlchemist\Traits\Array\OnClearTrait;
use PHPAlchemist\Traits\Array\OnInsertTrait;
use PHPAlchemist\Traits\Array\OnRemoveTrait;
use PHPAlchemist\Traits\Array\OnSetTrait;
use PHPAlchemist\Traits\ArrayTrait;
use PHPAlchemist\Types\Base\Default;
use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\Number;
use PHPAlchemist\Types\Roll;
use PHPAlchemist\Types\Twine;

/**
 * Abstract class Collection (Objectified Array Class)
 *
 * @package PHPAlchemist\Abstracts
 */
abstract class AbstractIndexedArray implements IndexedArrayInterface
{
    use OnInsertTrait;
    use OnRemoveTrait;
    use OnClearTrait;
    use OnSetTrait;
    use ArrayTrait;

    public static $serializeVersion = 1;

    /**
     * Strict typing - force keys to be integer/Indexed
     *
     * @var boolean $strict Strict typing for int/index array
     */
    protected bool $strict;

    /**
     * Positioning variable
     *
     * @var int $position position sentinel variable
     */
    protected int $position;

    /**
     * Where all the data for the IndexedArray lives
     *
     * @var array $data Object data
     */
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
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet(mixed $offset) : mixed
    {
        return $this->data[$offset];
    }

    /**
     * Offset to set
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     *
     * @return void
     * @since  5.0.0
     */
    public function offsetSet(mixed $offset, mixed $value) : void
    {
        if ($this->isStrict() && !$this->validateKey($offset)) {
            throw new InvalidKeyTypeException(sprintf("Invalid Key type (%s) for Array", gettype($offset)));
        }

        if (isset($this->onInsert) && is_callable($this->onInsert)) {
            $onInsert = $this->onInsert; // may overload __call to check if member exists && is_callable()
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
     * @param mixed $offset The offset to unset.
     *
     * @return void
     */
    public function offsetUnset(mixed $offset) : void
    {

        if (isset($this->onRemove) && is_callable($this->onRemove)) {
            $onRemove = $this->onRemove;
            $onRemove($offset, $this->data[$offset], );
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
     * @link   https://php.net/manual/en/iterator.current.php
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
     * @link   https://php.net/manual/en/iterator.next.php
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
     * @inheritDoc
     */
    public function rewind() : void
    {
        $this->position = 0;
    }

    // endregion

    // region Public Methods

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
        $this->offsetSet(($this->getNextKey())->get(), $data);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(mixed $data) : IndexedArrayInterface
    {
        $this->offsetSet(($this->getNextKey())->get(), $data);

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
     * @param  $rollClass Default: \PHPAlchemist\Type\Roll
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

    /**
     * Get the value of a specified key and remove from
     * array.
     *
     * @param mixed $key The key for the element desired
     *
     * @return mixed
     */
    public function extract(mixed $key) : mixed
    {
        $returnValue = $this->data[$key];
        $this->delete($key);

        return $returnValue;
    }

    public function delete(mixed $key) : void
    {
        if (array_key_exists($key, $this->data)) {
            $this->offsetUnset($key);
        }
    }

    /**
     * Find the key for $value
     *
     * @param mixed $value the value to search the array for
     *
     * @return int
     */
    public function search(mixed $value) : int
    {
        return array_search($value, $this->data);
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

    // endregion

    // region Protected Methods

    /**
     * Retrieves the maximum key value from the data array.
     * If the data array is empty, returns null.
     *
     * @return Number|null The maximum key value or null if the array is empty.
     */
    protected function getMaxKeyValue() : Number|null
    {
        $keys = array_keys($this->data);
        if (empty($keys)) {
            return null;
        }

        return new Number(max($keys));
    }

    /**
     * Retrieves the next key to be used based on the maximum key value currently in use.
     *
     * @return Number|null The next key value as a Number object, or null if no key value is found.
     */
    protected function getNextKey() : Number
    {
        $keyValue = $this->getMaxKeyValue();

        if (is_null($keyValue)) {
            return new Number(0);
        }

        $keyValue->add(1);

        return $keyValue;
    }

    // endregion
}

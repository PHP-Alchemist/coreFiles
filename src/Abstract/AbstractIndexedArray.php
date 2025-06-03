<?php

namespace PHPAlchemist\Abstract;

use PHPAlchemist\Contract\IndexedArrayInterface;
use PHPAlchemist\Contract\StringInterface;
use PHPAlchemist\Exception\InvalidKeyTypeException;
use PHPAlchemist\Exception\UnmatchedClassException;
use PHPAlchemist\Exception\UnmatchedVersionException;
use PHPAlchemist\Trait\ArrayTrait;
use PHPAlchemist\Type\Base\Default;
use PHPAlchemist\Type\Collection;
use PHPAlchemist\Type\Number;
use PHPAlchemist\Type\Roll;
use PHPAlchemist\Type\Twine;

/**
 * Abstract class Collection (Objectified Array Class).
 */
abstract class AbstractIndexedArray extends NaturalArray implements IndexedArrayInterface
{
    use ArrayTrait;

    public static $serializeVersion = 1;

    /**
     * Strict typing - force keys to be integer/Indexed.
     *
     * @var bool Strict typing for int/index array
     */
    protected bool $strict;

    /**
     * Positioning variable.
     *
     * @var int position sentinel variable
     */
    protected int $position;

    /**
     * Where all the data for the IndexedArray lives.
     *
     * @var array<int, mixed> Object data
     */
    protected array $data;

    public function __construct(array $data = [], bool $strict = true)
    {
        $this->strict = $strict;
        if (!$this->validateKeys($data)) {
            throw new InvalidKeyTypeException('Invalid Key type for Array');
        }

        $this->data     = $data;
        $this->position = 0;
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
     * Build Array from data for serialization.
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
     * Take Deserialized Array and populate object with that data.
     *
     * @param array $data
     *
     * @throws UnmatchedClassException
     * @throws UnmatchedVersionException
     *
     * @return void
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
     * Offset to set.
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value  The value to set.
     *
     * @return void
     *
     * @since  5.0.0
     */
    public function offsetSet(mixed $offset, mixed $value) : void
    {
        if ($this->isStrict() && !$this->validateKey($offset)) {
            throw new InvalidKeyTypeException(sprintf('Invalid Key type (%s) for Array', gettype($offset)));
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
     * Offset to unset.
     *
     * @param mixed $offset The offset to unset.
     *
     * @return void
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
    // endregion

    // region Public Methods

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
                if (!$this->validateKey($key)) {
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
        $this->offsetSet($this->getNextKey()->get(), $data);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(mixed $data) : IndexedArrayInterface
    {
        $this->offsetSet($this->getNextKey()->get(), $data);

        return $this;
    }

    /**
     * Find intersection of this and another collection - I would really like to explore putting this into the
     * CollectionInterface but for now  it's going to be a non-contracted function. I also REALLY would like to make a
     * strict option that allows for type matching.
     *
     * @param Collection $secondCollection
     *
     * @throws InvalidKeyTypeException
     *
     * @return Collection
     */
    public function intersection(Collection $secondCollection) : Collection
    {
        return new Collection(
            array_values(
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
     * Convert AbstractCollection to a AbstractList (Roll).
     *
     * @param Collection $indexes
     * @param            $rollClass Default: \PHPAlchemist\Type\Roll
     *
     * @throws \Exception
     *
     * @return AbstractList
     */
    public function toRoll(Collection $indexes = new Collection(), $rollClass = Roll::class) : AbstractList
    {
        if ($indexes->count() > 0 && $indexes->count() !== $this->count()) {
            throw new \Exception('Indexes count mismatch');
        }

        if ($indexes->count() === 0) {
            $indexes->setData(range(0, $this->count() - 1));
        }

        return new $rollClass(array_combine($indexes->getData(), $this->getData()));
    }

    /**
     * Find the key for $value.
     *
     * @param mixed $value the value to search the array for
     *
     * @return int|false
     */
    public function search(mixed $value) : int|false
    {
        return array_search($value, $this->data);
    }
    // endregion

    // region Protected Methods

    /**
     * Retrieves the maximum key value from the data array.
     * If the data array is empty, returns null.
     *
     * @return Number|null The maximum key value or null if the array is empty.
     */
    protected function getMaxKeyValue() : ?Number
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

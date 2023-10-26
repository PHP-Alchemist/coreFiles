<?php

namespace PHPAlchemist\Type\Base;

use PHPAlchemist\Exceptions\InvalidKeyTypeException;
use PHPAlchemist\Exceptions\UnmatchedClassException;
use PHPAlchemist\Exceptions\UnmatchedVersionException;
use PHPAlchemist\Type\Base\Contracts\DictionaryInterface;

/**
 * Class AbstractDictionary
 *
 * @package PHPAlchemist\Type\Base
 */
abstract class AbstractDictionary implements DictionaryInterface
{
    public static $serialize_version = 1;

    /** @var int $position position sentinel variable */
    protected $position;

    /** @var array $keys */
    protected $keys = [];

    /** @var array $values */
    protected $values = [];

    public function __construct($data = [])
    {
        $this->setData($data);
        $this->position = 0;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     * @throws InvalidKeyTypeException
     */
    public function add($key, $value) : DictionaryInterface
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     * @throws InvalidKeyTypeException
     */
    public function set($key, $value) : DictionaryInterface
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    public function get($key) : mixed
    {
        return $this->offsetGet($key);
    }

    public function getKeys() : array
    {
        return $this->keys;
    }

    public function getValues() : array
    {
        return $this->values;
    }

    public function count() : int
    {
        return count($this->keys);
    }

    // Iterator
    public function rewind() : void
    {
        $this->position = 0;
    }

    public function valid() : bool
    {
        return isset($this->keys[$this->position]);
    }

    public function key() : mixed
    {
        return array_keys($this->keys)[$this->position];
    }

    public function next() : void
    {
        ++$this->position;
    }

    // not part of Iterator
    public function prev() : void
    {
        --$this->position;
    }

    public function current() : mixed
    {
        return ($this->valid()) ? array_values($this->values)[$this->position] : false;
    }

    // ArrayAccess

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) : void
    {
        $offsetPosition = $this->getOffsetPosition($offset);

        unset($this->keys[$offsetPosition],
            $this->values[$offsetPosition]
        );
    }


    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return $this
     * @since 5.0.0
     * @throws InvalidKeyTypeException
     */
    public function offsetSet($offset, $value) : void
    {
        if (!$this->validateKey($offset)) {
            throw new InvalidKeyTypeException(sprintf("Invalid Key type (%s) for Dictionary", gettype($offset)));
        }

        if (!$this->offsetExists($offset)) {
            $this->keys[] = $offset;
        }

        $position                = $this->getOffsetPosition($offset);
        $this->values[$position] = $value;
    }

    /**
     * Get raw data in PHP Array
     *
     * @return array
     */
    public function getData() : array
    {
        return array_combine($this->keys, $this->values);
    }

    /**
     * @param array $data
     *
     * @return $this
     * @throws InvalidKeyTypeException
     */
    public function setData(array $data) : DictionaryInterface
    {
        $this->validateKeys($data);
        foreach ($data as $key => $value) {
            $this->add($key, $value);
        }

        return $this;
    }

    /**
     * @param mixed $offset
     * @return bool|mixed
     */
    public function offsetGet($offset) : mixed
    {
        if ($this->offsetExists($offset)) {
            $combined = $this->getData();

            return $combined[$offset];
        }

        return false;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) : bool
    {
        $flippedArray = array_flip($this->keys);

        return (isset($flippedArray[$offset]));
    }

    /**
     * @param $offset
     *
     * @return mixed
     */
    protected function getOffsetPosition($offset)
    {
        $reverseKeys = array_flip($this->keys);

        return ($this->offsetExists($offset)) ? $reverseKeys[$offset] : false;

    }

    /**
     * @param array $dataSet
     *
     * @return bool
     * @throws InvalidKeyTypeException
     */
    protected function validateKeys(array $dataSet)
    {
        foreach (array_keys($dataSet) as $key) {
            if (!($this->validateKey($key))) {
                throw new InvalidKeyTypeException("Key (" . $key . ") is not a valid type.");
            }
        }

        return true;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    protected function validateKey($key)
    {
        return is_string($key) || is_int($key);
    }

    public function __serialize() : array
    {
        return [
            'version' => static::$serialize_version,
            'model'   => get_class($this),
            'data'    => $this->getData(),
        ];
    }

    public function __unserialize(array $data) : void
    {
        if ($data['model'] !== get_class($this)) {
            throw new UnmatchedClassException();
        }

        if ($data['version'] !== static::$serialize_version) {
            throw new UnmatchedVersionException();
        }

        $this->setData($data['data']);
    }

}
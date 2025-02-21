<?php

namespace PHPAlchemist\Traits;

use Exception;

/**
 * Trait that adds get($fieldName), set($fieldName, $values), is($boolFieldName).
 */
trait AccessorTrait
{
    const STRING_POSITION_BEGINNING = 0;
    const STRING_POSITION_TWO       = 2;
    const STRING_POSITION_THREE     = 3;

    /**
     * Magic.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $position = self::STRING_POSITION_THREE;
        $verb     = $this->getMethodVerb($method, $position);
        if (!in_array($verb, ['set', 'get'])) {
            $position = self::STRING_POSITION_TWO;
            $verb     = $this->getMethodVerb($method, $position);
            if (!in_array($verb, ['is'])) {
                throw new Exception("No Method ($method) exists on ".get_class($this));
            }
        }

        $name = lcfirst(substr($method, $position));

        if (method_exists($this, $verb)) {
            if (property_exists($this, lcfirst($name))) {
                return call_user_func_array([$this, $verb], array_merge([lcfirst($name)], $arguments));
            } else {
                throw new Exception("Variable ($name) Not Found");
            }
        }
    }

    /**
     * Get the verb from the method name being called.
     * e.g. [get]Data(), [set]Name(), [is]Active().
     *
     * @param $method
     * @param $position
     *
     * @return string
     */
    protected function getMethodVerb($method, $position = self::STRING_POSITION_THREE) : string
    {
        return substr($method, self::STRING_POSITION_BEGINNING, $position);
    }

    /**
     * Standard (simple) getter.
     *
     * @param string $fieldName
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function get($fieldName) : mixed
    {
        if (!property_exists($this, $fieldName)) {
            throw new \Exception("Variable ($fieldName) Not Found");
        }

        return $this->$fieldName;
    }

    /**
     * Standard (simple) Setter.
     *
     * @param string $fieldName
     * @param mixed  $value
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function set($fieldName, $value) : bool
    {
        if (!property_exists($this, $fieldName)) {
            throw new \Exception("Variable ($fieldName) Not Found");
        }

        $this->$fieldName = $value;

        return true;
    }

    /**
     * Boolean Getter.
     *
     * @param string $fieldName
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function is($fieldName) : bool
    {
        if (!is_bool($this->$fieldName)) {
            throw new \Exception('Cannot call is() on non-boolean variable ('.$fieldName.').');
        }

        return $this->get($fieldName);
    }
}

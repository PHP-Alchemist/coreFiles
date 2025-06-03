<?php

namespace PHPAlchemist\Trait;

use PHPAlchemist\Exception\IsMethodCalledOnNonBooleanException;
use PHPAlchemist\Exception\MethodNotFoundException;
use PHPAlchemist\Exception\VariableNotFoundException;

/**
 * Trait that adds get($fieldName), set($fieldName, $values), is($boolFieldName).
 *
 * @author Micah Breedlove <druid628@gmail.com>
 */
trait AccessorTrait
{
    const int STRING_POSITION_BEGINNING = 0;
    const int STRING_POSITION_TWO       = 2;
    const int STRING_POSITION_THREE     = 3;

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
                throw new MethodNotFoundException("No Method ($method) exists on ".get_class($this));
            }
        }

        $name = lcfirst(substr($method, $position));

        if (method_exists($this, $verb)) {
            if (property_exists($this, lcfirst($name))) {
                return call_user_func_array([$this, $verb], array_merge([lcfirst($name)], $arguments));
            } else {
                throw new VariableNotFoundException("Variable ($name) Not Found");
            }
        }
    }

    /**
     * Get the verb from the method name being called.
     * e.g. [get]Data(), [set]Name(), [is]Active().
     */
    protected function getMethodVerb(mixed $method, int $position = self::STRING_POSITION_THREE) : string
    {
        return substr($method, self::STRING_POSITION_BEGINNING, $position);
    }

    /**
     * Standard (simple) getter.
     *
     * @throws VariableNotFoundException
     */
    public function get(string $fieldName) : mixed
    {
        if (!property_exists($this, $fieldName)) {
            throw new VariableNotFoundException("Variable ($fieldName) Not Found");
        }

        return $this->$fieldName;
    }

    /**
     * Standard (simple) Setter.
     *
     * @throws VariableNotFoundException
     */
    public function set(string $fieldName, mixed $value) : bool
    {
        if (!property_exists($this, $fieldName)) {
            throw new VariableNotFoundException("Variable ($fieldName) Not Found");
        }

        $this->$fieldName = $value;

        return true;
    }

    /**
     * Boolean Getter.
     *
     * @throws \Exception
     */
    public function is(string $fieldName) : bool
    {
        if (!is_bool($this->$fieldName)) {
            throw new IsMethodCalledOnNonBooleanException('Cannot call is() on non-boolean variable ('.$fieldName.').');
        }

        return $this->get($fieldName);
    }
}

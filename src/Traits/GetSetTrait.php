<?php

namespace PHPAlchemist\Traits;


/**
 * Trait that adds get($fieldName), set($fieldName, $values), is($boolFieldName)
 *
 * @package PHPAlchemist\Traits
 * @deprecated  Will be renamed to AccessorTrait in 3.0
 */
trait GetSetTrait
{
    /**
     * Standard (simple) getter
     *
     * @param string $fieldName
     * @return mixed
     * @throws \Exception
     *
     */
    public function get($fieldName) : mixed
    {
        if (!property_exists($this, $fieldName)) {
            throw new \Exception("Variable ($fieldName) Not Found");
        }

        return $this->$fieldName;
    }

    /**
     * Standard (simple) Setter
     *
     * @param string $fieldName
     * @param mixed $value
     * @return boolean
     * @throws \Exception
     *
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
     * Boolean Getter
     *
     * @param string $fieldName
     * @return bool
     * @throws \Exception
     */
    public function is($fieldName) : bool
    {
        if (!is_bool($this->$fieldName)) {
            throw new \Exception("Cannot call is() on non-boolean variable (" . $fieldName . ").");
        }

        return $this->get($fieldName);
    }

}
<?php

namespace PHPAlchemist\Traits;

use Exception;

/**
 * Adds the capability to have getters and setters for class members so that a property on a class such as `status` would
 * magically gain `setStatus($argument)` and `getStatus()`
 *
 * @package PHPAlchemist\Traits
 */
trait MagicGetSetTrait
{
    const STRING_POSITION_BEGINNING = 0;
    const STRING_POSITION_TWO       = 2;
    const STRING_POSITION_THREE     = 3;

    use GetSetTrait;

    /**
     * Magic
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $arguments)
    {
        $position = self::STRING_POSITION_THREE;
        $verb     = $this->getMethodVerb($method, $position);
        if (!in_array($verb, ['set', 'get'])) {
            $position = self::STRING_POSITION_TWO;
            $verb     = $this->getMethodVerb($method, $position);
            if (!in_array($verb, ['is'])) {
                throw new Exception("No Method ($method) exists on " . get_class($this));
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
        throw new Exception("No Method ($method) exists on " . get_class($this));
    }

    /**
     * Get the verb from the method name being called.
     * e.g. [get]Data(), [set]Name(), [is]Active()
     *
     * @param $method
     * @param $position
     * @return string
     */
    protected function getMethodVerb($method, $position = self::STRING_POSITION_THREE) : string
    {
        return substr($method, self::STRING_POSITION_BEGINNING, $position);
    }

}
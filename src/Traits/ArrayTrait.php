<?php

namespace PHPAlchemist\Traits;

/**
 * @package PHPAlchemist\Traits
 */
trait ArrayTrait
{
    /**
     * sum values in data by key
     *
     * @param string $index
     * @return int result
     *
     * source: http://www.php.net/manual/en/function.array-sum.php#85548
     */
    public function sumByKey(mixed $index) : int
    {
        if (!is_array($this->data) || sizeof($this->data) < 1) {
            return 0;
        }
        $ret = 0;
        foreach ($this->data as $key => $value) {
            $ret += (isset($value[$index])) ? $value[$index] : 0;
        }

        return $ret;
    }
}

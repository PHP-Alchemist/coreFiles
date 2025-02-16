<?php

namespace PHPAlchemist\Traits;

/**
 * Collection of usable CLI functions.
 *
 * @package PHPAlchemist\Traits
 */
trait CLITrait
{
    /**
     * tests to see if class is being executed from command line.
     *
     * @return bool
     */
    public function isCli() : bool
    {
        return php_sapi_name() === 'cli';
    }
}

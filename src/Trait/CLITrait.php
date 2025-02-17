<?php

namespace PHPAlchemist\Trait;

/**
 * Collection of usable CLI functions.
 *
 * @method bool isCli()
 * @package PHPAlchemist\Trait
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

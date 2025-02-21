<?php

namespace PHPAlchemist\Traits;

/**
 * Collection of usable CLI functions.
 *
 * @method bool isCli()
 */
trait CLITrait
{
    /**
     * tests to see if class is being executed from command line.
     *
     * @return bool
     */
    public function isCli()
    {
        return php_sapi_name() === 'cli';
    }
}

<?php

namespace PHPAlchemist\Trait;

/**
 * Collection of usable CLI functions.
 *
 * @package PHPAlchemist\Trait
 * @author Micah Breedlove <druid628@gmail.com>
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

<?php

namespace PHPAlchemist\Core\Traits;

trait CLITrait
{
    /**
     * tests to see if class is being executed from command line
     *
     * @return boolean
     */
    public function isCli()
    {
        return php_sapi_name() === "cli";
    }

}
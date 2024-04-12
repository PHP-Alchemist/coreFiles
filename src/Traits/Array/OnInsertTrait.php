<?php

namespace PHPAlchemist\Traits\Array;

trait OnInsertTrait
{

    protected \Closure $onInsertCallback;

    /**
     * Define a callable function to be executed on Insertion of a [key and] value
     *
     * @param callable $onInsertCallback callable function accepting two arguments mixed $key, mixed $value
     *
     * @return void
     */
    public function onInsertCallback(callable $onInsertCallback) : void
    {
        $this->onInsertCallback = $onInsertCallback;
    }

}

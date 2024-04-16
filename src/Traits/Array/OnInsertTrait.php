<?php

namespace PHPAlchemist\Traits\Array;

trait OnInsertTrait
{

    protected \Closure $onInsert;

    protected \Closure $onInsertComplete;

    /**
     * Define a callable function to be executed on Insertion of a [key and] value
     * Callback will be executed on inserted key and value
     *
     * @param callable $onInsert callable function accepting two arguments mixed $key, mixed $value
     *
     * @return void
     */
    public function setOnInsert(callable $onInsert) : void
    {
        $this->onInsert = $onInsert;
    }

    /**
     * Define a callable function to be executed after the Insertion of a [key and] value
     * Callback will be executed on data living on object
     *
     * @param callable $onInsert callable function accepting two arguments mixed $key, mixed $value
     *
     * @return void
     */
    public function setOnInsertComplete(callable $onInsertCompleteCallback) : void
    {
        $this->onInsertComplete = $onInsertCompleteCallback;
    }

}

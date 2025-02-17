<?php

namespace PHPAlchemist\Trait\Array;

/**
 * @package PHPAlchemist\Trait\Array
 */
trait OnInsertTrait
{
    protected \Closure $onInsert;

    protected \Closure $onInsertComplete;

    /**
     * Define a callable function to be executed on Insertion of a [key and] value
     * Callback will be executed on inserted key and value.
     *
     * @param callable $onInsertCallBack callable function accepting two arguments mixed $key, mixed $value
     *
     * @return void
     */
    public function setOnInsert(callable $onInsertCallBack) : void
    {
        $this->onInsert = $onInsertCallBack;
    }

    /**
     * Define a callable function to be executed after the Insertion of a [key and] value
     * Callback will be executed on data living on object.
     *
     * @param callable $onInsertCompleteCallback callable function accepting two arguments mixed $key, mixed $value
     *
     * @return void
     */
    public function setOnInsertComplete(callable $onInsertCompleteCallback) : void
    {
        $this->onInsertComplete = $onInsertCompleteCallback;
    }
}

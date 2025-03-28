<?php

namespace PHPAlchemist\Trait\Array;

use Closure;

trait OnSetTrait
{
    protected Closure $onSet;

    protected Closure $onSetComplete;

    /**
     * Define a callable function to be executed on Setting of data
     * Callback will be executed on the data being set to object.
     *
     * @param Closure $onSetCallback callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnSet(Closure $onSetCallback) : void
    {
        $this->onSet = $onSetCallback;
    }

    /**
     * Define a callable function to be executed on Setting of data
     * Callback will be executed on data living on object.
     *
     * @param Closure $onSetCompleteCallback callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnSetComplete(Closure $onSetCompleteCallback) : void
    {
        $this->onSetComplete = $onSetCompleteCallback;
    }
}

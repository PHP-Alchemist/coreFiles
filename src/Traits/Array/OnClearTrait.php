<?php

namespace PHPAlchemist\Traits\Array;

use \Closure;

trait OnClearTrait
{

    protected Closure $onClear;

    protected Closure $onClearComplete;

    /**
     * Define a callable function to be executed on clearing of data
     * Call back will be executed against data on object prior to clearing.
     *
     * @param Closure $onClear callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnClear(Closure $onClear) : void
    {
        $this->onClear = $onClear;
    }

    /**
     * Define a callable function to be executed on clearing of data
     * Call back will be executed against remaining data on object.
     *
     * @param Closure $onClearCompleteCallback callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnClearComplete(Closure $onClearCompleteCallback) : void
    {
        $this->onClearComplete = $onClearCompleteCallback;
    }

}
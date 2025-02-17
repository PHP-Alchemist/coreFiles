<?php

namespace PHPAlchemist\Trait\Array;

use Closure;

/**
 * @package PHPAlchemist\Trait\Array
 */
trait OnClearTrait
{
    protected Closure $onClear;

    protected Closure $onClearComplete;

    /**
     * Define a callable function to be executed on clearing of data
     * Call back will be executed against data on object prior to clearing.
     *
     * @param Closure $onClearCallBack callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnClear(Closure $onClearCallBack) : void
    {
        $this->onClear = $onClearCallBack;
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

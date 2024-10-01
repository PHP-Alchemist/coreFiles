<?php

namespace PHPAlchemist\Traits\Array;

use Closure;

trait OnRemoveTrait
{

    protected Closure $onRemove;

    protected Closure $onRemoveComplete;

    /**
     * Define a callable function to be executed on removing of a key [and value]
     * Call back will be executed against the data being removed from the object.
     *
     * @param Closure $onRemoveCallback callable function accepting two arguments mixed $key and mixed $value
     *
     * @return void
     */
    public function setOnRemove(Closure $onRemoveCallback) : void
    {
        $this->onRemove = $onRemoveCallback;
    }

    /**
     * Define a callable function to be executed on removing of a key [and value]
     * Call back will be executed against remaining data on object.
     *
     * @param Closure $onRemoveCompleteCallback callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnRemoveComplete(Closure $onRemoveCompleteCallback) : void
    {
        $this->onRemoveComplete = $onRemoveCompleteCallback;
    }

}

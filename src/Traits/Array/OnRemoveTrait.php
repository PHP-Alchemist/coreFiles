<?php

namespace PHPAlchemist\Traits\Array;

use Closure;

trait OnRemoveTrait
{

    protected $onRemove;
    protected $onRemoveComplete;

    /**
     * Define a callable function to be executed on removing of a key [and value]
     * Call back will be executed against remaining data on object.
     *
     * @param callable $onRemoveCallback callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnRemove(Closure $onRemoveCallback) : void
    {
        $this->onRemove = $onRemoveCallback;
    }

    public function setOnRemoveComplete(Closure $onRemoveCompleteCallback) : void
    {
        $this->onRemoveComplete = $onRemoveCompleteCallback;
    }

}

<?php

namespace PHPAlchemist\Traits\Array;

trait OnRemoveTrait
{

    protected $onRemoveCallback;

    /**
     * Define a callable function to be executed on Removeing of a [key and] value
     *
     * @param callable $onRemoveCallback callable function accepting one argument array $data
     *
     * @return void
     */
    public function setOnRemoveCallback(callable $onRemoveCallback) : void
    {
        $this->onRemoveCallback = $onRemoveCallback;
    }

}

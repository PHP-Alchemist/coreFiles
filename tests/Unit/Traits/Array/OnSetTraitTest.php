<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Types\Collection;
use PHPUnit\Framework\TestCase;

class OnSetTraitTest extends TestCase
{

    public function testOnSet()
    {
        $onSetCallback = function (array &$data) {
            array_walk($data, function (&$value, $key) {
                $value = strtoupper($value);
            });
        };

        $collection = new Collection();
        $collection->setOnSet($onSetCallback);
        $collection->setData([
            9  => 'ix',
            10 => 'x',
            11 => 'xi',
        ]);

        $this->assertEquals('X', $collection->get(10));

    }

    public function testOnSetComplete()
    {
        $onSetCompleteCallback = function (array &$data) {
            array_walk($data, function (&$value, $key) {
                $value = strtoupper($value);
            });
        };

        $collection = new Collection();
        $collection->setOnSetComplete($onSetCompleteCallback);
        $collection->setData([
            9  => 'ix',
            10 => 'x',
            11 => 'xi',
        ]);

        $this->assertEquals('X', $collection->get(10));

    }

}

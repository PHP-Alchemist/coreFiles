<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Types\Collection;
use PHPUnit\Framework\TestCase;

class OnClearTraitTest extends TestCase
{

    public function testOnClear()
    {
        $onClearCallback = function (array &$data) {
            $this->assertNotEmpty($data);
            foreach (range(9, 11) as $item) {
                $this->assertIsString($data[$item]);
            }
        };

        $defaultData = [
            9  => 'ix',
            10 => 'x',
            11 => 'xi',
        ];
        $collection  = new Collection($defaultData);
        $collection->setOnClear($onClearCallback);
        $this->assertEquals($defaultData, $collection->getData());
        $collection->clear();

    }

    public function testOnClearComplete()
    {
        $onClearCompleteCallback = function (array &$data) {
           $this->assertEmpty($data);
        };

        $defaultData = [
            9  => 'ix',
            10 => 'x',
            11 => 'xi',
        ];
        $collection  = new Collection($defaultData);
        $collection->setOnClearComplete($onClearCompleteCallback);
        $this->assertEquals($defaultData, $collection->getData());
        $collection->clear();

    }

}

<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Types\Collection;
use PHPUnit\Framework\TestCase;

class OnRemoveTraitTest extends TestCase
{

    public function testInsertCallbackforOffsetUnset()
    {
        $rebalance = function (array &$data) {
            $data = array_values($data);
        };

        $collection = new Collection();
        $collection->setOnRemoveCallback($rebalance);
        $collection->add("Stuff");
        $collection->offsetSet(9, 'IX');
        $collection->offsetSet(10, 'x');
        $collection->offsetSet(11, 'XI');
        $this->assertEquals([
            0  => 'Stuff',
            9  => 'IX',
            10 => 'x',
            11 => 'XI',
        ], $collection->getData());
        $collection->offsetUnset(0);

        $this->assertEquals([
                             'IX',
                             'x',
                             'XI',
        ], $collection->getData());

    }

    public function testInsertCallbackforAdd()
    {
        $rebalance = function (array &$data) {
            array_walk($data, function (mixed &$value, int $key) {
                $value = strtoupper($value);
            });
        };

        $collection = new Collection();
        $collection->setOnRemoveCallback($rebalance);
        $collection->add('ix');
        $collection->add('alpha');
        $collection->add('x');
        $collection->add('xi');

        $collection->delete($collection->search('alpha'));

        $this->assertEquals([
            0 => 'IX',
            2 => 'X',
            3 => 'XI',
        ], $collection->getData());
    }
}

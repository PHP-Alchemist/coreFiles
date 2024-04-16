<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Types\Collection;
use PHPUnit\Framework\TestCase;

class OnRemoveTraitTest extends TestCase
{

    public function testOnRemove()
    {
        $lowerCase = function (array &$data) {
            array_walk($data, function (&$value, $key){
                $value = strtolower($value);
            });
        };

        $collection = new Collection();
        $collection->setOnRemove($lowerCase);
        $collection->add("Stuff");
        $collection->add("Thangs");
        $collection->add("Coral");
        $collection->add("Corel");
        $collection->offsetSet(13, 'XIII');
        $this->assertEquals([
            0  => 'Stuff',
            1  => 'Thangs',
            2  => 'Coral',
            3  => 'Corel',
            13 => 'XIII',
        ], $collection->getData());

        $collection->delete($collection->search('Corel'));

        $this->assertEquals([
            0 => 'stuff',
            1 => 'thangs',
            2 => 'coral',
            13 => 'xiii',
        ], $collection->getData());

    }

    public function testRemoveCompleteForOffsetUnset()
    {
        $rebalance = function (array &$data) {
            $data = array_values($data);
        };

        $collection = new Collection();
        $collection->setOnRemoveComplete($rebalance);
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

    public function testRemoveCompleteForRemove()
    {
        $rebalance = function (array &$data) {
            array_walk($data, function (mixed &$value, int $key) {
                $value = strtoupper($value);
            });
        };

        $collection = new Collection();
        $collection->setOnRemoveComplete($rebalance);
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

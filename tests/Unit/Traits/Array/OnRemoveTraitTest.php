<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Abstracts\AbstractAssociativeArray;
use PHPAlchemist\Abstracts\AbstractIndexedArray;
use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\HashTable;
use PHPAlchemist\Types\Number;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractIndexedArray::class)]
#[CoversClass(AbstractAssociativeArray::class)]
#[CoversClass(Number::class)]
class OnRemoveTraitTest extends TestCase
{

    public function testCollectionOnRemove()
    {
        $test = function (int $key, mixed $value) {
            $this->assertEquals('Corel', $value);
            $this->assertEquals(3, $key);
        };

        $collection = new Collection();
        $collection->setOnRemove($test);
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
            0  => 'Stuff',
            1  => 'Thangs',
            2  => 'Coral',
            13 => 'XIII',
        ], $collection->getData());

    }

    public function testCollectionOnRemoveCompleteForOffsetUnset()
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

    public function testCollectionRemoveComplete()
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

    public function testHashTableOnRemove()
    {
        $test = function (mixed $key, mixed $value) {
            $this->assertEquals('Corel', $value);
            $this->assertEquals('four', $key);
        };

        $hashTable = new HashTable();
        $hashTable->setOnRemove($test);
        $hashTable->add("one", "Stuff");
        $hashTable->add("two", "Thangs");
        $hashTable->add("three", "Coral");
        $hashTable->add("four", "Corel");
        $hashTable->offsetSet('XIII', 'thirteen');
        $this->assertEquals([
            'one'   => 'Stuff',
            'two'   => 'Thangs',
            'three' => 'Coral',
            'four'  => 'Corel',
            'XIII'  => 'thirteen',
        ], $hashTable->getData());

        $hashTable->delete($hashTable->search('Corel'));

        $this->assertEquals([
            'one'   => 'Stuff',
            'two'   => 'Thangs',
            'three' => 'Coral',
            'XIII'  => 'thirteen',
        ], $hashTable->getData());

    }

    public function testHashTableRemoveComplete()
    {
        $rebalance = function (array &$data) {
            array_walk($data, function (mixed &$value, mixed $key) {
                $value = strtoupper($value);
            });
        };

        $hashTable = new HashTable();
        $hashTable->setOnRemoveComplete($rebalance);
        $hashTable->add('one', 'ix');
        $hashTable->add('two', 'alpha');
        $hashTable->add('three', 'x');
        $hashTable->add('four', 'xi');

        $hashTable->delete($hashTable->search('alpha'));

        $this->assertEquals([
            'one'   => 'IX',
            'three' => 'X',
            'four'  => 'XI',
        ], $hashTable->getData());
    }

}

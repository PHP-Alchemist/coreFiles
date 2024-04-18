<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\HashTable;
use PHPUnit\Framework\TestCase;

class OnSetTraitTest extends TestCase
{

    public function testCollectionOnSet()
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

    public function testCollectionOnSetComplete()
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

    public function testHashTableOnSet()
    {
        $onSetCallback = function (array &$data) {
            array_walk($data, function (&$value, $key) {
                $value = strtoupper($value);
            });
        };

        $hashTable = new HashTable();
        $hashTable->setOnSet($onSetCallback);
        $hashTable->setData([
            'nine'   => 'ix',
            'ten'    => 'x',
            'eleven' => 'xi',
        ]);

        $this->assertEquals('X', $hashTable->get('ten'));

    }

    public function testHashTableOnSetComplete()
    {
        $onSetCompleteCallback = function (array &$data) {
            array_walk($data, function (&$value, $key) {
                $value = strtoupper($value);
            });
        };

        $hashTable = new HashTable();
        $hashTable->setOnSetComplete($onSetCompleteCallback);
        $hashTable->setData([
            'nine'   => 'ix',
            'ten'    => 'x',
            'eleven' => 'xi',
        ]);

        $this->assertEquals('X', $hashTable->get('ten'));

    }
}

<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Abstracts\AbstractAssociativeArray;
use PHPAlchemist\Abstracts\AbstractIndexedArray;
use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\HashTable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractIndexedArray::class)]
#[CoversClass(AbstractAssociativeArray::class)]
class OnClearTraitTest extends TestCase
{

    public function testCollectionOnClear()
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

    public function testCollectionOnClearComplete()
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

    public function testHashTableOnClear()
    {
        $onClearCallback = function (array &$data) {
            $this->assertNotEmpty($data);
            foreach ($data as $item) {
                $this->assertIsString($item);
            }
        };

        $defaultData = [
            'ix' => '9',
            'x'  => '10',
            'xi' => '11',
        ];
        $hashTable  = new HashTable($defaultData);
        $hashTable->setOnClear($onClearCallback);
        $this->assertEquals($defaultData, $hashTable->getData());
        $hashTable->clear();

    }

    public function testHashTableOnClearComplete()
    {
        $onClearCompleteCallback = function (array &$data) {
            $this->assertEmpty($data);
        };

        $defaultData = [
            'ix' => '9',
            'x'  => '10',
            'xi' => '11',
        ];
        $hashTable  = new HashTable($defaultData);
        $hashTable->setOnClearComplete($onClearCompleteCallback);
        $this->assertEquals($defaultData, $hashTable->getData());
        $hashTable->clear();

    }
}

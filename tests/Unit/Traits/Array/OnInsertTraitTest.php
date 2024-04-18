<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\HashTable;
use PHPUnit\Framework\TestCase;

class OnInsertTraitTest extends TestCase
{

    public function testCollectionInsertCallbackForOffsetSet()
    {
        $x = function (mixed $key, mixed $value) {
            if ($value == 'x' && $key == 10) {
                $value = ucwords($value);
            }

            return [
                    $key,
                    $value,
            ];
        };

        $collection = new Collection();
        $collection->setOnInsert($x);
        $collection->offsetSet(9, 'IX');
        $collection->offsetSet(10, 'x');
        $collection->offsetSet(11, 'XI');

        $this->assertEquals('X', $collection->get(10));

    }

    public function testInsertCallbackForAdd()
    {
        $x = function (mixed $key, mixed $value) {
            $value = strtoupper($value);

            return [
                    $key,
                    $value,
            ];
        };

        $collection = new Collection();
        $collection->setOnInsert($x);
        $collection->add('ix');
        $collection->add('x');
        $collection->add('xi');

        $collection->rewind();
        $this->assertEquals('IX', $collection->current());
        $collection->next();
        $this->assertEquals('X', $collection->current());
        $collection->next();
        $this->assertEquals('XI', $collection->current());

    }

    public function testCollectionOnInsertComplete()
    {

        $callBack = function (array &$data) {
            array_walk($data, function (mixed &$value, int $key) {
                $value = strtoupper($value);
            });
        };

        $collection = new Collection();
        $collection->setOnInsertComplete($callBack);
        $collection->offsetSet(9, 'IX');
        $collection->offsetSet(10, 'x');
        $collection->offsetSet(11, 'XI');

        $this->assertEquals('X', $collection->get(10));
    }

    public function testHashTableInsertCallback()
    {
        $x = function (mixed $key, mixed $value) {
            if ($value == 'x' && $key == 'ten') {
                $value = ucwords($value);
            }

            return [
                $key,
                $value,
            ];
        };

        $hashTable = new HashTable();
        $hashTable->setOnInsert($x);
        $hashTable->offsetSet('nine', 'IX');
        $hashTable->offsetSet('ten', 'x');
        $hashTable->offsetSet('eleven', 'XI');

        $this->assertEquals('X', $hashTable->get('ten'));

    }

    public function testHashTableOnInsertComplete()
    {

        $callBack = function (array &$data) {
            array_walk($data, function (mixed &$value, string $key) {
                $value = strtoupper($value);
            });
        };

        $hashTable = new HashTable();
        $hashTable->setOnInsertComplete($callBack);

        $hashTable->offsetSet('nine', 'IX');
        $hashTable->offsetSet('ten', 'x');
        $hashTable->offsetSet('eleven', 'XI');

        $this->assertEquals('X', $hashTable->get('ten'));
    }

}

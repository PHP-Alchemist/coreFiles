<?php

namespace Unit\Traits\Array;

use PHPAlchemist\Types\Collection;
use PHPUnit\Framework\TestCase;


class OnInsertTraitTest extends TestCase
{

    public function testInsertCallbackforOffsetSet()
    {
        $x = function (mixed $key, mixed $value) {
            if ($value == 'x' && $key == 10) {
                $value = ucwords($value);
            }

            return [ $key, $value];
        };

        $collection = new Collection();
        $collection->setOnInsertCallback($x);
        $collection->offsetSet(9, 'IX');
        $collection->offsetSet(10, 'x');
        $collection->offsetSet(11, 'XI');

        $this->assertEquals('X', $collection->get(10));

    }

    public function testInsertCallbackforAdd()
    {
        $x = function (mixed $key, mixed $value) {
                $value = strtoupper($value);
            return [ $key, $value];
        };

        $collection = new Collection();
//        $collection->aphaCenturi();
        $collection->setOnInsertCallback($x);
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
}
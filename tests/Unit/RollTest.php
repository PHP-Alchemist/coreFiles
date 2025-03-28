<?php

namespace Unit;

use PHPAlchemist\Abstract\AbstractIndexedArray;
use PHPAlchemist\Abstract\AbstractList;
use PHPAlchemist\Type\Number;
use PHPAlchemist\Type\Roll;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Roll::class)]
#[CoversClass(AbstractList::class)]
#[CoversClass(AbstractIndexedArray::class)]
#[CoversClass(Number::class)]
class RollTest extends TestCase
{
    /**
     * @todo Write MO' Tests!
     */

    /**
     * @throws \PHPAlchemist\Exception\InvalidKeyTypeException
     *
     * @return void
     */
    public function testRebalancing()
    {
        $startingArray = ['a', 'b', 'c'];
        /** @var Roll $roll */
        $roll = new Roll($startingArray);
        $roll->add('farfegnugen');
        $roll->offsetSet(15, 'Dr. Pepper');
        $this->assertEquals([0, 1, 2, 3, 4], array_keys($roll->getData()));
        $this->assertEquals([...$startingArray, 'farfegnugen', 'Dr. Pepper'], $roll->getData());
        $roll->offsetUnset(3);
        $this->assertEquals([...$startingArray, 'Dr. Pepper'], $roll->getData());
        $this->assertEquals([0, 1, 2, 3], array_keys($roll->getData()));
    }
}

<?php

namespace Unit;

use PHPAlchemist\Types\Roll;
use PHPUnit\Framework\TestCase;

class RollTest extends TestCase
{
    /**
     * @todo Write MO' Tests!
     */

    /**
     * @return void
     * @throws \PHPAlchemist\Exceptions\InvalidKeyTypeException
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

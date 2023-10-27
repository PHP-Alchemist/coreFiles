<?php

namespace Unit;

use PHPAlchemist\Types\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testNumber()
    {
        $value = new Number(24);
        $this->assertEquals("24", (string)$value->get());
    }

    public function testToString()
    {
        $number = new Number(76);
        $this->assertTrue(is_string((string)$number));
    }
}
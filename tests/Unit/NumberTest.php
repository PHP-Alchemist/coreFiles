<?php

namespace Unit;

use PHPAlchemist\Core\Type\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testNumber()
    {
        $x = new Number(24);
        $this->assertEquals("24", (string) $x->get());
    }
}
<?php

namespace Unit;

use PHPAlchemist\Abstract\AbstractNumber;
use PHPAlchemist\Type\Number;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Number::class)]
#[CoversClass(AbstractNumber::class)]
class NumberTest extends TestCase
{
    public function testNumber()
    {
        $value = new Number(24);
        $this->assertEquals('24', (string) $value->get());
    }

    public function testEquals()
    {
        $value  = 17;
        $number = new Number($value);
        $this->assertTrue($number->equals($value));
        $this->assertEquals($value, $number->get());
    }

    public function testToString()
    {
        $number = new Number(76);
        $this->assertTrue(is_string((string) $number));
    }

    public function testAdd()
    {
        $jordan = 23;
        $number = new Number(77);
        $number->add($jordan);
        $this->assertEquals(100, $number->get());
    }

    public function testSub()
    {
        $jordan = 23;
        $number = new Number(78);
        $number->subtract($jordan);
        $this->assertEquals(55, $number->get());
    }

    public function testMod()
    {
        $number    = new Number(79);
        $remainder = $number->modulus(5);
        $this->assertEquals(4, $remainder);
    }
}

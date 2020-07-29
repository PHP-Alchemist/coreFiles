<?php

namespace tests\Unit;

use PHPAlchemist\Type\ProperString;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{

    public function testStringlength()
    {
        $string = new ProperString("stuff and thangs");
        $this->assertEquals(16, $string->length());
    }


    public function testUpper()
    {
        $string = new ProperString("stuff and thangs");
        $this->assertEquals('STUFF AND THANGS', $string->upper());
    }

    public function testLower()
    {
        $string = new ProperString("stuff and thangs");
        $this->assertEquals('stuff and thangs', $string->lower());

    }

    public function testExplosion()
    {
        $stringTest = new ProperString("stuff and thangs Coral");
        $arrayTest = $stringTest->explode(" ");
        $this->assertInstanceOf("\PHPAlchemist\Type\ProperArray", $arrayTest);
    }

    public function testGetValue()
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest = new ProperString($stringValue);
        $this->assertEquals($stringValue, $stringTest->getValue());

    }

    public function testSetValue()
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest = new ProperString();
        $stringTest->setValue($stringValue);
        $this->assertEquals($stringValue, $stringTest->getValue());

    }

    public function testHasValue()
    {
        $stringValue = 'City';
        $stringTest = new ProperString();
        $this->assertFalse($stringTest->hasValue());
        $stringTest->setValue($stringValue);
        $this->assertTrue($stringTest->hasValue());
        $this->assertEquals($stringValue, $stringTest->getValue());

    }

    public function testToString()
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest = new ProperString($stringValue);
        $this->assertEquals($stringValue, "${stringTest}");

    }
}

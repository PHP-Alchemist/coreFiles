<?php

namespace tests\Unit;

use PHPAlchemist\Type\Twine;
use PHPUnit\Framework\TestCase;

class TwineTest extends TestCase
{

    const COLLECTION_TYPE = "\PHPAlchemist\Type\Collection";

    public function testStringlength()
    {
        $expectedLength = 16;
        $string         = new Twine("stuff and thangs");
        $this->assertEquals($expectedLength, $string->length());
    }


    public function testUpper()
    {
        $string = new Twine("stuff and thangs");
        $this->assertEquals('STUFF AND THANGS', $string->upper());
    }

    public function testLower()
    {
        $string = new Twine("stuff and thangs");
        $this->assertEquals('stuff and thangs', $string->lower());

    }

    public function testExplosion()
    {
        $stringTest = new Twine("stuff and thangs Coral");
        $arrayTest  = $stringTest->explode(" ");
        $this->assertInstanceOf(self::COLLECTION_TYPE, $arrayTest);
    }

    public function testGetValue()
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest  = new Twine($stringValue);
        $this->assertEquals($stringValue, $stringTest->getValue());

    }

    public function testSetValue()
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest  = new Twine();
        $stringTest->setValue($stringValue);
        $this->assertEquals($stringValue, $stringTest->getValue());

    }

    public function testHasValue()
    {
        $stringValue = 'City';
        $stringTest  = new Twine();
        $this->assertFalse($stringTest->hasValue());
        $stringTest->setValue($stringValue);
        $this->assertTrue($stringTest->hasValue());
        $this->assertEquals($stringValue, $stringTest->getValue());

    }

    public function testToString() : void
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest  = new Twine($stringValue);
        $this->assertEquals($stringValue, "${stringTest}");
        $this->assertInstanceOf(\Stringable::class, $stringTest);
    }

    public function testContainsFunctions() : void
    {
        $twine = new Twine("antidisestablishmentarianism");
        $this->assertTrue($twine->startsWith('anti'));
        $this->assertFalse($twine->startsWith('Anti'));
        $this->assertTrue($twine->endsWith('ism'));
        $this->assertFalse($twine->endsWith('iSm'));
        $this->assertTrue($twine->contains('establishment'));
        $this->assertFalse($twine->contains('establishMENT'));

    }
}

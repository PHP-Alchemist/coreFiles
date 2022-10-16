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

    public function testEquals() : void
    {
        $string = new Twine("ABACABB");
        $this->assertTrue($string->equals('ABACABB'));
    }

    public function testIsNullOrEmpty() : void
    {
        $string = new Twine("This is a test of twine functionality");
        $this->assertFalse($string->isNullOrEmpty());
    }

    public function testInsert() : void
    {
        $endValue = 'prisoner 24601';
        $string   = new Twine('prisoner24601');
        $string->insert(' ', 8);

        $this->assertTrue($string->equals($endValue));
        $this->assertEquals($endValue, (string)$string);
    }

    public function testIndexOf() : void
    {
        $endValue = 'prisoner 24601';
        $string   = new Twine('prisoner24601');
        $string->insert(' ', $string->indexOf('2'));

        $this->assertTrue($string->equals($endValue));
        $this->assertEquals($endValue, (string)$string);
    }

    public function testLastIndexOf() : void
    {
        $string = new Twine('ABACABB');
        $this->assertEquals('4', $string->lastIndexOf('A'));
    }

    public function testPadLeft() : void
    {
        $twine = new Twine('ABACABB');
        $twine->padLeft(10, '-');

        $this->assertEquals('---ABACABB', (string)$twine);
    }

    public function testPadRight() : void
    {
        $twine = new Twine('ABACABB');
        $twine->padRight(11, '-');

        $this->assertEquals('ABACABB----', (string)$twine);
    }

    public function testPadBoth() : void
    {
        $twine = new Twine('ABACABB');
        $twine->padBoth(11, '-');

        $this->assertEquals('--ABACABB--', (string)$twine);
    }

    public function testRemove() : void
    {
        $name = new Twine('Michelle Violet Banks');
        $middleName = new Twine('Violet ');
        $offset = $name->indexOf($middleName);
        $count = $middleName->length();

//        die(var_dump($middleName));
        $name->remove($offset, $count);
        $this->assertEquals('Michelle Banks', (string) $name);
    }
}

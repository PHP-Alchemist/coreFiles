<?php

namespace tests\Unit;

use PHPAlchemist\Core\Type\Collection;
use PHPAlchemist\Core\Type\Twine;
use PHPUnit\Framework\TestCase;

class TwineTest extends TestCase
{
    public function testContainsFunctions() : void
    {
        $twine = new Twine("antidisestablishmentarianism");
        $this->assertTrue($twine->startsWith('anti'));
        $this->assertFalse($twine->startsWith('Anti'));
        $this->assertTrue($twine->endsWith('ism'));
        $this->assertFalse($twine->endsWith('iSm'));
        $this->assertTrue($twine->contains('establishment'));
        $this->assertFalse($twine->contains('establishMENT'));
        $this->assertTrue($twine->contains('establishMENT', true));
    }

    public function testEquals() : void
    {
        $string = new Twine("ABACABB");
        $this->assertTrue($string->equals('ABACABB'));
    }

    public function testExplosion()
    {
        $finalValue = [
            'stuff',
            'and',
            'thangs',
            'Coral',
        ];
        $stringTest = new Twine("stuff and thangs Coral");
        /** @var Collection $arrayTest */
        $arrayTest = $stringTest->explode(" ");
        /** @var Collection $arrayTest2 */
        $arrayTest2 = $stringTest->split(" ");
        $this->assertInstanceOf(Collection::class, $arrayTest);
        $this->assertInstanceOf(Collection::class, $arrayTest2);
        $this->assertEquals($finalValue, $arrayTest->getData());
        $this->assertEquals($finalValue, $arrayTest2->getData());
    }

    public function testGetValue()
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest  = new Twine($stringValue);
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

    public function testIndexOf() : void
    {
        $endValue = 'prisoner 24601';
        $string   = new Twine('prisoner24601');
        $string->insert(' ', $string->indexOf('2'));

        $this->assertTrue($string->equals($endValue));
        $this->assertEquals($endValue, (string)$string);
    }

    public function testInsert() : void
    {
        $endValue = 'prisoner 24601';
        $string   = new Twine('prisoner24601');
        $string->insert(' ', 8);

        $this->assertTrue($string->equals($endValue));
        $this->assertEquals($endValue, (string)$string);
    }

    public function testIsNullOrEmpty() : void
    {
        $string = new Twine("This is a test of twine functionality");
        $this->assertFalse($string->isNullOrEmpty());
    }

    public function testLastIndexOf() : void
    {
        $string = new Twine('ABACABB');
        $this->assertEquals('4', $string->lastIndexOf('A'));
    }

    public function testLower()
    {
        $string = new Twine("stuff and thangs");
        $this->assertEquals('stuff and thangs', $string->lower());
    }

    public function testPadBoth() : void
    {
        $twine = new Twine('ABACABB');
        $twine->padBoth(11, '-');

        $this->assertEquals('--ABACABB--', (string)$twine);
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

    public function testRemove() : void
    {
        $name       = new Twine('Michelle Violet Banks');
        $middleName = new Twine('Violet ');
        $offset     = $name->indexOf($middleName);
        $count      = $middleName->length();

        $name->remove($offset, $count);
        $this->assertEquals('Michelle Banks', (string)$name);
    }

    public function testSetValue()
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest  = new Twine();
        $stringTest->setValue($stringValue);
        $this->assertEquals($stringValue, $stringTest->getValue());
    }

    public function testStringlength()
    {
        $expectedLength = 16;
        $string         = new Twine("stuff and thangs");
        $this->assertEquals($expectedLength, $string->length());
    }

    public function testSubstring() : void
    {
        $twine          = new Twine('prisoner24601');
        $value          = $twine->substring(0, 8);
        $prisonerNumber = $twine->substring(8);

        $this->assertEquals('24601', $prisonerNumber);
        $this->assertEquals('prisoner', $value);
        $this->assertInstanceOf(Twine::class, $value);
        $this->assertInstanceOf(Twine::class, $prisonerNumber);
    }

    public function testToString() : void
    {
        $stringValue = 'Stuff & Thangs Coral';
        $stringTest  = new Twine($stringValue);
        $this->assertEquals($stringValue, "{$stringTest}");
        $this->assertInstanceOf(\Stringable::class, $stringTest);
    }

    public function testUpper()
    {
        $string = new Twine("stuff and thangs");
        $this->assertEquals('STUFF AND THANGS', $string->upper());
    }

    public function testReplace()
    {
        $testString = new Twine('Hello World');
        $testString->replace('World', 'Coral');
        $this->assertEquals('Hello Coral', (string) $testString);


        $newTestTwine = new Twine("It is magically Delicious");
        $newTestTwine->replace(['/It/', '/is/', '/magically/', '/Delicious/'], ['Stuff', 'and', 'thangs', 'Coral']);
        $this->assertEquals('Stuff and thangs Coral', $newTestTwine);
    }
}

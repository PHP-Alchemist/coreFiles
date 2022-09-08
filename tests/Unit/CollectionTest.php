<?php

namespace tests\Unit;

use PHPAlchemist\Type\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    // Core-Files Types
    const TWINE_TYPE = '\PHPAlchemist\Type\Twine';
    const COLLECTION_TYPE = 'PHPAlchemist\Type\Collection';

    // Interfaces
    const ARRAYACCESS_TYPE = '\ArrayAccess';
    const ITERATOR_TYPE = '\Iterator';
    const TRAVERSABLE_TYPE = '\Traversable';

    // Exceptions
    const EXCEPTION_TYPE = '\Exception';
    const INVALID_KEY_EXCEPTION = '\PHPAlchemist\Exceptions\InvalidKeyTypeException';
    const READONLY_EXCEPTION = 'PHPAlchemist\Exceptions\ReadOnlyDataException';
    const HTABLE_FULL_EXCEPTION = 'PHPAlchemist\Exceptions\HashTableFullException';

    public function testCount()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('4', $arrayTest->count());
    }

    public function testImplode()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertInstanceOf(self::TWINE_TYPE, $arrayTest->implode(" "));
    }

    public function testNext()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('abc', $arrayTest->current());
        $arrayTest->next();
        $this->assertEquals('bcd', $arrayTest->current());
    }

    public function testPrev()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('abc', $arrayTest->current());
        $arrayTest->next();
        $arrayTest->next();
        $this->assertEquals('cde', $arrayTest->current());
        $arrayTest->prev();
        $this->assertEquals('bcd', $arrayTest->current());

    }

    public function testCurrent()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('abc', $arrayTest->current());
    }

    public function testKey()
    {
        $testArray = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $testArray->next();
        $this->assertEquals(1, $testArray->key());
    }

    public function testsetData()
    {
        $arrayData = [
            'abc',
            'bcd',
            'cde',
            'def',
        ];

        $arrayTest = new Collection();
        $arrayTest->setData($arrayData);

        $this->assertEquals($arrayData, $arrayTest->getData());
    }

    public function testRewind()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $arrayTest->next();
        $arrayTest->next();
        $arrayTest->next();
        $this->assertEquals(3, $arrayTest->key());
        $arrayTest->rewind();
        $this->assertEquals(0, $arrayTest->key());

    }

    public function testOffsets()
    {
        $arrayTest       = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $stuffAndThangs = 'stuff and thangs';

        $this->assertTrue($arrayTest->offsetExists(0));
        $this->assertFalse($arrayTest->offsetExists(25));
        $this->assertEquals('abc', $arrayTest->offsetGet(0));
        $arrayTest->offsetSet(25, $stuffAndThangs);
        $this->assertTrue($arrayTest->offsetExists(25));
        $this->assertEquals($stuffAndThangs, $arrayTest->offsetGet(25));
        $arrayTest->offsetUnset(25);
        $this->assertFalse($arrayTest->offsetExists(25));


        try {
            $arrayTest['doc'] = 'McStuffAndThangs';
        }catch(\Exception $e) {

            $this->assertInstanceOf('\PHPAlchemist\Exceptions\InvalidKeyTypeException', $e);
            $this->assertEquals('Invalid Key type (string) for Array', $e->getMessage());
        }
    }

    public function testInterfaces()
    {
        $arrayTest = new Collection();
        $this->assertInstanceOf('\ArrayAccess', $arrayTest);
        $this->assertInstanceOf('\Iterator', $arrayTest);
        $this->assertInstanceOf('\PHPAlchemist\Type\Base\Contracts\CollectionInterface', $arrayTest);
    }

    public function testPositiveStrictness()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('4', $arrayTest->count());
        $this->assertTrue($arrayTest->isStrict());
        try {
            $x = new Collection([
                'a' => 'abc',
                'b' => 'bcd',
                'c' => 'cde'
            ]);
        } catch (\Exception $e) {

            $this->assertInstanceOf('PHPAlchemist\Exceptions\InvalidKeyTypeException', $e);
        }
    }

    public function testNegativeStrictness()
    {
        $arrayTest = new Collection([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ], false);

        $this->assertEquals('4', $arrayTest->count());
        $this->assertFalse($arrayTest->isStrict());
    }

    public function testArrayAccess()
    {
        $data     = [
            'abc',
            'bcd',
            'cde',
            'def',
        ];
        $arrayTest = new Collection($data);

        $this->assertEquals($data[2], $arrayTest[2]);
    }

    public function testTraversable()
    {
        $data     = [
            'abc',
            'bcd',
            'cde',
            'def',
        ];
        $arrayTest = new Collection($data);

        $this->assertInstanceOf('\Traversable', $arrayTest);
    }
}

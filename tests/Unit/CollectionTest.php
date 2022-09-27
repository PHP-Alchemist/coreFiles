<?php

namespace tests\Unit;

use PHPAlchemist\Exceptions\InvalidKeyTypeException;
use PHPAlchemist\Type\Collection;
use PHPAlchemist\Type\Twine;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    const ARRAYACCESS_TYPE = '\ArrayAccess';
    const ITERATOR_TYPE    = '\Iterator';
    const TRAVERSABLE_TYPE = '\Traversable';
    const EXCEPTION_TYPE   = '\Exception';

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

        $this->assertInstanceOf(Twine::class, $arrayTest->implode(" "));
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
        $arrayTest = new Collection([
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
        } catch (\Exception $e) {

            $this->assertInstanceOf(InvalidKeyTypeException::class, $e);
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
        $data      = [
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
        $data      = [
            'abc',
            'bcd',
            'cde',
            'def',
        ];
        $arrayTest = new Collection($data);

        $this->assertInstanceOf('\Traversable', $arrayTest);
    }

    /**
     * @throws InvalidKeyTypeException
     */
    public function testArraySumKey()
    {
        $testArray = [
            [
                'a' => 14,
                'b' => 42,
            ],
            [
                'a' => 4,
                'b' => 2,
            ],
        ];

        $collection      = new Collection($testArray);
        $emptyCollection = new Collection([]);

        $sum = $collection->sumByKey('a');
        $this->assertEquals('18', $sum);

        $sum2 = $collection->sumByKey('b');
        $this->assertEquals('44', $sum2);

        $sum3 = $emptyCollection->sumByKey('a');
        $this->assertEquals('0', $sum3);

    }

    public function testPushPop()
    {
        $collection = new Collection(['a', 'b', 'c']);
        $collection->push('d');
        $collection->push('e');

        $this->assertEquals('e', $collection->pop());
        $this->assertEquals('d', $collection->pop());
        $this->assertEquals('c', $collection->pop());

        $testArray = ['a','b','c','d','e','f','g'];
        $collection->add($testArray);
        $returnedArray = $collection->pop();
        $this->assertInstanceOf(Collection::class, $returnedArray );
        $this->assertEquals($testArray, $returnedArray->getData());

    }

    public function testAdd()
    {
        $collection = new Collection(['a', 'b', 'c']);
        $collection->push('d');
        $collection->push('e');

        $value = $collection->implode();
        $this->assertEquals('a b c d e', (string) $value);
        $this->assertInstanceOf(Twine::class, $value);
    }

    public function testGet()
    {

        $collection = new Collection(['a', 'b', 'c']);
        $collection->push('d');
        $collection->push('e');
        $collection->offsetSet(42, 'ALPHA');
        $collection->offsetSet(64, 'BRAVO');

        $this->assertEquals('ALPHA', $collection->get(42));
        $this->assertEquals('BRAVO', $collection->get(64));

    }
}

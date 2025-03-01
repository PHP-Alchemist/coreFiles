<?php

namespace tests\Unit;

use PHPAlchemist\Abstracts\AbstractIndexedArray;
use PHPAlchemist\Abstracts\AbstractString;
use PHPAlchemist\Exceptions\InvalidKeyTypeException;
use PHPAlchemist\Exceptions\UnmatchedClassException;
use PHPAlchemist\Exceptions\UnmatchedVersionException;
use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\Number;
use PHPAlchemist\Types\Roll;
use PHPAlchemist\Types\Twine;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Collection::class)]
#[CoversClass(Number::class)]
#[CoversClass(AbstractIndexedArray::class)]
#[CoversClass(AbstractString::class)]
#[CoversClass(UnmatchedClassException::class)]
#[CoversClass(UnmatchedVersionException::class)]
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

    public function testSerializable()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $serializedObject = serialize($arrayTest);

        $this->assertEquals('O:29:"PHPAlchemist\Types\Collection":3:{s:7:"version";i:1;s:5:"model";s:29:"PHPAlchemist\Types\Collection";s:4:"data";a:4:{i:0;s:3:"abc";i:1;s:3:"bcd";i:2;s:3:"cde";i:3;s:3:"def";}}', $serializedObject);
    }

    public function testUnserialize()
    {
        $serializedObject = 'O:29:"PHPAlchemist\Types\Collection":3:{s:7:"version";i:1;s:5:"model";s:29:"PHPAlchemist\Types\Collection";s:4:"data";a:4:{i:0;s:3:"abc";i:1;s:3:"bcd";i:2;s:3:"cde";i:3;s:3:"def";}}';
        $wrongVersion     = 'O:29:"PHPAlchemist\Types\Collection":3:{s:7:"version";i:3;s:5:"model";s:29:"PHPAlchemist\Types\Collection";s:4:"data";a:4:{i:0;s:3:"abc";i:1;s:3:"bcd";i:2;s:3:"cde";i:3;s:3:"def";}}';
        $wrongClass       = 'O:29:"PHPAlchemist\Types\Collection":3:{s:7:"version";i:1;s:5:"model";s:28:"PHPAlchemist\Types\Hashtable";s:4:"data";a:4:{i:0;s:3:"abc";i:1;s:3:"bcd";i:2;s:3:"cde";i:3;s:3:"def";}}';

        $data = unserialize($serializedObject);
        $this->assertInstanceOf('PHPAlchemist\Types\Collection', $data);
        $this->assertEquals('abc', $data[0]);

        try {
            $wrongType = unserialize($wrongClass);
        } catch (\Exception $e2) {
            $this->assertEquals(UnmatchedClassException::ERROR_UNMATCHED_CLASS, $e2->getMessage());
        }

        try {
            $version = unserialize($wrongVersion);
        } catch (\Exception $e) {
            $this->assertEquals(UnmatchedVersionException::ERROR_WRONG_VERSION, $e->getMessage());
        }
    }

    public function testImplode()
    {
        $arrayTest = new Collection([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertInstanceOf(Twine::class, $arrayTest->implode(' '));
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
        $this->assertInstanceOf('\PHPAlchemist\Contracts\IndexedArrayInterface', $arrayTest);
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
                'c' => 'cde',
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

    public function testArrayExtract()
    {
        $testKey   = 2;
        $testValue = 'charlie';
        $testArray = [
            'alpha',
            'bravo',
            'charlie',
            'delta',
            'echo',
            'foxtrot',
        ];
        $collection = new Collection($testArray);

        $extractedValue = $collection->extract($testKey);
        $this->assertEquals($testValue, $extractedValue);
        $this->assertArrayNotHasKey($testKey, $collection);
        $this->assertNotEquals($testArray, $collection->getData());
    }

    public function testPushPop()
    {
        $collection = new Collection(['a', 'b', 'c']);
        $collection->push('d');
        $collection->push('e');

        $this->assertEquals('e', $collection->pop());
        $this->assertEquals('d', $collection->pop());
        $this->assertEquals('c', $collection->pop());

        $testArray = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
        $collection->add($testArray);
        $returnedArray = $collection->pop();
        $this->assertInstanceOf(Collection::class, $returnedArray);
        $this->assertEquals($testArray, $returnedArray->getData());
    }

    public function testFirst()
    {
        $collection = new Collection(['hello', 'stuff', 'and', 'thangs', 'coral']);

        $this->assertEquals('hello', $collection->first());
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

    public function testMerge()
    {
        $collection = new Collection(['a', 'b', 'c', 'd']);
        $collection->merge(['e', 'f', 'g', 'h', 'i']);
        $collection->push(1);

        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 1], $collection->getData());
        $x = $collection->pop();
        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'], $collection->getData());
    }

    public function testToRoll()
    {
        $collection = new Collection(['a', 'b', 'c', 'd']);
        /** @var Roll $x */
        $roll = $collection->toRoll(new Collection(['1', '2', '3', '4']));

        $this->assertInstanceOf(Roll::class, $roll);

        $this->assertEquals('b', $roll->get(2));
        $this->assertEquals('d', $roll['4']);

        $roll2 = $collection->toRoll();
        $this->assertEquals('c', $roll2->get(2));
        $this->assertEquals('a', $roll2[0]);

        try {
            $attempt = $collection->toRoll(new Collection(['a', 'b']));
        } catch (\Exception $e) {
            $this->assertEquals('Indexes count mismatch', $e->getMessage());
        }
    }

    public function testIntersection()
    {
        $collection  = new Collection(['1', '2', 3, '4', '5']);
        $collection2 = new Collection(['3', '4', 5, '6', '7']);

        $result = $collection->intersection($collection2);

        $this->assertEquals(new Collection([3, '4', '5']), $result);

        $collection3 = new Collection(['stuff', 'thangs', 'coral']);
        $collection4 = new Collection(['i', "don't", 'like', 'thangs', 'much']);

        $result = $collection3->intersection($collection4);

        $this->assertEquals(new Collection(['thangs']), $result);
    }
}

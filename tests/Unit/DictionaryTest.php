<?php

namespace tests\Unit;

use PHPAlchemist\Exceptions\UnmatchedClassException;
use PHPAlchemist\Exceptions\UnmatchedVersionException;
use PHPAlchemist\Type\Dictionary;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    // Core-Files Types
    const TWINE_TYPE = '\PHPAlchemist\Type\Twine';
    const DICTIONARY_TYPE = 'PHPAlchemist\Type\Dictionary';

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
        $dictionary = new Dictionary([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('4', $dictionary->count());
    }

    public function testValidationError()
    {
        $dictionary = new Dictionary();
        try {
            $dictionary->add(0.24, 'abc');
        }catch(\Exception $e) {
            $this->assertInstanceOf("PHPAlchemist\Exceptions\InvalidKeyTypeException", $e);
            $this->assertEquals("Invalid Key type (double) for Dictionary", $e->getMessage());
        }


    }

    public function testSerializable()
    {
        $arrayTest = new Dictionary([
            'alpha'   => 'abc',
            'bravo'   => 'bcd',
            'charlie' => 'cde',
            'delta'   => 'def',
        ]);

        $serializedObject = serialize($arrayTest);

        $this->assertEquals('O:28:"PHPAlchemist\Type\Dictionary":3:{s:7:"version";i:1;s:5:"model";s:28:"PHPAlchemist\Type\Dictionary";s:4:"data";a:4:{s:5:"alpha";s:3:"abc";s:5:"bravo";s:3:"bcd";s:7:"charlie";s:3:"cde";s:5:"delta";s:3:"def";}}', $serializedObject);

    }

    public function testUnserialize()
    {
        $serializedObject = 'O:28:"PHPAlchemist\Type\Dictionary":3:{s:7:"version";i:1;s:5:"model";s:28:"PHPAlchemist\Type\Dictionary";s:4:"data";a:4:{s:5:"alpha";s:3:"abc";s:5:"bravo";s:3:"bcd";s:7:"charlie";s:3:"cde";s:5:"delta";s:3:"def";}}';
        $wrongVersion     = 'O:28:"PHPAlchemist\Type\Dictionary":3:{s:7:"version";i:1;s:5:"model";s:28:"PHPAlchemist\Type\Dictionary";s:4:"data";a:4:{s:5:"alpha";s:3:"abc";s:5:"bravo";s:3:"bcd";s:7:"charlie";s:3:"cde";s:5:"delta";s:3:"def";}}';
        $wrongClass       = 'O:28:"PHPAlchemist\Type\Dictionary":3:{s:7:"version";i:1;s:5:"model";s:28:"PHPAlchemist\Type\Dictionary";s:4:"data";a:4:{s:5:"alpha";s:3:"abc";s:5:"bravo";s:3:"bcd";s:7:"charlie";s:3:"cde";s:5:"delta";s:3:"def";}}';

        $data = unserialize($serializedObject);
        $this->assertInstanceOf('PHPAlchemist\Type\Dictionary', $data);
        $this->assertEquals('def', $data['delta']);

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

    public function testGetSet()
    {
        $testData = [
            'z' => 'abc',
            'y' => 'bcd',
            'x' => 'cde',
            'w' => 'def',
        ];

        $dictionary = new Dictionary($testData);

        $this->assertEquals(array_keys($testData), $dictionary->getKeys());
        $this->assertEquals(array_values($testData), $dictionary->getValues());

        $dictionary->set('bye', 'adios');
        $this->assertEquals('adios', $dictionary->get('bye'));

        $dictionary->offsetSet('gloves', 'car');
        $this->assertEquals('car', $dictionary->offsetGet('gloves'));

        $dictionary->offsetSet('gloves', 'stuff');
        $this->assertEquals('stuff', $dictionary->offsetGet('gloves'));

        $this->assertFalse( $dictionary->offsetGet('thisKeyDoesntExist'));
    }

    public function testNext()
    {
        $dictionary = new Dictionary([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('abc', $dictionary->current());
        $dictionary->next();
        $this->assertEquals('bcd', $dictionary->current());
    }

    public function testPrev()
    {
        $dictionary= new Dictionary([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('abc', $dictionary->current());
        $dictionary->next();
        $dictionary->next();
        $this->assertEquals('cde', $dictionary->current());
        $dictionary->prev();
        $this->assertEquals('bcd', $dictionary->current());

    }

    public function testCurrent()
    {
        $dictionary = new Dictionary([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $this->assertEquals('abc', $dictionary->current());
    }

    public function testKey()
    {
        $dictionary= new Dictionary([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $dictionary->next();
        $this->assertEquals(1, $dictionary->key());
    }

    public function testsetData()
    {
        $arrayData = [
            'abc',
            'bcd',
            'cde',
            'def',
        ];

        $dictionary= new Dictionary();
        $dictionary->setData($arrayData);

        $this->assertEquals($arrayData, $dictionary->getData());
    }

    public function testRewind()
    {
        $dictionary = new Dictionary([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $dictionary->next();
        $dictionary->next();
        $dictionary->next();
        $this->assertEquals(3, $dictionary->key());
        $dictionary->rewind();
        $this->assertEquals(0, $dictionary->key());

    }

    public function testOffsets()
    {
        $dictionary = new Dictionary([
            'abc',
            'bcd',
            'cde',
            'def',
        ]);

        $stuffAndThangs = 'stuff and thangs';

        $this->assertTrue($dictionary->offsetExists(0));
        $this->assertFalse($dictionary->offsetExists(25));
        $this->assertEquals('abc', $dictionary->offsetGet(0));
        $dictionary->offsetSet(25, $stuffAndThangs);
        $this->assertTrue($dictionary->offsetExists(25));
        $this->assertEquals($stuffAndThangs, $dictionary->offsetGet(25));
        $dictionary->offsetUnset(25);
        $this->assertFalse($dictionary->offsetExists(25));

        try {
            $dictionary['doc'] = 'McStuffAndThangs';
        } catch (\Exception $e) {

            $this->assertInstanceOf(self::INVALID_KEY_EXCEPTION, $e);
            $this->assertEquals('Invalid Key type (string) for Array', $e->getMessage());
        }
    }

    public function testInterfaces()
    {
        $dictionary = new Dictionary();
        $this->assertInstanceOf(self::ARRAYACCESS_TYPE, $dictionary);
        $this->assertInstanceOf(self::ITERATOR_TYPE, $dictionary);
        $this->assertInstanceOf(self::DICTIONARY_TYPE, $dictionary);
    }

    public function testArrayAccess()
    {
        $data          = [
            'abc',
            'bcd',
            'cde',
            'def',
        ];
        $dictionary = new Dictionary($data);

        $this->assertEquals($data[2], $dictionary[2]);
    }

    public function testTraversable()
    {
        $data          = [
            'abc',
            'bcd',
            'cde',
            'def',
        ];
        $dictionary= new Dictionary($data);

        $this->assertInstanceOf('\Traversable', $dictionary);
    }
}

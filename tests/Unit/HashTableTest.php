<?php

namespace tests\Unit;

use Exception;
use PHPAlchemist\Abstract\AbstractAssociativeArray;
use PHPAlchemist\Abstract\AbstractString;
use PHPAlchemist\Exception\HashTableFullException;
use PHPAlchemist\Exception\InvalidKeyTypeException;
use PHPAlchemist\Exception\ReadOnlyDataException;
use PHPAlchemist\Exception\UnmatchedClassException;
use PHPAlchemist\Exception\UnmatchedVersionException;
use PHPAlchemist\Type\Collection;
use PHPAlchemist\Type\HashTable;
use PHPAlchemist\Type\Twine;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HashTable::class)]
#[CoversClass(AbstractString::class)]
#[CoversClass(HashTableFullException::class)]
#[CoversClass(AbstractAssociativeArray::class)]
#[CoversClass(UnmatchedClassException::class)]
#[CoversClass(UnmatchedVersionException::class)]
class HashTableTest extends TestCase
{
    const ARRAYACCESS_TYPE = '\ArrayAccess';
    const ITERATOR_TYPE    = '\Iterator';
    const TRAVERSABLE_TYPE = '\Traversable';
    const EXCEPTION_TYPE   = '\Exception';

    public function testCount()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $this->assertEquals('4', $hashtable->count());
    }

    public function testImplode()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $this->assertInstanceOf(Twine::class, $hashtable->implode(' '));
    }

    public function testNext()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $this->assertEquals('abc', $hashtable->current());
        $hashtable->next();
        $this->assertEquals('bcd', $hashtable->current());
    }

    public function testPrev()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $this->assertEquals('abc', $hashtable->current());
        $hashtable->next();
        $hashtable->next();
        $this->assertEquals('cde', $hashtable->current());
        $hashtable->prev();
        $this->assertEquals('bcd', $hashtable->current());
    }

    public function testCurrent()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $this->assertEquals('abc', $hashtable->current());
    }

    public function testKey()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $hashtable->next();
        $this->assertEquals('b', $hashtable->key());
    }

    public function testsetData()
    {
        $arrayData = [
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ];

        $hashtable = new HashTable();
        $hashtable->setData($arrayData);

        $this->assertEquals($arrayData, $hashtable->getData());
    }

    public function testRewind()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $hashtable->next();
        $hashtable->next();
        $hashtable->next();
        $this->assertEquals('d', $hashtable->key());
        $hashtable->rewind();
        $this->assertEquals('a', $hashtable->key());
    }

    public function testOffsets()
    {
        $hashtable      = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);
        $stuffAndThangs = 'stuff and thangs';
        $this->assertTrue($hashtable->offsetExists('a'));
        $this->assertFalse($hashtable->offsetExists('z'));
        $this->assertEquals('abc', $hashtable->offsetGet('a'));
        $hashtable->offsetSet('z', $stuffAndThangs);
        $this->assertTrue($hashtable->offsetExists('z'));
        $this->assertEquals($stuffAndThangs, $hashtable->offsetGet('z'));
        $hashtable->offsetUnset('z');
        $this->assertFalse($hashtable->offsetExists('z'));

        try {
            $hashtable[529] = 'Doc McStuffAndThangs';
        } catch (Exception $e) {
            $this->assertInstanceOf(InvalidKeyTypeException::class, $e);
            $this->assertEquals('Invalid Key type (integer) for HashTable', $e->getMessage());
        }
    }

    public function testInterfaces()
    {
        $hashtable = new HashTable();
        $this->assertInstanceOf(self::ARRAYACCESS_TYPE, $hashtable);
        $this->assertInstanceOf(self::ITERATOR_TYPE, $hashtable);
        $this->assertInstanceOf(HashTable::class, $hashtable);
    }

    public function testKeyValidation()
    {
        try {
            $hashtable = new HashTable([
                0 => 'abc',
                1 => 'bcd',
                2 => 'cde',
                3 => 'def',
            ]);
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidKeyTypeException::class, $e);
        }
    }

    public function testAddGet()
    {
        $hashtable = new HashTable([
            'one'   => 'abc',
            'two'   => 'bcd',
            'three' => 'cde',
            'four'  => 'def',
        ]);

        $key       = 'five';
        $value     = 'this Should Work';
        $testValue = $hashtable->add($key, $value);

        $this->assertEquals($value, $hashtable->get($key));
        $this->assertInstanceOf(HashTable::class, $testValue);
    }

    public function testReadOnly()
    {
        $hashtable = new HashTable([
            'one'   => 'abc',
            'two'   => 'bcd',
            'three' => 'cde',
            'four'  => 'def',
        ], true);

        $key   = 'five';
        $value = "this Shouldn't Work";

        try {
            $hashtable->add($key, $value);
        } catch (\Exception $e) {
            $this->assertInstanceOf(ReadOnlyDataException::class, $e);
        }

        try {
            $hashtable['six'] = 'asdf';
        } catch (\Exception $e) {
            $this->assertInstanceOf(ReadOnlyDataException::class, $e);
        }

        $this->assertEquals('4', $hashtable->count());
    }

    public function testGetKeys()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $this->assertEquals(['a', 'b', 'c', 'd'], $hashtable->getKeys());
    }

    public function testGetValues()
    {
        $hashtable = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $this->assertEquals(['abc', 'bcd', 'cde', 'def'], $hashtable->getValues());
    }

    public function testArrayAccess()
    {
        $data      = [
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ];
        $hashTable = new HashTable($data);

        $this->assertEquals($data['b'], $hashTable['b']);
    }

    public function testFixedSize()
    {
        $data = [
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ];

        $hashTable  = new HashTable($data, false, 5);
        $hashTable2 = new HashTable($data, false, true);

        // hashtable
        $this->assertTrue($hashTable->isFixedSize());
        $this->assertEquals(5, $hashTable->count());
        $this->assertEquals(0, $hashTable[4]);

        try {
            $hashTable->add('seven', 'YOU KEELING ME');
        } catch (Exception $e) {
            $this->assertInstanceOf(HashTableFullException::class, $e);
        }

        $this->assertFalse($hashTable['seven']);

        // hashtable2
        $this->assertEquals(4, $hashTable2->count());
        $this->assertFalse($hashTable[4]);

        try {
            $hashTable->add('seven', 'YOU KEELING ME');
        } catch (Exception $e) {
            $this->assertInstanceOf(HashTableFullException::class, $e);
        }

        $this->assertFalse($hashTable['seven']);
    }

    public function testFixedSizeTooBig()
    {
        $data = [
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ];

        try {
            $hashTable = new HashTable($data, false, 2);
        } catch (\Exception $e) {
            $this->assertInstanceOf(self::EXCEPTION_TYPE, $e);
            $this->assertEquals('HashTable data size is larger than defined size', $e->getMessage());
        }
    }

    public function testLockSize()
    {
        $data = [
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ];

        $hashTable = new HashTable($data);
        $hashTable->lockSize();

        $this->assertTrue($hashTable->isFixedSize());
        $this->assertEquals(4, $hashTable->count());
        $this->assertEquals(0, $hashTable[4]);

        try {
            $hashTable->add('seven', 'YOU KEELING ME');
        } catch (Exception $e) {
            $this->assertInstanceOf(HashTableFullException::class, $e);
        }

        $this->assertFalse($hashTable['seven']);
    }

    public function testTraversable()
    {
        $data  = [
            '2a' => 'abc',
            '2b' => 'bcd',
            '2c' => 'cde',
            '2d' => 'def',
        ];
        $array = new HashTable($data);

        $this->assertInstanceOf(self::TRAVERSABLE_TYPE, $array);
    }

    public function testDelete()
    {
        $ht = new HashTable([
            'ALPHA' => 'a',
            'BRAVO' => 'b',
        ]);

        $ht->add('CHARLIE', 'c');
        $ht->add('DELTA', 'd');
        $ht->delete('DELTA');

        $this->assertFalse($ht->get('DELETA'));
    }

    public function testAdd()
    {
        $ht = new HashTable([
            'ALPHA' => 'a',
            'BRAVO' => 'b',
        ]);

        $ht->add('CHARLIE', 'c');
        $ht->add('DELTA', 'd');

        $this->assertEquals('c', $ht->get('CHARLIE'));
    }

    public function testSerializable()
    {
        $arrayTest = new HashTable([
            'a' => 'abc',
            'b' => 'bcd',
            'c' => 'cde',
            'd' => 'def',
        ]);

        $serializedObject = serialize($arrayTest);

        $this->assertEquals('O:28:"PHPAlchemist\Type\HashTable":3:{s:7:"version";i:1;s:5:"model";s:28:"PHPAlchemist\Type\HashTable";s:4:"data";a:4:{s:1:"a";s:3:"abc";s:1:"b";s:3:"bcd";s:1:"c";s:3:"cde";s:1:"d";s:3:"def";}}', $serializedObject);
    }

    public function testArrayExtract()
    {
        $testKey   = 'charlie';
        $testValue = 'c';
        $testArray = [
            'alpha'   => 'a',
            'bravo'   => 'B',
            'charlie' => 'c',
            'delta'   => 'D',
            'echo'    => 'e',
            'foxtrot' => 'F',
        ];
        $collection = new HashTable($testArray);

        $extractedValue = $collection->extract($testKey);
        $this->assertEquals($testValue, $extractedValue);
        $this->assertArrayNotHasKey($testKey, $collection);
        $this->assertNotEquals($testArray, $collection->getData());
    }

    public function testDeserializable()
    {
        $serializedObject = 'O:28:"PHPAlchemist\Type\HashTable":3:{s:7:"version";i:1;s:5:"model";s:28:"PHPAlchemist\Type\HashTable";s:4:"data";a:4:{s:1:"a";s:3:"abc";s:1:"b";s:3:"bcd";s:1:"c";s:3:"cde";s:1:"d";s:3:"def";}}';
        $wrongVersion     = 'O:28:"PHPAlchemist\Type\HashTable":3:{s:7:"version";i:8;s:5:"model";s:28:"PHPAlchemist\Type\HashTable";s:4:"data";a:4:{s:1:"a";s:3:"abc";s:1:"b";s:3:"bcd";s:1:"c";s:3:"cde";s:1:"d";s:3:"def";}}';
        $wrongClass       = 'O:28:"PHPAlchemist\Type\HashTable":3:{s:7:"version";i:1;s:5:"model";s:29:"PHPAlchemist\Type\Collection";s:4:"data";a:4:{s:1:"a";s:3:"abc";s:1:"b";s:3:"bcd";s:1:"c";s:3:"cde";s:1:"d";s:3:"def";}}';

        $data = unserialize($serializedObject);
        $this->assertInstanceOf('PHPAlchemist\Type\HashTable', $data);
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
}

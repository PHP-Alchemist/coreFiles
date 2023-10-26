<?php

namespace tests\Unit;

use PHPAlchemist\Traits\MagicGetSetTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class MockMagicGetSetTraitClass
 * @package tests\Unit
 * @method setJohn
 * @method getJohn
 * @method setCena
 * @method getCena
 * @method setYouCantSeeMe
 * @method getYouCantSeeMe
 */
class MockMagicGetSetTraitClass
{
    use MagicGetSetTrait;

    public $john;

    protected $cena;

    private $youCantSeeMe;

}

/**
 * @method setActive(bool $active)
 * @method isActive()
 * @method setName(string $name)
 * @method getName()
 * @method setData(array $data)
 * @method getData()
 */
class MagicGSExample
{
    use MagicGetSetTrait;

    public bool $active;

    protected string $name;

    private array $data;
}

class MagicGetSetTraitTest extends TestCase
{
    public function testGetSet()
    {
        $mock         = new MockMagicGetSetTraitClass();
        $x            = 'asdf';
        $y            = 'xyzzy';
        $youCantSeeMe = '1qazxsw2';

        $mock->setJohn($x);
        $this->assertEquals($x, $mock->getJohn());

        $mock->setCena($y);
        $this->assertEquals($y, $mock->getCena());

        $mock->setYouCantSeeMe($youCantSeeMe);
        $this->assertEquals($youCantSeeMe, $mock->getYouCantSeeMe());
    }

    public function testSetExceptions()
    {
        $mock = new MockMagicGetSetTraitClass();

        $value = 'asdf';
        try {
            $mock->setIrish($value);
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals('Variable (irish) Not Found', $e->getMessage());
        }

    }

    public function testGetExceptions()
    {
        $mock = new MockMagicGetSetTraitClass();

        try {
            $mock->getIrish();
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals('Variable (irish) Not Found', $e->getMessage());
        }

        try {
            $mock->irish();
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals('No Method (irish) exists on tests\Unit\MockMagicGetSetTraitClass', $e->getMessage());
        }


    }

    public function testMethodNotFoundExceptions()
    {
        $mock = new MockMagicGetSetTraitClass();

        try {
            $mock->save();
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals("No Method (save) exists on tests\Unit\MockMagicGetSetTraitClass", $e->getMessage());
        }

    }

    public function testIsAndCatchAll()
    {

        $example = new MagicGSExample();
        $example->setActive(false);
        $example->setName('Test');
        $example->setData(['abc','def','ghi']);

        $this->assertEquals('Test', $example->getName());
        $this->assertFalse($example->isActive());
        $this->assertIsArray($example->getData());

        $example->setActive(true);
        $this->assertTrue($example->isActive());

        try{
            $example->isName();
        } catch (\Exception $e) {
            $this->assertEquals('Cannot call is() on non-boolean variable (name).', $e->getMessage());
        }

        try{
            $example->asIf();
        } catch (\Exception $e) {
            $this->assertEquals('No Method (asIf) exists on tests\Unit\MagicGSExample', $e->getMessage());
        }

    }
//
}
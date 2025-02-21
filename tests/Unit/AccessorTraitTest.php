<?php

namespace tests\Unit;

use PHPAlchemist\Traits\AccessorTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class MockAccessorTraitClass
{
    use AccessorTrait;

    private $x;

    private $youCannotSeeMe;
}

/**
 * Class MockSecondAccessorClass.
 *
 * @method setJohn
 * @method getJohn
 * @method setCena
 * @method getCena
 * @method setYouCantSeeMe
 * @method getYouCantSeeMe
 */
class MockSecondAccessorClass
{
    use AccessorTrait;

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
class MagicAccessorExample
{
    use AccessorTrait;

    public bool $active;

    protected string $name;

    private array $data;
}

#[CoversClass(AccessorTrait::class)]
class AccessorTraitTest extends TestCase
{
    public function testGetSetOne()
    {
        $mock           = new MockAccessorTraitClass();
        $x              = 'asdf';
        $youCannotSeeMe = '1qazxsw2';
        $mock->set('x', $x);
        $this->assertEquals($x, $mock->get('x'));

        $mock->set('youCannotSeeMe', $youCannotSeeMe);
        $this->assertEquals($youCannotSeeMe, $mock->get('youCannotSeeMe'));
    }

    public function testSetExceptions()
    {
        $mock  = new MockAccessorTraitClass();
        $value = 'asdf';

        try {
            $mock->set('irish', $value);
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals('Variable (irish) Not Found', $e->getMessage());
        }
    }

    public function testGetExceptions()
    {
        $mock = new MockAccessorTraitClass();

        try {
            $mock->get('irish');
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals('Variable (irish) Not Found', $e->getMessage());
        }
    }

    public function testGetSetTwo()
    {
        $mock         = new MockSecondAccessorClass();
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

    public function testSetExceptionsOne()
    {
        $mock = new MockSecondAccessorClass();

        $value = 'asdf';

        try {
            $mock->setIrish($value);
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals('Variable (irish) Not Found', $e->getMessage());
        }
    }

    public function testGetExceptionsTwo()
    {
        $mock = new MockSecondAccessorClass();

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
            $this->assertEquals('No Method (irish) exists on tests\Unit\MockSecondAccessorClass', $e->getMessage());
        }
    }

    public function testMethodNotFoundExceptions()
    {
        $mock = new MockSecondAccessorClass();

        try {
            $mock->save();
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals("No Method (save) exists on tests\Unit\MockSecondAccessorClass", $e->getMessage());
        }
    }

    #[CoversMethod([AccessorTrait::class, 'getMethodVerb'])]
    public function testIsAndCatchAll()
    {
        $example = new MagicAccessorExample();
        $example->setActive(false);
        $example->setName('Test');
        $example->setData(['abc', 'def', 'ghi']);

        $this->assertEquals('Test', $example->getName());
        $this->assertFalse($example->isActive());
        $this->assertIsArray($example->getData());

        $example->setActive(true);
        $this->assertTrue($example->isActive());

        try {
            $example->isName();
        } catch (\Exception $e) {
            $this->assertEquals('Cannot call is() on non-boolean variable (name).', $e->getMessage());
        }

        try {
            $example->asIf();
        } catch (\Exception $e) {
            $this->assertEquals('No Method (asIf) exists on tests\Unit\MagicAccessorExample', $e->getMessage());
        }
    }
}

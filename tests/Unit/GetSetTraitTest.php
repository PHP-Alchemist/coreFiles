<?php

namespace tests\Unit;

use PHPAlchemist\Traits\GetSetTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class MockGetSetTraitClass
{
    use GetSetTrait;

    private $x;

    private $youCannotSeeMe;

}

#[CoversClass(GetSetTrait::class)]
class GetSetTraitTest extends TestCase
{
    public function testGetSet()
    {
        $mock           = new MockGetSetTraitClass();
        $x              = 'asdf';
        $youCannotSeeMe = '1qazxsw2';
        $mock->set('x', $x);
        $this->assertEquals($x, $mock->get('x'));

        $mock->set('youCannotSeeMe', $youCannotSeeMe);
        $this->assertEquals($youCannotSeeMe, $mock->get('youCannotSeeMe'));
    }

    public function testSetExceptions()
    {
        $mock  = new MockGetSetTraitClass();
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
        $mock = new MockGetSetTraitClass();

        try {
            $mock->get('irish');
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Exception', $e);
            $this->assertEquals('Variable (irish) Not Found', $e->getMessage());
        }

    }
}
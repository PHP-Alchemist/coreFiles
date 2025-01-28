<?php

namespace ValueObjects\Unit;

use PHPAlchemist\ValueObjects\Abstracts\AbstractNumber;
use PHPAlchemist\ValueObjects\Abstracts\AbstractString;
use PHPAlchemist\ValueObjects\Model\Number;
use PHPAlchemist\ValueObjects\Model\USState;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PHPAlchemist\ValueObjects\Model\Email;


#[CoversClass(USState::class)]
#[CoversClass(AbstractString::class)]
#[CoversClass(AbstractNumber::class)]
class USStateTest extends TestCase
{

    public function testInvalidState() : void
    {
        $this->expectExceptionMessage('Invalid US State value.');
        $invalidStatelValue = 'ZA';
        $stateObject        = new USState($invalidStatelValue);
    }


    public function testValidStateCode() : void
    {

        $validStateValue = 'Nebraska';
        $validStateCode  = 'NE';
        $emailObject     = new USState($validStateCode);

        $this->assertEquals($emailObject->getValue(), $validStateValue);
        $this->assertEquals($emailObject->getCode(), $validStateCode);
    }

    public function testEquals() : void
    {
        $validStateValue  = 'Utah';
        $emailObject      = new USState($validStateValue);
        $comparitiveState = new USState($validStateValue);

        $this->assertTrue($emailObject->equals($comparitiveState));
    }

    public function testLength() : void
    {
        $validStateCode  = 'LA';
        $validEmailValue = 'Louisiana';
        $expectedLength  = 9;
        $state           = new USState($validStateCode);

        $this->assertInstanceOf(Number::class, $state->length());
        $this->assertequals($expectedLength, ($state->length())->getValue());
    }

}

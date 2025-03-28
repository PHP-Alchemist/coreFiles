<?php

namespace ValueObject\Unit;

use PHPAlchemist\ValueObject\Abstract\AbstractNumber;
use PHPAlchemist\ValueObject\Abstract\AbstractString;
use PHPAlchemist\ValueObject\Model\Number;
use PHPAlchemist\ValueObject\Model\USState;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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
        $this->assertequals($expectedLength, $state->length()->getValue());
    }
}

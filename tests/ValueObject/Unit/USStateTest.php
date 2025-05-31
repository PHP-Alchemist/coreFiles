<?php

namespace ValueObject\Unit;

use PHPAlchemist\ValueObject\Abstract\AbstractVONumber;
use PHPAlchemist\ValueObject\Abstract\AbstractVOString;
use PHPAlchemist\ValueObject\Model\USState;
use PHPAlchemist\ValueObject\Model\VONumber;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(USState::class)]
#[CoversClass(AbstractVOString::class)]
#[CoversClass(AbstractVONumber::class)]
class USStateTest extends TestCase
{
    public function testInvalidState() : void
    {
        $this->expectExceptionMessage('Invalid US State value.');
        $invalidStatelValue = 'ZA';
        new USState($invalidStatelValue);
    }

    public function testValidStateCode() : void
    {
        $validStateValue = 'Nebraska';
        $validStateCode  = 'NE';
        $emailObject     = new USState($validStateCode);

        $this->assertEquals($validStateValue, $emailObject->getValue());
        $this->assertEquals($validStateCode, $emailObject->getCode());
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
        $validStateCode = 'LA';
        $expectedLength = 9;
        $state          = new USState($validStateCode);

        $this->assertInstanceOf(VONumber::class, $state->length());
        $this->assertequals($expectedLength, $state->length()->getValue());
    }
}

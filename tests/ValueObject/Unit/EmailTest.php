<?php

namespace ValueObject\Unit;

use PHPAlchemist\ValueObject\Abstract\AbstractNumber;
use PHPAlchemist\ValueObject\Abstract\AbstractString;
use PHPAlchemist\ValueObject\Model\Email;
use PHPAlchemist\ValueObject\Model\Number;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Email::class)]
#[CoversClass(AbstractString::class)]
#[CoversClass(AbstractNumber::class)]
class EmailTest extends TestCase
{
    public function testInvalidEmail() : void
    {
        $this->expectExceptionMessage('Invalid email address.');
        $invalidEmailValue = 'stuff@things';
        $emailObject       = new Email($invalidEmailValue);
    }

    public function testValidEmail() : void
    {
        $validEmailValue = 'stuff@things.net';
        $emailObject     = new Email($validEmailValue);

        $this->assertEquals($emailObject->getValue(), $validEmailValue);
    }

    public function testEquals() : void
    {
        $validEmailValue  = 'stuff@things.net';
        $emailObject      = new Email($validEmailValue);
        $comparitiveEmail = new Email($validEmailValue);

        $this->assertTrue($emailObject->equals($comparitiveEmail));
    }

    public function testLength() : void
    {
        $validEmailValue  = 'stuff@things.net';
        $expectedLength   = 16;
        $emailObject      = new Email($validEmailValue);

        $this->assertInstanceOf(Number::class, $emailObject->length());
        $this->assertequals($expectedLength, $emailObject->length()->getValue());
    }
}

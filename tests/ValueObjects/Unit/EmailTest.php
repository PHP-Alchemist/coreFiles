<?php

namespace ValueObjects\Unit;

use PHPAlchemist\ValueObjects\Abstracts\AbstractNumber;
use PHPAlchemist\ValueObjects\Abstracts\AbstractString;
use PHPAlchemist\ValueObjects\Model\Email;
use PHPAlchemist\ValueObjects\Model\Number;
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
        $this->assertequals($expectedLength, ($emailObject->length())->getValue());
    }

}

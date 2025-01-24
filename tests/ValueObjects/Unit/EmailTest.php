<?php

namespace ValueObjects\Unit;

use PharIo\Manifest\InvalidEmailException;
use PHPUnit\Framework\TestCase;
use PHPAlchemist\ValueObjects\Model\Email;

class EmailTest extends TestCase
{

    public function testInvalidEmail() : void
    {
        $invalidEmailValue = 'stuff@things';
        try {
            $emailObject = new Email($invalidEmailValue);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Invalid email address.');
        }
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
}

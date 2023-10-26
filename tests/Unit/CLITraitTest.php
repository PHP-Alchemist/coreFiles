<?php

namespace tests\Unit;

use PHPAlchemist\Traits\CLITrait;
use PHPUnit\Framework\TestCase;

class MockCLITraitClass
{
    use CLITrait;
}

class CLITraitTest extends TestCase
{
    public function testIsCLI()
    {
        $mock = new MockCLITraitClass();
        $this->assertTrue($mock->isCli());
    }
}
<?php

namespace tests\Unit;

use PHPAlchemist\Core\Traits\CLITrait;
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
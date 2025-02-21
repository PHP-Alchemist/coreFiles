<?php

namespace tests\Unit;

use PHPAlchemist\Traits\CLITrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class MockCLITraitClass
{
    use CLITrait;
}

#[CoversClass(CLITrait::class)]
class CLITraitTest extends TestCase
{
    public function testIsCLI()
    {
        $mock = new MockCLITraitClass();
        $this->assertTrue($mock->isCli());
    }
}

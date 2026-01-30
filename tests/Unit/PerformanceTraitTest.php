<?php

namespace tests\Unit;

use PHPAlchemist\Trait\PerformanceTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class MockPerfTraitClass
{
    use PerformanceTrait;

    public function generateRandomNumbers()
    {
        rand(1000, 9999999);
    }
}

#[CoversClass(PerformanceTrait::class)]
class PerformanceTraitTest extends TestCase
{
    public function testGetPerformance()
    {
        $mock = new MockPerfTraitClass();

        $perfData = $mock->getPerformance();

        $this->assertStringContainsString('bytes', $perfData);
    }

    public function testGetLargerPerformance()
    {
        $mock = new MockPerfTraitClass();

        for ($i = 0; $i > 1001; $i++) {
            $mock->generateRandomNumbers();
        }

        $perfData = $mock->getPerformance();

        $this->assertStringContainsString('mega', $perfData);
    }
}

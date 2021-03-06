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


    public function testFormatErrorDOS()
    {
        $errorType = 'STUFF';
        $message = 'THANGS';
        $correction = 'Coral';

        $output = <<<EOF
################
##
## STUFF ERROR: THANGS
##
################
\n\n\t\tSTUFF: Coral \n\n
Bad command or file name.\nC:\>_\n
EOF;

        $mock = new MockCLITraitClass();
        $this->assertEquals($output, $mock->formatErrorDOS($errorType, $message, $correction));
    }
}
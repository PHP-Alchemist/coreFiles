<?php

namespace tests\Unit;

use PHPAlchemist\Utilities\CSVUtil;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CSVUtil::class)]
class CSVUtilTest extends TestCase
{

    public function testSputCSV()
    {
        $rows = [
            ['firstName', 'lastName', 'jerseyNumber'],
            ['Sidney', 'Crosby', '87'],
            ['Evgeni', 'Malkin', '71'],
            ['Bill', 'Guerin', '13'],
            ['Matt', 'Cullen', '7'],
            ['Mario', 'Lemieux', '66'],
            ['Jaromir', 'Jagr', '68'],
        ];

        $csvString = '';

        foreach ($rows as $row) {
            $csvString .= CSVUtil::sputcsv($row, ',');
        }

        $output = "firstName,lastName,jerseyNumber" . PHP_EOL .
"Sidney,Crosby,87" . PHP_EOL .
"Evgeni,Malkin,71" . PHP_EOL .
"Bill,Guerin,13" . PHP_EOL .
"Matt,Cullen,7" . PHP_EOL .
"Mario,Lemieux,66" . PHP_EOL .
"Jaromir,Jagr,68" . PHP_EOL ;
        $this->assertEquals($output, $csvString);

    }

    public function testSputCSVEOL()
    {
        $rows = [
            ['firstName', 'lastName', 'jerseyNumber'],
            ['Mario', 'Lemieux', '66'],
            ['Sidney', 'Crosby', '87'],
            ['Bill', 'Guerin', '13'],
        ];

        $csvString = '';

        foreach ($rows as $row) {
            $csvString .= CSVUtil::sputcsv($row, ',', '"', "<BR/>");
        }

        $output = "firstName,lastName,jerseyNumber<BR/>Mario,Lemieux,66<BR/>Sidney,Crosby,87<BR/>Bill,Guerin,13<BR/>";
        $this->assertEquals($output, $csvString);
    }
}

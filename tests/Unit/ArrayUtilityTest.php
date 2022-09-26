<?php

namespace tests\Unit;

use PHPAlchemist\Traits\ArrayTrait;
use PHPAlchemist\Utilities\ArrayUtility;
use PHPUnit\Framework\TestCase;




class ArrayUtilityTest extends TestCase
{

    public function testArraySumKey()
    {
        $sumArray  = ['a' => '1', 'b' => '2', 'z' => '26'];
        $sum2Array = [
            [
                'a' => 14,
                'b' => 42,
            ],
            [
                'a' => 4,
                'b' => 2,
            ],
        ];
        $sum       = ArrayUtility::sumByKey($sumArray);
        $this->assertEquals('29', $sum);

        $sum2 = ArrayUtility::sumByKey($sum2Array, 'b');
        $this->assertEquals('44', $sum2);

        $sum3 = ArrayUtility::sumByKey(['a'], 'b');
        $this->assertEquals('0', $sum3);

        $sum4 = ArrayUtility::sumByKey([], 'b');
        $this->assertEquals('0', $sum4);
    }

    public function testIsMulti()
    {
        $sumArray  = ['a' => '1', 'b' => '2', 'z' => '26'];
        $testArray = [
            ['asdf', 'bdef'],
            ['jkl;'],
            ['1qaz', 'xsw2'],
        ];

        $this->assertTrue(ArrayUtility::isMulti($testArray));
        $this->assertFalse(ArrayUtility::isMulti($sumArray));
    }
}
<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\Twine;

$stringTest = new Twine('Hello Coral');
/** @var Collection $arrayTest */
$arrayTest = $stringTest->explode(' ');
/** @var Collection $arrayTest2 */
$arrayTest2 = $stringTest->splitOn(' ');

echo $stringTest.PHP_EOL;
echo $arrayTest->first().PHP_EOL;

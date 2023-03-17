<?php

require_once('../../vendor/autoload.php');

use PHPAlchemist\Type\Collection;
use PHPAlchemist\Type\Twine;

$stringTest = new Twine('Hello Coral');
/** @var Collection $arrayTest */
$arrayTest = $stringTest->explode(' ');
/** @var Collection $arrayTest2 */
$arrayTest2 = $stringTest->split(' ');

echo $stringTest . "\n";
echo $arrayTest->first() . "\n";

<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use PHPAlchemist\Types\Number;
use PHPAlchemist\Types\Roll;

/** @var Number $numberTest */
$numberTest = new Number(24601);
echo $numberTest->get() . PHP_EOL;
$numberTest->add(14);
echo $numberTest . PHP_EOL;

$numberTest->subtract(18);
echo $numberTest . PHP_EOL;

$roll = new Roll();
foreach(range(1, 12) as $value) {
    $tmpNumber = new Number($value);
    $roll->add($tmpNumber);
}

/** @var Number $value */
foreach($roll->parseData() as $value) {
     echo $value->get() . ": (" . (($value->modulus(2) == 0) ? "even" : "odd") . ")" . PHP_EOL;
}


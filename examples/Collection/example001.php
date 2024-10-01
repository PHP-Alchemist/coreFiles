<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use PHPAlchemist\Types\Collection;
use PHPAlchemist\Types\Twine;

$collectionTest = new Collection(['Stay', 'in', 'the', 'house', ',', 'Coral']);
/** @var Twine $stringTest */
$stringTest = $collectionTest->implode( ' ');
$stringTest->replace(' ,', ',');

 echo $stringTest . PHP_EOL;

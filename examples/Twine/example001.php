<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use PHPAlchemist\Types\Twine;

$twine          = new Twine('prisoner24601');
$value          = $twine->substring(0, 8);
$prisonerNumber = $twine->substring(8);

echo $value. PHP_EOL;
echo $prisonerNumber . PHP_EOL;


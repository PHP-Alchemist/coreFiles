<?php
require_once('../../vendor/autoload.php');

use PHPAlchemist\Type\Twine;

$twine          = new Twine('prisoner24601');
$value          = $twine->substring(0, 8);
$prisonerNumber = $twine->substring(8);

echo $value. "\n";
echo $prisonerNumber . "\n";


<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PHPAlchemist\Types\Dictionary;

$dictionary = new Dictionary([
    'alpha'    => 'a',
    'beta'     => 'b',
    'charlie'  => 'c',
    'delta'    => 'd',
    'echo'     => 'e',
    'foxtrot'  => 'f',
    'golf'     => 'g',
    'hotel'    => 'h',
    'india'    => 'i',
    'juliet'   => 'j',
    'kilo'     => 'k',
    'lima'     => 'l',
    'mike'     => 'm',
    'november' => 'n',
    'oscar'    => 'o',
    'papa'     => 'p',
    'quebec'   => 'q',
    'romeo'    => 'r',
]);

$dictionary->add('sierra', 's');
$dictionary->add('tango', 't');
$dictionary->add('uniform', 'u');
$dictionary->add('victor', 'v');
$dictionary->add('whiskey', 'w');
$dictionary->add('xray', 'x');
$dictionary->add('yankee', 'y');
$dictionary->add('zulu', 'z');

echo $dictionary->get('golf');
echo $dictionary->get('echo');
echo $dictionary->get('tango').' ';
echo $dictionary->get('golf');
echo $dictionary->get('oscar');
echo $dictionary->get('oscar');
echo $dictionary->get('delta');
echo PHP_EOL;

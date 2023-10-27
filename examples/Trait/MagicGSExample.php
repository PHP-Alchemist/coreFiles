<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use PHPAlchemist\Traits\MagicGetSetTrait;

/**
 * @method setActive(bool $active)
 * @method isActive()
 * @method setName(string $name)
 * @method getName()
 * @method setData(array $data)
 * @method getData()
 */
class MagicGSExample
{
    use MagicGetSetTrait;

    public bool $active;

    protected string $name;

    private array $data;
}


$example = new MagicGSExample();
$example->setActive(false);
$example->setName('Test');
$example->setData(['abc','def','ghi']);

echo $example->getName() . PHP_EOL;
var_dump($example->isActive());
var_dump($example->getData());

$example->setActive(true);
var_dump($example->isActive());
try{

    $example->asIf();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

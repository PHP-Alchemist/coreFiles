<?php

namespace Unit;

use PHPAlchemist\Core\Type\Base\AbstractKeyValuePair;
use PHPUnit\Framework\TestCase;

class MockKeyValuePair extends AbstractKeyValuePair
{

}

class KeyValuePairTest extends TestCase
{

    public function testKVPClass()
    {

        $kvp = new MockKeyValuePair('asdf', "jkl;");

        $this->assertEquals('jkl;', $kvp->getKey('asdf'));
    }

}

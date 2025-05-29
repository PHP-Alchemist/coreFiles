<?php

namespace Unit;

use PHPAlchemist\Services\JsonMapper;
use PHPAlchemist\Traits\JsonHydratorTrait;
use PHPUnit\Framework\TestCase;

class MockJsonBadHydratorClass
{
    use JsonHydratorTrait;

    public ?string $foo;
    protected ?string $bar;
    protected ?string $fiz;
    private ?string $buzz;

    public function getFoo() : ?string
    {
        return $this->foo;
    }

    public function setBar($bar) : void
    {
        $this->bar = $bar;
    }

    public function getBar() : ?string
    {
        return $this->bar;
    }

    public function getFiz() : ?string
    {
        return $this->fiz;
    }

    public function setBuzz($buzz) : void
    {
        $this->buzz = $buzz;
    }

    public function getBuzz() : ?string
    {
        return $this->buzz;
    }
}

class MockJsonHydratorClass
{
    use JsonHydratorTrait;

    public ?string $foo;
    protected ?string $bar;
    protected ?string $fiz;
    private ?string $buzz;

    public function getFoo() : ?string
    {
        return $this->foo;
    }

    public function setBar($bar) : void
    {
        $this->bar = $bar;
    }

    public function getBar() : ?string
    {
        return $this->bar;
    }

    public function setFiz($fiz) : void
    {
        $this->fiz = $fiz;
    }

    public function getFiz() : ?string
    {
        return $this->fiz;
    }

    public function setBuzz($buzz) : void
    {
        $this->buzz = $buzz;
    }

    public function getBuzz() : ?string
    {
        return $this->buzz;
    }
}

class MockBoringClass
{
    public ?string $foo;
    protected ?string $bar;
    protected ?string $fiz;
    private ?string $buzz;

    public function getFoo() : ?string
    {
        return $this->foo;
    }

    public function setBar($bar) : void
    {
        $this->bar = $bar;
    }

    public function getBar() : ?string
    {
        return $this->bar;
    }

    public function setFiz($fiz) : void
    {
        $this->fiz = $fiz;
    }

    public function getFiz() : ?string
    {
        return $this->fiz;
    }

    public function setBuzz($buzz) : void
    {
        $this->buzz = $buzz;
    }

    public function getBuzz() : ?string
    {
        return $this->buzz;
    }
}

class JsonMapperTest extends TestCase
{

    public function testJsonMapperWithHydrator()
    {
        $json       = '{"foo":"alpha","bar":"beta","fiz":"charlie","buzz":"delta"}';
        $jsonMapper = new JsonMapper();
        $obj        = $jsonMapper->map($json, MockJsonHydratorClass::class);
        $this->assertEquals('alpha', $obj->foo);
        $this->assertEquals('beta', $obj->getBar());
        $this->assertEquals('charlie', $obj->getFiz());
        $this->assertEquals('delta', $obj->getBuzz());
    }

    public function testJsonMapperWithBadHydrator()
    {
        $this->expectException(\Error::class);
        $json       = '{"foo":"alpha","bar":"beta","fiz":"charlie","buzz":"delta"}';
        $jsonMapper = new JsonMapper();
        $obj        = $jsonMapper->map($json, MockJsonBadHydratorClass::class);;
    }

    public function testJsonMapperWithBoringClass()
    {
        $json       = '{"foo":"alpha","bar":"beta","fiz":"charlie","buzz":"delta"}';
        $jsonMapper = new JsonMapper();
        $obj        = $jsonMapper->map($json, MockBoringClass::class);
        $this->assertEquals('alpha', $obj->getFoo());
        $this->assertEquals('beta', $obj->getBar());
        $this->assertEquals('charlie', $obj->getFiz());
        $this->assertEquals('delta', $obj->getBuzz());
    }

}

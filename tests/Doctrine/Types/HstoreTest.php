<?php

namespace AscensoDigital\ComponentBundle\Tests\Doctrine\Types;

use AscensoDigital\ComponentBundle\Doctrine\Types\Hstore;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\TestCase;

class HstoreTest extends TestCase
{
    private $platform;

    protected function setUp()
    {
        $this->platform = $this->createMock(AbstractPlatform::class);
    }

    public function testConvertToPHPValue()
    {
        $type = new Hstore();
        $value = '"foo"=>"bar", "num"=>"123", "bool"=>"true"';
        $expected = ['foo' => 'bar', 'num' => 123, 'bool' => true];
        $this->assertEquals($expected, $type->convertToPHPValue($value, $this->platform));
    }

    public function testConvertToDatabaseValue()
    {
        $type = new Hstore();
        $value = ['foo' => 'bar', 'num' => 123, 'bool' => true];
        $result = $type->convertToDatabaseValue($value, $this->platform);
        $this->assertStringContainsString('foo => bar', $result);
        $this->assertStringContainsString('num => 123', $result);
        $this->assertStringContainsString('bool => 1', $result); // true → 1
    }

    public function testConvertToDatabaseValueWithStdClass()
    {
        $type = new Hstore();
        $obj = new \stdClass();
        $obj->foo = 'bar';
        $obj->num = 5;
        $result = $type->convertToDatabaseValue($obj, $this->platform);
        $this->assertStringContainsString('foo => bar', $result);
        $this->assertStringContainsString('num => 5', $result);
    }

    public function testConvertToDatabaseValueThrowsOnInvalidType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $type = new Hstore();
        $type->convertToDatabaseValue('not an array', $this->platform);
    }

    public function testConvertToDatabaseValueThrowsOnNestedArray()
    {
        $this->expectException(\InvalidArgumentException::class);
        $type = new Hstore();
        $type->convertToDatabaseValue(['invalid' => ['nested' => 'value']], $this->platform);
    }

    public function testEmptyValues()
    {
        $type = new Hstore();
        $this->assertEquals([], $type->convertToPHPValue('', $this->platform));
        $this->assertEquals('', $type->convertToDatabaseValue([], $this->platform));
    }

    public function testGetSqlDeclarationReturnsHstore()
    {
        $type = new Hstore();
        $this->assertEquals('hstore', $type->getSqlDeclaration([], $this->platform));
    }

    public function testGetName()
    {
        $type = new Hstore();
        $this->assertEquals('hstore', $type->getName());
    }

}

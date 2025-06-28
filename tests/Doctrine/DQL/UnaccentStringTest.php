<?php

namespace AscensoDigital\ComponentBundle\Tests\Doctrine\DQL;

use AscensoDigital\ComponentBundle\Doctrine\DQL\UnaccentString;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use PHPUnit\Framework\TestCase;

class UnaccentStringTest extends TestCase
{
    public function testGetSqlGeneratesExpectedFunction()
    {
        $node = new UnaccentString('unaccent');
        $parser = $this->createMock(Parser::class);
        $sqlWalker = $this->createMock(SqlWalker::class);

        $stringExpr = $this->getMockBuilder(\stdClass::class)->setMethods(['dispatch'])->getMock();
        $stringExpr->expects($this->once())->method('dispatch')->with($sqlWalker)->willReturn("name");

        $refClass = new \ReflectionClass($node);
        $stringProp = $refClass->getProperty('string');
        $stringProp->setAccessible(true);
        $stringProp->setValue($node, $stringExpr);

        $sql = $node->getSql($sqlWalker);
        $this->assertEquals("UNACCENT(name)", $sql);
    }

    public function testParse()
    {
        $node = new UnaccentString('unaccent');
        $parser = $this->createMock(Parser::class);

        $stringExpr = $this->getMockBuilder(\stdClass::class)->setMethods(['dispatch'])->getMock();

        // Permitimos cualquier cantidad de llamados a match
        $parser->method('match')->with($this->anything());

        // Simulamos la lectura de la expresión
        $parser->method('StringPrimary')->willReturn($stringExpr);

        $node->parse($parser);

        // Validamos que la propiedad interna fue correctamente asignada
        $ref = new \ReflectionClass($node);
        $stringProp = $ref->getProperty('string');
        $stringProp->setAccessible(true);

        $this->assertSame($stringExpr, $stringProp->getValue($node));
    }

}

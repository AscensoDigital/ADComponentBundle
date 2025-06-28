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
}

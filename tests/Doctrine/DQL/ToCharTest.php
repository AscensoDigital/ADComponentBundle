<?php

namespace AscensoDigital\ComponentBundle\Tests\Doctrine\DQL;

use AscensoDigital\ComponentBundle\Doctrine\DQL\ToChar;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use PHPUnit\Framework\TestCase;

class ToCharTest extends TestCase
{
    public function testGetSqlGeneratesExpectedFunction()
    {
        $node = new ToChar('to_char');
        $parser = $this->createMock(Parser::class);
        $sqlWalker = $this->createMock(SqlWalker::class);

        $timestampExpr = $this->getMockBuilder(\stdClass::class)->setMethods(['dispatch'])->getMock();
        $timestampExpr->expects($this->once())->method('dispatch')->with($sqlWalker)->willReturn('created_at');

        $patternExpr = $this->getMockBuilder(\stdClass::class)->setMethods(['dispatch'])->getMock();
        $patternExpr->expects($this->once())->method('dispatch')->with($sqlWalker)->willReturn("'YYYY-MM-DD'");

        // Inject dummy expressions directly for test
        $refClass = new \ReflectionClass($node);
        $timestampProp = $refClass->getProperty('timestamp');
        $timestampProp->setAccessible(true);
        $timestampProp->setValue($node, $timestampExpr);

        $patternProp = $refClass->getProperty('pattern');
        $patternProp->setAccessible(true);
        $patternProp->setValue($node, $patternExpr);

        $sql = $node->getSql($sqlWalker);
        $this->assertEquals("to_char(created_at, 'YYYY-MM-DD')", $sql);
    }
}

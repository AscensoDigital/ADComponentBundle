<?php

namespace ADComponentBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use AscensoDigital\ComponentBundle\Util\StrUtil;

class StrUtilTest extends TestCase
{
    // 🧪 firstWord()
    public function testFirstWordConTextoCompleto()
    {
        $this->assertEquals('Hola', StrUtil::firstWord('Hola mundo bonito'));
    }

    public function testFirstWordConUnaPalabra()
    {
        $this->assertEquals('Único', StrUtil::firstWord('Único'));
    }

    public function testFirstWordConCadenaVacia()
    {
        $this->assertEquals('', StrUtil::firstWord(''));
    }

    // 🧪 sanearString()
    public function testSanearStringReemplazaAcentos()
    {
        $input = 'áéíóú ñ ç ÁÉÍÓÚ Ñ Ç';
        $expected = 'aeiou n c AEIOU N C';
        $this->assertEquals($expected, StrUtil::sanearString($input));
    }

    public function testSanearStringEliminaCaracteresEspeciales()
    {
        $input = 'Texto!@# con%$ signos*& y (paréntesis)';
        $this->assertEquals('Texto con signos y parentesis', StrUtil::sanearString($input));
    }

    public function testSanearStringSanearGuionesSiSeIndica()
    {
        $input = 'palabra-larga_con_guion';
        $this->assertEquals('palabralargaconguion', StrUtil::sanearString($input));
    }

    public function testSanearStringPermiteGuionesSiSeIndica()
    {
        $input = 'palabra-larga_con_guion';
        $this->assertEquals('palabra-larga_con_guion', StrUtil::sanearString($input, false));
    }

    // 🧪 strtolower()
    public function testStrToLowerConvierteCaracteresAcentuados()
    {
        $input = 'ÁÉÍÓÚ Ñ';
        $expected = 'áéíóú ñ';
        $this->assertEquals($expected, StrUtil::strtolower($input));
    }

    public function testStrToLowerConTextoNormal()
    {
        $this->assertEquals('texto simple', StrUtil::strtolower('Texto Simple'));
    }
}


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

    // 🧪 strtoupper()
    public function testStrToUpperConvierteCaracteresAcentuados()
    {
        $input = 'áéíóú ñ';
        $expected = 'ÁÉÍÓÚ Ñ';
        $this->assertEquals($expected, StrUtil::strtoupper($input));
    }

    public function testStrToUpperConTextoNormal()
    {
        $this->assertEquals('TEXTO SIMPLE', StrUtil::strtoupper('Texto Simple'));
    }

// 🧪 ucwords()
    public function testUcwordsCapitalizaCorrectamenteConAcentos()
    {
        $input = 'árbol canción útil niño';
        $expected = 'Árbol Canción Útil Niño';
        $this->assertEquals($expected, StrUtil::ucwords($input));
    }

    public function testUcwordsConMayusculasIniciales()
    {
        $input = 'Hola Mundo';
        $this->assertEquals('Hola Mundo', StrUtil::ucwords($input));
    }

// 🧪 formatReport()
    public function testFormatReportReemplazaCaracteres()
    {
        $input = 'Este informe tiene &quot;comillas&quot; y À';
        $expected = 'Este informe tiene "comillas" y ;';
        $this->assertEquals($expected, StrUtil::formatReport($input));
    }

// 🧪 destacarTerm()
    public function testDestacarTermUnaPalabra()
    {
        $input = 'hola mundo';
        $term = 'hola';
        $expected = '<strong>Hola</strong> mundo';
        $this->assertEquals($expected, StrUtil::destacarTerm($term, $input));
    }

    public function testDestacarTermMultiplesPalabrasConAcentos()
    {
        $input = 'el árbol es útil en la estación';
        $term = 'árbol útil';
        $expected = 'el <strong>Árbol</strong> es <strong>Útil</strong> en la estación';
        $this->assertEquals($expected, StrUtil::destacarTerm($term, $input));
    }

    public function testDestacarTermNoEncuentraTermino()
    {
        $input = 'nada que ver aquí';
        $term = 'árbol';
        $this->assertEquals($input, StrUtil::destacarTerm($term, $input));
    }

}


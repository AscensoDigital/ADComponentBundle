<?php

namespace ADComponentBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use AscensoDigital\ComponentBundle\Util\Distancia;

class DistanciaTest extends TestCase
{
    public function testMismaCoordenadaRetornaCero()
    {
        $resultado = Distancia::calcGeodesica(-33.45, -70.6667, -33.45, -70.6667);
        $this->assertEquals(0, $resultado);
    }

    public function testDistanciaEntreSantiagoYValparaisoEnMetros()
    {
        $resultado = Distancia::calcGeodesica(-33.45, -70.6667, -33.03, -71.55);
        // Resultado esperado ~100,000 metros con margen
        $this->assertGreaterThan(90000, $resultado);
        $this->assertLessThan(110000, $resultado);
    }

    public function testDistanciaEnKilometros()
    {
        $resultado = Distancia::calcGeodesica(-33.45, -70.6667, -33.03, -71.55, Distancia::KILOMETROS);
        $this->assertIsFloat($resultado);
        $this->assertGreaterThan(90, $resultado);
        $this->assertLessThan(110, $resultado);
    }

    public function testDistanciaEnMillas()
    {
        $resultado = Distancia::calcGeodesica(-33.45, -70.6667, -33.03, -71.55, Distancia::MILLAS);
        $this->assertIsFloat($resultado);
        $this->assertGreaterThan(50, $resultado);
        $this->assertLessThan(70, $resultado);
    }

    public function testUnidadInvalidaRetornaNull()
    {
        $resultado = Distancia::calcGeodesica(-33.45, -70.6667, -33.03, -71.55, 99);
        $this->assertNull($resultado);
    }

    /**
     * @dataProvider invalidInputs
     */
    public function testParametrosNoNumericosRetornanNull($lat1, $long1, $lat2, $long2)
    {
        $resultado = Distancia::calcGeodesica($lat1, $long1, $lat2, $long2);
        $this->assertNull($resultado);
    }

    public function invalidInputs()
    {
        return [
            ['a', -70.6, -33.0, -71.5],
            [-33.4, 'x', -33.0, -71.5],
            [-33.4, -70.6, null, -71.5],
            [-33.4, -70.6, -33.0, []],
        ];
    }
}


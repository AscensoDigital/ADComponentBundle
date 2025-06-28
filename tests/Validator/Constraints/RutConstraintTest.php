<?php

namespace ADComponentBundle\Tests\Validator\Constraints;

use AscensoDigital\ComponentBundle\Validator\Constraints\Rut;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;

class RutConstraintTest extends TestCase
{
    public function testRutEsInstanciaDeConstraint()
    {
        $constraint = new Rut();
        $this->assertInstanceOf(Constraint::class, $constraint);
    }

    public function testMensajePorDefecto()
    {
        $constraint = new Rut();
        $this->assertEquals(
            'Rut o Digito Verificador de "{{ rut }}", no es valido',
            $constraint->message
        );
    }

    public function testSobrescribirMensaje()
    {
        $custom = 'Este RUT no es válido.';
        $constraint = new Rut(['message' => $custom]);
        $this->assertSame($custom, $constraint->message);
    }

    public function testValidatedBy()
    {
        $constraint = new Rut();
        $this->assertEquals(
            'AscensoDigital\ComponentBundle\Validator\Constraints\RutValidator',
            $constraint->validatedBy()
        );
    }
}

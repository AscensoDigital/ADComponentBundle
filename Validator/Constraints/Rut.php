<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 20-04-19
 * Time: 3:57
 */

namespace AscensoDigital\ComponentBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Rut extends Constraint
{
    public $message = 'Rut o Digito Verificador de "{{ rut }}", no es valido';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
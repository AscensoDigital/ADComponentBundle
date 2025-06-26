<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 20-04-19
 * Time: 13:38
 */

namespace AscensoDigital\ComponentBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class RutValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$constraint instanceof Rut) {
            throw new UnexpectedTypeException($constraint, "AscensoDigital\ComponentBundle\Validator\Constraints\Rut");
        }

        if (null === $value || '' === $value || '-' === $value) {
            return;
        }

        $ARut=explode("-",$value);

        if(count($ARut) !== 2 || !ctype_alnum($ARut[0])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ rut }}', $value)
                ->addViolation();
            return;
        }

        // Verificar que la parte numérica solo contiene números
        if(!ctype_digit($ARut[0])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ rut }}', $value)
                ->addViolation();
            return;
        }

        $rut_leido=$ARut[0];
        $d9=floor($rut_leido/100000000);
        $rut_leido=$rut_leido-$d9*100000000;
        $d8=floor($rut_leido/10000000);
        $rut_leido=$rut_leido-$d8*10000000;
        $d7=floor($rut_leido/1000000);
        $rut_leido=$rut_leido-$d7*1000000;
        $d6=floor($rut_leido/100000);
        $rut_leido=$rut_leido-$d6*100000;
        $d5=floor($rut_leido/10000);
        $rut_leido=$rut_leido-$d5*10000;
        $d4=floor($rut_leido/1000);
        $rut_leido=$rut_leido-$d4*1000;
        $d3=floor($rut_leido/100);
        $rut_leido=$rut_leido-$d3*100;
        $d2=floor($rut_leido/10);
        $rut_leido=$rut_leido-$d2*10;
        $d1=floor($rut_leido/1);
        $sum=$d1*2+$d2*3+$d3*4+$d4*5+$d5*6+$d6*7+$d7*2+$d8*3+$d9*4;
        $modu=$sum%11;
        $dv_leido=11-$modu;
        if ($dv_leido==11) {
            $dv_leido = 0;
        }
        if ($dv_leido==10) {
            $dv_leido = 'k';
        }

        if ($dv_leido!=$ARut[1]) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ rut }}', $value)
                ->addViolation();
        }
    }
}
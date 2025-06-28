<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 20-04-19
 * Time: 13:38
 */

namespace AscensoDigital\ComponentBundle\Validator\Constraints;


use AscensoDigital\ComponentBundle\Util\StrUtil;
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
        if (!$constraint instanceof Rut) {
            throw new UnexpectedTypeException($constraint, "AscensoDigital\ComponentBundle\Validator\Constraints\Rut");
        }

        if (null === $value || '' === $value || '-' === $value) {
            return;
        }

        // 🔧 Normalización
        $value = strtolower(trim($value)); // quita espacios y convierte K a k
        $value = str_replace('.', '', $value); // quita puntos

        // Si no contiene guion, intentar insertar uno
        if (strpos($value, '-') === false && strlen($value) > 1) {
            $value = substr($value, 0, -1) . '-' . substr($value, -1);
        }

        $ARut = explode("-", $value);

        if (count($ARut) !== 2 || !ctype_digit($ARut[0])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ rut }}', $value)
                ->addViolation();
            return;
        }

        $rut = (int) $ARut[0];
        $dvIngresado = strtolower(trim($ARut[1]));

        // Cálculo del dígito verificador esperado
        $suma = 0;
        $multiplo = 2;
        while ($rut > 0) {
            $suma += ($rut % 10) * $multiplo;
            $rut = floor($rut / 10);
            $multiplo = ($multiplo < 7) ? $multiplo + 1 : 2;
        }

        $resto = $suma % 11;
        $dvEsperado = 11 - $resto;
        if ($dvEsperado == 11) $dvEsperado = '0';
        elseif ($dvEsperado == 10) $dvEsperado = 'k';
        else $dvEsperado = (string)$dvEsperado;

        if ($dvEsperado !== $dvIngresado) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ rut }}', $value)
                ->addViolation();
        }
    }

}
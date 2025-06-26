<?php

namespace ADComponentBundle\Tests\Validator\Constraints;

use AscensoDigital\ComponentBundle\Validator\Constraints\Rut;
use AscensoDigital\ComponentBundle\Validator\Constraints\RutValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;
use PHPUnit\Framework\TestCase;

class RutValidatorTest extends TestCase
{
    private $context;
    private $validator;

    protected function setUp(): void
    {
        $this->context = $this->createMock(ExecutionContextInterface::class);
        $this->validator = new RutValidator();
        $this->validator->initialize($this->context);
    }

    public function testValido()
    {
        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate('11111111-1', new Rut(['message' => 'invalid']));
    }

    public function testDvInvalido()
    {
        $violationBuilder = $this->createMock(ConstraintViolationBuilderInterface::class);
        $violationBuilder->expects($this->once())->method('setParameter')->willReturnSelf();
        $violationBuilder->expects($this->once())->method('addViolation');

        $this->context
            ->expects($this->once())
            ->method('buildViolation')
            ->with('invalid')
            ->willReturn($violationBuilder);

        $this->validator->validate('11111111-9', new Rut(['message' => 'invalid']));
    }

    public function testValorVacioNoValida()
    {
        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate('', new Rut(['message' => 'invalid']));
        $this->validator->validate(null, new Rut(['message' => 'invalid']));
        $this->validator->validate('-', new Rut(['message' => 'invalid']));
    }

    public function testFormatoIncorrecto()
    {
        $violationBuilder = $this->createMock(ConstraintViolationBuilderInterface::class);
        $violationBuilder->expects($this->once())->method('setParameter')->willReturnSelf();
        $violationBuilder->expects($this->once())->method('addViolation');

        $this->context
            ->expects($this->once())
            ->method('buildViolation')
            ->with('invalid')
            ->willReturn($violationBuilder);

        $this->validator->validate('abcd1234', new Rut(['message' => 'invalid']));
    }
}

<?php

namespace ADComponentBundle\Tests\Form\Type;

use AscensoDigital\ComponentBundle\Form\Type\DateTimeHiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\PreloadedExtension;
use PHPUnit\Framework\TestCase;

class DateTimeHiddenTypeTest extends TestCase
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    protected function setUp(): void
    {
        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions([$this->getExtensions()])
            ->getFormFactory();
    }

    protected function getExtensions()
    {
        $type = new DateTimeHiddenType();
        return new PreloadedExtension([$type], []);
    }

    public function testDateTimeHiddenFieldRendersAndSubmitsCorrectly()
    {
        $form = $this->factory->create(DateTimeHiddenType::class);

        $date = new \DateTime('2025-06-22 14:30:00');
        $form->submit($date->format('Y-m-d H:i:s'));

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $form->getData()->format('Y-m-d H:i:s'));
    }
}

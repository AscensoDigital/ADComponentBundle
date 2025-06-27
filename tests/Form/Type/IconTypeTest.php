<?php

namespace ADComponentBundle\Tests\Form\Type;

use AscensoDigital\ComponentBundle\Form\Type\IconType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\PreloadedExtension;
use PHPUnit\Framework\TestCase;

class IconTypeTest extends TestCase
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
        return new PreloadedExtension([new IconType()], []);
    }

    public function testIconFieldRendersAndSubmits()
    {
        $form = $this->factory->create(IconType::class);

        $form->submit('fa-user');

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('fa-user', $form->getData());
    }

    public function testParentTypeIsText()
    {
        $type = new IconType();
        $this->assertEquals(TextType::class, $type->getParent());
    }
}

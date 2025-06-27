<?php

namespace ADComponentBundle\Tests\Form\Type;

use AscensoDigital\ComponentBundle\Form\Type\RatingType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\PreloadedExtension;
use PHPUnit\Framework\TestCase;

class RatingTypeTest extends TestCase
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
        return new PreloadedExtension([new RatingType()], []);
    }

    public function testSubmitRatingValue()
    {
        $form = $this->factory->create(RatingType::class);

        $form->submit(4);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(4, $form->getData());
    }

    public function testParentIsNumberType()
    {
        $type = new RatingType();
        $this->assertEquals(NumberType::class, $type->getParent());
    }

    public function testViewVarsFromDefaults()
    {
        $form = $this->factory->create(RatingType::class);
        $view = $form->createView();

        $this->assertEquals([1, 2, 3, 4, 5], $view->vars['rating_values']);
        $this->assertEquals(1, $view->vars['rating_min']);
        $this->assertEquals('fa-star-o', $view->vars['rating_icon_base']);
        $this->assertEquals('fa-star', $view->vars['rating_icon_check']);
        $this->assertEquals('(Haz click para puntuar)', $view->vars['rating_label_empty']);
        $this->assertArrayHasKey(5, $view->vars['rating_labels']);
    }
}

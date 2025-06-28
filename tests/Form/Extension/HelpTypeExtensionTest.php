<?php

namespace AscensoDigital\ComponentBundle\Tests\Form\Extension;

use AscensoDigital\ComponentBundle\Form\Extension\HelpTypeExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HelpTypeExtensionTest extends TestCase
{
    public function testConfigureOptionsAddsAdComponentHelp()
    {
        $resolver = new OptionsResolver();
        $extension = new HelpTypeExtension();
        $extension->configureOptions($resolver);

        $resolved = $resolver->resolve(['ad_component_help' => 'texto']);
        $this->assertArrayHasKey('ad_component_help', $resolved);
        $this->assertEquals('texto', $resolved['ad_component_help']);
    }

    public function testBuildViewSetsAdComponentHelpVariable()
    {
        $view = new FormView();
        $form = $this->createMock(FormInterface::class);
        $extension = new HelpTypeExtension();

        $extension->buildView($view, $form, ['ad_component_help' => 'Este campo es requerido']);

        $this->assertArrayHasKey('ad_component_help', $view->vars);
        $this->assertEquals('Este campo es requerido', $view->vars['ad_component_help']);
    }


    public function testGetExtendedTypeReturnsFormType()
    {
        $extension = new HelpTypeExtension();

        if (method_exists($extension, 'getExtendedTypes')) {
            $types = iterator_to_array($extension::getExtendedTypes());
            $this->assertContains('Symfony\Component\Form\Extension\Core\Type\FormType', $types);
        } else {
            $this->assertEquals('Symfony\Component\Form\Extension\Core\Type\FormType', $extension->getExtendedType());
        }
    }
}

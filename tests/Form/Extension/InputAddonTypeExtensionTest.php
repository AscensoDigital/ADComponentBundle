<?php

namespace AscensoDigital\ComponentBundle\Tests\Form\Extension;

use AscensoDigital\ComponentBundle\Form\Extension\InputAddonTypeExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class InputAddonTypeExtensionTest extends TestCase
{
    public function testConfigureOptionsAcceptsValidValues()
    {
        $resolver = new OptionsResolver();
        $extension = new InputAddonTypeExtension();
        $extension->configureOptions($resolver);

        $resolved = $resolver->resolve([
            'ad_component_addon' => 'both',
            'ad_component_addon_type' => ['pre' => 'icon', 'post' => 'text'],
            'ad_component_addon_content_type' => ['pre' => 'text', 'post' => 'icon'],
            'ad_component_addon_content' => ['pre' => '+', 'post' => '>'],
            'ad_component_addon_attr' => ['pre' => ['class' => 'a'], 'post' => ['class' => 'b']]
        ]);

        $this->assertEquals('both', $resolved['ad_component_addon']);
    }

    public function testDefaultValuesAreSet()
    {
        $resolver = new OptionsResolver();
        $extension = new InputAddonTypeExtension();
        $extension->configureOptions($resolver);

        $resolved = $resolver->resolve([]);

        $this->assertEquals(['pre' => 'text', 'post' => 'text'], $resolved['ad_component_addon_type']);
        $this->assertEquals(['pre' => 'text', 'post' => 'text'], $resolved['ad_component_addon_content_type']);
    }

    public function testInvalidAddonThrowsException()
    {
        $this->expectException(InvalidOptionsException::class);

        $resolver = new OptionsResolver();
        $extension = new InputAddonTypeExtension();
        $extension->configureOptions($resolver);

        $resolver->resolve(['ad_component_addon' => 'invalid']);
    }

    public function testInvalidAddonTypeThrowsException()
    {
        $this->expectException(InvalidOptionsException::class);

        $resolver = new OptionsResolver();
        $extension = new InputAddonTypeExtension();
        $extension->configureOptions($resolver);

        $resolver->resolve(['ad_component_addon_type' => ['pre' => 'invalid']]);
    }

    public function testInvalidAddonContentTypeThrowsException()
    {
        $this->expectException(InvalidOptionsException::class);

        $resolver = new OptionsResolver();
        $extension = new InputAddonTypeExtension();
        $extension->configureOptions($resolver);

        $resolver->resolve(['ad_component_addon_content_type' => ['post' => 'emoji']]);
    }

    public function testBuildViewSetsAddonVariablesCorrectly()
    {
        $view = new FormView();
        $form = $this->createMock(FormInterface::class);
        $extension = new InputAddonTypeExtension();

        $options = [
            'ad_component_addon' => 'pre',
            'ad_component_addon_type' => ['pre' => 'icon'],
            'ad_component_addon_content_type' => ['pre' => 'text'],
            'ad_component_addon_content' => ['pre' => '+'],
            'ad_component_addon_attr' => ['pre' => ['class' => 'addon-pre']]
        ];

        $extension->buildView($view, $form, $options);

        $this->assertEquals('icon', $view->vars['ad_component_addon_type_pre']);
        $this->assertEquals('text', $view->vars['ad_component_addon_content_type_pre']);
        $this->assertEquals('+', $view->vars['ad_component_addon_content_pre']);
        $this->assertEquals(['class' => 'addon-pre'], $view->vars['ad_component_addon_attr_pre']);
    }

    public function testBuildViewDoesNothingWithoutAddon()
    {
        $view = new FormView();
        $form = $this->createMock(FormInterface::class);
        $extension = new InputAddonTypeExtension();

        $options = []; // no se define ad_component_addon
        $extension->buildView($view, $form, $options);

        $this->assertArrayNotHasKey('ad_component_addon_type_pre', $view->vars);
        $this->assertArrayNotHasKey('ad_component_addon_content_type_pre', $view->vars);
        $this->assertArrayNotHasKey('ad_component_addon_content_pre', $view->vars);
        $this->assertArrayNotHasKey('ad_component_addon_attr_pre', $view->vars);
    }

    public function testGetExtendedTypeReturnsFormType()
    {
        $extension = new InputAddonTypeExtension();

        if (method_exists($extension, 'getExtendedTypes')) {
            $types = iterator_to_array($extension::getExtendedTypes());
            $this->assertContains('Symfony\Component\Form\Extension\Core\Type\FormType', $types);
        } else {
            $this->assertEquals('Symfony\Component\Form\Extension\Core\Type\FormType', $extension->getExtendedType());
        }
    }
}

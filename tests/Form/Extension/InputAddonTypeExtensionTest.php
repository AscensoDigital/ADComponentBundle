<?php

namespace AscensoDigital\ComponentBundle\Tests\Form\Extension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\PreloadedExtension;
use AscensoDigital\ComponentBundle\Form\Extension\InputAddonTypeExtension;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class InputAddonTypeExtensionTest extends TestCase
{


    protected function setUp(): void
    {
        $this->factory = \Symfony\Component\Form\Forms::createFormFactoryBuilder()
            ->addExtensions([
                new \Symfony\Component\Form\PreloadedExtension([], [
                    \Symfony\Component\Form\Extension\Core\Type\TextType::class => [new \AscensoDigital\ComponentBundle\Form\Extension\InputAddonTypeExtension()],
                ])
            ])
            ->getFormFactory();
    }



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

    public function testConfigureOptionsStringAcceptsValidValues()
    {
        $resolver = new OptionsResolver();
        $extension = new InputAddonTypeExtension();
        $extension->configureOptions($resolver);

        $resolved = $resolver->resolve([
            'ad_component_addon' => 'pre',
            'ad_component_addon_type' => 'icon',
            'ad_component_addon_content_type' => 'text',
            'ad_component_addon_content' => '+',
            'ad_component_addon_attr' => ['class' => 'a']
        ]);

        $this->assertEquals('pre', $resolved['ad_component_addon']);
        $this->assertEquals('icon', $resolved['ad_component_addon_type']);
        $this->assertEquals('text', $resolved['ad_component_addon_content_type']);
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

    public function testInvalidAddonTypeLiteralThrowsException(): void
    {
        $this->expectException(\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException::class);

        $form = $this->factory->create(\Symfony\Component\Form\Extension\Core\Type\TextType::class, null, [
            'ad_component_addon' => 'pre',
            'ad_component_addon_type' => 'invalid',
        ]);
    }

    public function testInvalidAddonContentTypeLiteralThrowsException(): void
    {
        $this->expectException(\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException::class);

        $form = $this->factory->create(\Symfony\Component\Form\Extension\Core\Type\TextType::class, null, [
            'ad_component_addon' => 'post',
            'ad_component_addon_type' => 'button',
            'ad_component_addon_content_type' => 'invalido',
        ]);
    }

}
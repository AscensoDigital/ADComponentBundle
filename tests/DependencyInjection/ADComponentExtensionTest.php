<?php

namespace AscensoDigital\ComponentBundle\Tests\DependencyInjection;

use AscensoDigital\ComponentBundle\DependencyInjection\ADComponentExtension;
use AscensoDigital\ComponentBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ADComponentExtensionTest extends TestCase
{
    public function testLoadWithHorizontalBootstrapLayout()
    {
        $container = new ContainerBuilder();
        $extension = new ADComponentExtension();

        $configs = [['bootstrap_layout' => 'horizontal']];
        $extension->load($configs, $container);

        $this->assertTrue($container->hasParameter('ad_component.config'));
        $this->assertSame($configs[0], $container->getParameter('ad_component.config'));

        $this->assertTrue($container->hasParameter('ad_component.bootstrap_layout'));
        $this->assertEquals(
            'bootstrap_3_horizontal_layout.html.twig',
            $container->getParameter('ad_component.bootstrap_layout')
        );
    }

    public function testLoadWithDefaultBootstrapLayout()
    {
        $container = new ContainerBuilder();
        $extension = new ADComponentExtension();

        $configs = [[]]; // Sin bootstrap_layout → usa 'horizontal' por defecto
        $extension->load($configs, $container);

        $this->assertTrue($container->hasParameter('ad_component.bootstrap_layout'));
        $this->assertEquals(
            'bootstrap_3_horizontal_layout.html.twig',
            $container->getParameter('ad_component.bootstrap_layout')
        );
    }
    public function testServicesAreLoaded()
    {
        $container = new ContainerBuilder();
        $extension = new ADComponentExtension();
        $configs = [['bootstrap_layout' => 'horizontal']];
        $extension->load($configs, $container);

        $this->assertTrue($container->hasDefinition('ad_component.modificador.subscriber'));
        $this->assertTrue($container->hasDefinition('ad_component.datetime_hidden.type'));
        $this->assertTrue($container->hasDefinition('ad_component.object_hidden.type'));
        $this->assertTrue($container->hasDefinition('ad_component.twig_extension'));
        $this->assertTrue($container->hasDefinition('ad_component.help_type_extension'));

        $definition = $container->getDefinition('ad_component.twig_extension');
        $this->assertEquals(
            'AscensoDigital\\ComponentBundle\\Twig\\ADExtension',
            $definition->getClass()
        );
    }

}

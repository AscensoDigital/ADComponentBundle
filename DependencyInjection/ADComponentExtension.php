<?php

namespace AscensoDigital\ComponentBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 20-01-16
 * Time: 19:18
 */
class ADComponentExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('ad_component.config', $config);
        
        $btv=$config['bootstrap_version'];
        $container->setParameter('ad_component.bootstrap_version',$btv);
        if('horizontal' == $config['bootstrap_layout']){
            $container->setParameter('ad_component.bootstrap_layout', 'bootstrap_'.$btv.'_horizontal_layout.html.twig');
        }
        else {
            $container->setParameter('ad_component.bootstrap_layout', 'bootstrap_'.$btv.'_layout.html.twig');
        }

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function getAlias()
    {
        return 'ad_component';
    }
}

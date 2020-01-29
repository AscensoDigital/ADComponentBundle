<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 18-02-16
 * Time: 16:15
 */

namespace AscensoDigital\ComponentBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('ad_component');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC for symfony/config < 4.2
            $rootNode = $treeBuilder->root('ad_component');
        }

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->enumNode('bootstrap_layout')
                    ->cannotBeEmpty()
                    ->defaultValue('horizontal')
                    ->values(['horizontal','vertical'])
                ->end()
                ->enumNode('bootstrap_version')
                    ->cannotBeEmpty()
                    ->defaultValue('3')
                    ->values(['3','4'])
                ->end()
            ->end()
        ->end();
        return $treeBuilder;
    }
}

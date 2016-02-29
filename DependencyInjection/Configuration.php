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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ad_component');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->enumNode('bootstrap_layout')
                    ->cannotBeEmpty()
                    ->defaultValue('horizontal')
                    ->values(['horizontal','vertical'])
                ->end()
            ->end()
        ->end();
        return $treeBuilder;
    }
}

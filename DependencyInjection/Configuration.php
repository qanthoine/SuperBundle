<?php
namespace SuperBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('super_bundle');

        $rootNode
            ->children()
                ->arrayNode('config_roles')
                    ->children()
                        ->scalarNode('view_pages')->end()
                    ->end()
                ->end()
                ->arrayNode('versionnement')
                    ->children()
                        ->integerNode('save')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
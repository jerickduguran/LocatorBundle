<?php

namespace Groupm\Mosaic\Bundle\LocatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mosaic_locator');
 
        $rootNode
          ->children()  
               ->arrayNode('config')
                  ->addDefaultsIfNotSet()
                  ->children()  
                      ->scalarNode('api_key')
                          ->cannotBeEmpty()->defaultValue('AIzaSyCroxeWAMu25pazpF6dnSdyB5VK3ChcPNk')->end() 
                      ->booleanNode('nearest_location')
                          ->defaultFalse()->end()
                      ->scalarNode('marker_icon')
                          ->cannotBeEmpty()->defaultValue('https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png')->end() 
                  ->end()
               ->end()  
               ->arrayNode('entity')
                  ->addDefaultsIfNotSet()
                  ->children()  
                      ->scalarNode('class')
                          ->cannotBeEmpty()->defaultValue('AppBundle\\Entity\\Locator\\Location')->end()
                      ->scalarNode('manager')
                          ->cannotBeEmpty()->defaultValue('Groupm\\Mosaic\\Bundle\\LocatorBundle\\Entity\\Manager\\LocationManager')->end()
                      ->scalarNode('controller')
                          ->cannotBeEmpty()->defaultValue('Groupm\\Mosaic\\Bundle\\LocatorBundle\\Controller\\LocatorController')->end()
                  ->end()
               ->end()  
               ->arrayNode('admin')
                  ->addDefaultsIfNotSet()
                  ->children() 
                      ->scalarNode('class')->cannotBeEmpty()->defaultValue('Groupm\\Mosaic\\Bundle\\LocatorBundle\\Admin\\LocationAdmin')->end()
                      ->scalarNode('controller')->cannotBeEmpty()->defaultValue('MosaicAdminBundle:CRUD')->end()
                      ->scalarNode('translation')->cannotBeEmpty()->defaultValue('MosaicLocatorBundle')->end()
                   ->end()
                ->end()  
                ->arrayNode('class')
                     ->addDefaultsIfNotSet()
                     ->children() 
                         ->scalarNode('site')->cannotBeEmpty()->defaultValue('AppBundle\\Entity\\Page\\Site')->end() 
                         ->scalarNode('map')->cannotBeEmpty()->defaultValue('Groupm\\Mosaic\\Bundle\\LocatorBundle\\Form\\Type\\MapType')->end() 
                         ->scalarNode('media')->cannotBeEmpty()->defaultValue('AppBundle\\Entity\\Media\\Media')->end() 
                      ->end()
                 ->end()   
           ->end();

        return $treeBuilder;
    }
}

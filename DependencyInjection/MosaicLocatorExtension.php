<?php

namespace Groupm\Mosaic\Bundle\LocatorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MosaicLocatorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('admin.xml');
                
        $this->configureSettings($config,$container); 
        $this->configureEntity($config,$container); 
        $this->configureClasses($config,$container); 
        $this->configureAdminClass($config,$container);  
        $this->configureTranslationDomain($config,$container);  
        $this->configureORM($config);           
    } 
    
    public function configureSettings($config, ContainerBuilder $container)
    { 
        $container->setParameter('mosaic_locator.config.api_key', $config['config']['api_key']); 
        $container->setParameter('mosaic_locator.config.nearest_location', $config['config']['nearest_location']); 
        $container->setParameter('mosaic_locator.config.marker_icon', $config['config']['marker_icon']);  
    }
    public function configureEntity($config, ContainerBuilder $container)
    { 
        $container->setParameter('mosaic_locator.entity.locator.class', $config['entity']['class']); 
        $container->setParameter('mosaic_locator.manager.locator', $config['entity']['manager']); 
        $container->setParameter('mosaic_locator.controller.locator', $config['entity']['controller']);  
    }
    
    public function configureAdminClass($config, ContainerBuilder $container)
    { 
        $container->setParameter('mosaic_locator.admin.locator.class', $config['admin']['class']);        
        $container->setParameter('mosaic_locator.admin.locator.controller', $config['admin']['controller']);        
    }      
    
    public function configureTranslationDomain($config, ContainerBuilder $container)
    {
        $container->setParameter('mosaic_locator.admin.locator.translation_domain', $config['admin']['translation']);
    }
    
    public function configureClasses($config, ContainerBuilder $container)
    {
        $container->setParameter('mosaic_locator.form.type.map', $config['class']['map']);  
    }
    
    public function configureORM(array $config)
    {   
        $collector = DoctrineCollector::getInstance();
        
        //Site 
        $collector->addAssociation($config['entity']['class'], 'mapManyToOne', array(
            'fieldName'     => 'site',
            'targetEntity'  => $config['class']['site'],
            'cascade'       => array(
                'persist',
            ),
            'mappedBy'      => null,
            'inversedBy'    => null,
            'joinColumns'   => array(
                array(
                    'name'                 => 'site_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));
        
        //Location Media | Image
        if (interface_exists('Sonata\MediaBundle\Model\MediaInterface')) {
            $collector->addAssociation($config['entity']['class'], 'mapManyToOne', array(
                'fieldName' => 'photo',
                'targetEntity' =>  $config['class']['media'],
                'cascade' => array(
                    'detach',
                ),
                'mappedBy' => null,
                'inversedBy' => null, 
                'orphanRemoval' => false,
                'joinColumns' => array(
                    array(
                        'name' => 'photo_id',
                        'referencedColumnName' => 'id',
                        'onDelete' => "SET NULL"
                    ),
                ),
            )); 
        }
    }
}

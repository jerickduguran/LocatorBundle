<?php

namespace Groupm\Mosaic\Bundle\LocatorBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LocationAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('address')
            ->add('phone')
            ->add('mobile')
            ->add('email')
            ->add('latitude')
            ->add('longitude')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name') 
            ->add('latitude')
            ->add('longitude')
            ->add('enabled')
            ->add('createdAt') 
            ->add('id')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->initAdminFormStructure($formMapper);
        $templates = $this->getConfigurationPool()->getContainer()->getParameter("mosaic.media.admin.media.helper.templates"); 
        $template  = "";
        if(isset($templates['media_preview'])){
            $template = $templates['media_preview'];
        }
        
        $formMapper
            ->tab('tab.mosaic_locator') 
                ->with('mosaic_locator.general_info')
                    ->add('enabled') 
                    ->add('name')
                    ->add('phone')
                    ->add('mobile')
                    ->add('email')
                    ->add('address')
                    ->add('photo', 'sonata_type_model_list', 
                                                array('label'    => 'Photo', 
                                                      'required' => false), 
                                                array('link_parameters' => array('context'           => 'default', 
                                                                                 'provider'          => 'sonata.media.provider.image',
                                                                                 'response_template' => $template)))
                ->end() 
                ->with('mosaic_locator.map_settings') 
                    ->add('map','map',array('mapped' => false,'lat_field' => 'latitude','lng_field' => 'longitude'))
                    ->add('latitude')
                    ->add('longitude')
                ->end() 
            ->end() 
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('phone')
            ->add('mobile')
            ->add('email')
            ->add('address')
            ->add('latitude')
            ->add('longitude')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('id')
        ;
    } 
    
    protected function initAdminFormStructure($formMapper) 
    {
        $formMapper
            ->tab('tab.mosaic_locator') 
                ->with('mosaic_locator.general_info', array('class' => 'col-md-8'))->end()  
                ->with('mosaic_locator.map_settings', array('class' => 'col-md-4'))->end()  
            ->end();
    }
}

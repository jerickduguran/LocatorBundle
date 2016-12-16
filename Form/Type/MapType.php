<?php
 
namespace Groupm\Mosaic\Bundle\LocatorBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface; 

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\DependencyInjection\ContainerInterface as Container; 
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView; 


class MapType extends AbstractType
{     
    protected $container   = null;  
	 
    public function __construct(Container $container)
    {
        $this->container    = $container; 
    }	 
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
       
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {    
        $view->vars['css_style']   = $options['css_style'];
        $view->vars['default_lat'] = $options['default_lat'];
        $view->vars['default_lng'] = $options['default_lng'];
        $view->vars['lat_field']    = $options['lat_field'];
        $view->vars['lng_field']    = $options['lng_field'];
        $view->vars['radius']       = $options['radius'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {    
        $resolver->setDefaults(array( 
            'css_style'      => 'height:300px;width:300px;',
            'default_lat'    => '14.5528018',
            'default_lng'    => '121.05181470000002',
            'lat_field'      => null,
            'lng_field'      => null,
            'radius'         => 15
        ));	
    } 
	
    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'map';
    }   
}

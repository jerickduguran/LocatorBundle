<?php

namespace Groupm\Mosaic\Bundle\LocatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller; 
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function indexAction()
    {
        $apiKey              = $this->container->getParameter("mosaic_locator.config.api_key");
        $findNearestLocation = $this->container->getParameter("mosaic_locator.config.nearest_location");
        $markerIcon          = $this->container->getParameter("mosaic_locator.config.marker_icon");
        
        return $this->render('MosaicLocatorBundle:Index:index.html.twig',array('api_key' => $apiKey,'icon' => $markerIcon,'find_nearest' => $findNearestLocation));
    }
    
    public function fetchLocationsAction()
    {
        $locationManager =  $this->container->get('mosaic_locator.manager.locator');        
        $locations       =  $locationManager->findBy(array("enabled" => true),array("name" => "ASC"));  
        
        $response =  new Response($this->renderView('MosaicLocatorBundle:Index:locations.xml.twig',array('locations' => $locations)));
        
        $response->headers->set('Content-Type', 'text/xml');
        
        return $response; 
    }
}

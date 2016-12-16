<?php
 
namespace Groupm\Mosaic\Bundle\LocatorBundle\Model;

interface LocationInterface{
    
    public function getName();
    public function getLatitude();
    public function getLongitude();
    public function getAddress(); 

}
<?php

namespace Groupm\Mosaic\Bundle\LocatorBundle\Entity;

use Groupm\Mosaic\Bundle\LocatorBundle\Model\Location as ModelLocation;

abstract class Location extends ModelLocation 
{ 
    /**
     * Pre Persist method
     */
    public function prePersist()
    { 
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }  
    
    /**
     * Pre Update method
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    } 
    
    public function __toString()
    {
        return $this->getId() ? $this->getName() : "New";
    }
}

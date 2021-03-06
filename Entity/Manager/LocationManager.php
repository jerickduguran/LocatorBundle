<?php

namespace Groupm\Mosaic\Bundle\LocatorBundle\Entity\Manager; 

use Doctrine\ORM\EntityManager;
use Groupm\Mosaic\Bundle\LocatorBundle\Model\LocationInterface;

/**
 * LocationManager
 */
class LocationManager implements LocationManagerInterface
{  
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @var array
     */
    protected $config;
    
    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param string                      $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em     = $em;
        $this->class  = $class;
    }
    
    /**
     * {@inheritDoc}
     */
    public function save(LocationInterface $location)
    {
        $this->em->persist($location);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria)
    {
        return $this->em->getRepository($this->class)->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria, array $orderBy = null)
    {
        return $this->em->getRepository($this->class)->findBy($criteria, $orderBy);
    }
    
    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return $this->em->getRepository($this->class)->findById($id);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(LocationInterface $location)
    {
        $this->em->remove($location);
        $this->em->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {
        return new $this->class;
    } 
    
    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        return $this->em->getRepository($this->class)->findAll();
    }  
}

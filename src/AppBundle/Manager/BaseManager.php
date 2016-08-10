<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class BaseManager 
{
    
    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * 
     * @param EntityManagerInterface $entityManager
     * @param Router $router
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, Router $router) 
    {
        $this->entityManager = $entityManager;
        $this->route         = $router;
    }

    /**
     * 
     * @param type $entity
     */
    public function save($entity)
    {
        $this->entityManager->persist($entity);

        return $entity;
    }

    /**
     * 
     * @param type $entity
     */
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->flushAndClear();
    }

    public function flushAndClear()
    {
        $this->entityManager->flush();
    }

}

<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class BaseManager 
{
    const EMPLOYEE_MANAGER = 'app.employee_manager';
    
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

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
    public function add($entity)
    {
        $this->entityManager->persist($entity);
        $this->flushAndClear();
    }

    /**
     * 
     * @param type $entity
     */
    public function edit($entity)
    {
        $this->entityManager->persist($entity);
        $this->flushAndClear();
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

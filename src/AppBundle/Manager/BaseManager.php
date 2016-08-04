<?php

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Route;

class BaseManager
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;
    /**
     * @var Route $router
     */
    protected $router;

    public function __construct(EntityManager $entityManager, Route $route)
    {
        $this->entityManager = $entityManager;
        $this->router = $route;
    }

    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
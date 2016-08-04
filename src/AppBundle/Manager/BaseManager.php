<?php

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Router;

class BaseManager
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;
    /**
     * @var Router $router
     */
    protected $router;

    public function __construct(EntityManager $entityManager, Router $route)
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
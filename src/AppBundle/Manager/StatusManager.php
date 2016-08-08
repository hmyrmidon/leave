<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Status;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class StatusManager extends BaseManager
{
    const SERVICE_NAME = 'app.status_manager';

    /**
     * WorkflowStatusManager constructor.
     */
    public function __construct(EntityManager $entityManager, Router $router)
    {
        parent::__construct($entityManager, $router);
    }

    /**
     * Register new status in database
     * @param string $name
     */
    public function addNewStatus($name)
    {
        $status = new Status();
        $status->setLabel($name);
        $this->save($status);
    }

    /**
     * @param WorkflowStatus $status
     * @param string         $newName
     */
    public function editStatus(Status $status, $newName)
    {
        $status->setLabel($newName);
        $this->save($status);
    }
    
}
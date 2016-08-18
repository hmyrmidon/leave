<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class DashboardManager extends BaseManager
{
    const SERVICE_NAME = 'app.dashboard_manager';
    private $services;
    public function __construct(EntityManagerInterface $entityManager, Router $router, $services)
    {
        parent::__construct($entityManager, $router);
        $this->services = $services;
    }

    public function getCurrentUserVacations(User $user, \DateTime $currentDate)
    {
        $params = [
            'v.employee' => $user->getEmployee(),
            'v.status' => VacationRequest::VALIDATE_STATUS,
            'v.startDate' => [$currentDate->format('Y'), '=', 'YEAR']
        ];
        return $this->entityManager->getRepository('AppBundle:VacationRequest')->getVacationBy($params);
    }

    public function getSumVacation(\DateTime $currentDate, $status = null)
    {
        return $this->services['available']['holiday']->getSumVacationFromYear($currentDate->format('Y'), $status);
    }
}
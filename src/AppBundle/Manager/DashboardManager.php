<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;

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

    public function getSumVacation(User $user, \DateTime $currentDate, $status = null)
    {
        $params = [
            'v.employee' => $user->getEmployee(),
            'v.status' => $status,
            'v.startDate' => [$currentDate->format('Y'), '=', 'YEAR']
        ];
        $holidaySrv = $this->services['available']['holiday'];
        $vacations = $this->entityManager->getRepository('AppBundle:VacationRequest')->getVacationBy($params);
        $count = 0;
        /**
         * @var VacationRequest $vacation
         */
        foreach ($vacations as $vacation){
            $d1 = $holidaySrv->getDayCount($vacation->getStartDate()->format('Y-m-d'), $vacation->getReturnDate()->format('Y-m-d'));
            $d2 = $holidaySrv->countHolidayBetween($vacation->getStartDate(), $vacation->getReturnDate());
            $count += ( $d1- $d2);
        }

        return $count;
    }

    public function performDashboard($user)
    {
        $current = new \DateTime();
        //$srv = $this->services['available']['holiday'];
        /**
         * @var TwigEngine $tmp
         */
        $tmp = $this->services['available']['templating'];
        //$vacations = $srv->getCurrentUserVacations($user, $current);
        $sumPending = $this->getSumVacation($user, $current, VacationRequest::PENDING_STATUS);
        $sumRejected = $this->getSumVacation($user, $current, VacationRequest::DENIED_STATUS);
        $sumValidate = $this->getSumVacation($user, $current, VacationRequest::VALIDATE_STATUS);
        if($user instanceof User && $user->getEmployee() instanceof Employee)
        {
            return $tmp->renderResponse(
                ':admin/dashboard:dashboard.html.twig',
                [
                    'user'=>$user->getEmployee(),
                    'now'=>$current,
                    'sumValidate'=>$sumValidate,
                    'sumPending'=>$sumPending,
                    'sumRejected'=>$sumRejected,
                ]
            );
        }

        return $tmp->renderResponse(
            '::admin-base-layout.html.twig'
        );
    }

}
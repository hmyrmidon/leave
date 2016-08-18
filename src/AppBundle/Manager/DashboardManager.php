<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

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
        $holidaySrv = $this->getServices(HolidayManager::SERVICE_NAME);
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
        /**
         * @var TwigEngine $tmp
         */
        $tmp = $this->getServices('templating');
        /**
         * @var RoleManager $roleHierarchy
         */
        $roleHierarchy = $this->getServices(RoleManager::SERVICE_NAME);
        /**
         * @var VacationRequestManager $vacationSrv
         */
        $vacationSrv = $this->getServices(VacationRequestManager::SERVICE_NAME);
        /**
         * @var CalendarManager $calendarSrv
         */
        $calendarSrv = $this->getServices(CalendarManager::SERVICE_NAME);
        $sumPending = $this->getSumVacation($user, $current, VacationRequest::PENDING_STATUS);
        $sumRejected = $this->getSumVacation($user, $current, VacationRequest::DENIED_STATUS);
        $sumValidate = $this->getSumVacation($user, $current, VacationRequest::VALIDATE_STATUS);
        
        $isUser = $user instanceof User;
        $isEmployee = ($isUser && $user->getEmployee() instanceof Employee);

        if($roleHierarchy->isGranted('ROLE_VALIDATEUR', $user)){
            if($roleHierarchy->isGranted('ROLE_CLIENT', $user)){
                $params = [
                    'user'=>$user->getEmployee(),
                    'now'=>$current,
                    'sumValidate'=>$sumValidate,
                    'sumPending'=>$sumPending,
                    'sumRejected'=>$sumRejected,
                ];
            }
            $pendingVacations = $vacationSrv->performListData($user);
            $vacations = $calendarSrv->populate($user);
            $params['pendingVacations'] = $pendingVacations;
            $params['data'] = $vacations;
            $template = ':admin/dashboard:dashboard-validator.html.twig';
        }elseif ($roleHierarchy->isGranted('ROLE_ADMIN', $user)){
            $calendarData = $calendarSrv->populate();
            $params = [
                'data' => $calendarData
            ];
            $template = ':admin/dashboard:dashboard-admin.html.twig';
        } else {
            $params = [
                'user'=>$user->getEmployee(),
                'now'=>$current,
                'sumValidate'=>$sumValidate,
                'sumPending'=>$sumPending,
                'sumRejected'=>$sumRejected,
            ];
            $template = ':admin/dashboard:dashboard.html.twig';
        }

        return $this->getDashoard($tmp, $template, $params);
    }

    public function getDashoard(TwigEngine $templateEngine, $template, $params = array())
    {
        return $templateEngine->renderResponse($template, $params);
    }

    public function getServices($serviceName)
    {
        return $this->services['available'][$serviceName];
    }
}
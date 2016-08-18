<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\DashboardManager;
use AppBundle\Manager\HolidayManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @Route("/dashboard")
 * @package AppBundle\Controller\Admin
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="app_dashboard")
     */
    public function indexAction()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $current = new \DateTime();
        $srv = $this->get(DashboardManager::SERVICE_NAME);
        //$vacations = $srv->getCurrentUserVacations($user, $current);
        $sumPending = $srv->getSumVacation($current, VacationRequest::PENDING_STATUS);
        $sumRejected = $srv->getSumVacation($current, VacationRequest::DENIED_STATUS);
        $sumValidate = $srv->getSumVacation($current, VacationRequest::VALIDATE_STATUS);
        if($user instanceof User && $user->getEmployee() instanceof Employee)
        {
            return $this->render(
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

        return $this->render('::admin-base-layout.html.twig');
    }
}
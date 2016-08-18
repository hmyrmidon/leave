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
        return $this->get(DashboardManager::SERVICE_NAME)->performDashboard($user);

        //return $this->render('::admin-base-layout.html.twig');
    }
}
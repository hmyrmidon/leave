<?php

namespace AppBundle\Controller\Admin;
<<<<<<< HEAD:src/AppBundle/Controller/Admin/DashboardController.php

=======
>>>>>>> origin/feature/feat-gestion-conges-employee:src/AppBundle/Controller/admin/DashboardController.php

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
        return $this->render('::admin-base-layout.html.twig');
    }
}
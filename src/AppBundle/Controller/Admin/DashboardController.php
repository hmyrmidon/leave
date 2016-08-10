<?php

namespace AppBundle\Controller\admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @Route("/dashboard")
 * @package AppBundle\Controller\admin
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
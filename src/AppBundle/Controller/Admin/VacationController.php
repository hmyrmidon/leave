<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VacationController
 * @Route("/conge-permission")
 * @package AppBundle\Controller\Admin
 */
class VacationController extends Controller
{
    /**
     * @Route("/", name="app_vacation")
     * @param $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render(':vacation:list.html.twig', array());
    }
}

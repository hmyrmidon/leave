<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class EmployeeController
 * @package AppBundle\Controller\Admin
 * @Route("/employee")
 * 
 */
class EmployeeController extends Controller
{
    /**
     * 
     * @return type
     * @Route("/", name="app_employee")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $employee = $em->getRepository('AppBundle:Employee')->findAll();

        return $this->render('admin/employee/list.html.twig', array(
            'employee' => $employee
        ));
    }

    public function createAction()
    {
        
    }
}

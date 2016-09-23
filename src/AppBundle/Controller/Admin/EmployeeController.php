<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $employees = $em->getRepository('AppBundle:Employee')->findAll();

        return $this->render('admin/employee/list.html.twig', array(
            'employees' => $employees
        ));
    }

    /**
     * 
     * @param Request $request
     * @return type
     * 
     * @Route("/create", name="app_employee_create")
     */
    public function createAction(Request $request)
    {
        $em       = $this->getDoctrine()->getManager();
        $employee = new \AppBundle\Entity\Employee();
        $formData = $request->request->get('employee'); 
        $username = $formData['username'];
        $email    = $formData['email'];
        $password = $formData['password'];
        $role     = $formData['roles'];
        $employeeForm = $this->createForm(\AppBundle\Form\Type\EmployeeType::class, $employee);
        $formHandler = new \AppBundle\Form\Handler\BaseHandler($employeeForm, $request, $em);
        if ($formHandler->process()) {
            $ogcEmployeeManager = $this->get(\AppBundle\Manager\EmployeeManager::EMPLOYEE_MANAGER);
            $ogcEmployeeManager->save($employee);
            $ogcEmployeeManager->flushAndClear();
            $ogcEmployeeManager->addUser($employee, $username, $email, $password, $role); 

            $message = $this->get('translator')->trans('message.success.add.employee', array(), 'messages');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_employee');
        }

        return $this->render('admin/employee/create.html.twig', array(
            'form'   => $employeeForm->createView()
        ));
    }

    /**
     * 
     * @param Request $request
     * @param \AppBundle\Entity\Employee $employee
     * @return type
     * 
     * @Route("/edit/{id}", name="app_employee_edit")
     */
    public function editAction(Request $request, \AppBundle\Entity\Employee $employee)
    {
        $em           = $this->getDoctrine()->getManager();
        $employeeForm = $this->createForm(\AppBundle\Form\Type\EmployeeType::class, $employee);
        $formHandler  = new \AppBundle\Form\Handler\BaseHandler($employeeForm, $request, $em);
        if ($formHandler->process()) {
            $ogcEmployeeManager = $this->get(\AppBundle\Manager\EmployeeManager::EMPLOYEE_MANAGER);
            $ogcEmployeeManager->save($employee);
            $ogcEmployeeManager->flushAndClear();
            $ogcEmployeeManager->editUser($employee);

            $message = $this->get('translator')->trans('message.success.update.employee', array(), 'messages');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_employee');
        }

        return $this->render('admin/employee/edit.html.twig', array(
            'form'     => $employeeForm->createView(),
            'employee' => $employee
        ));
    }

    /**
     * 
     * @param \AppBundle\Entity\Employee $employee
     * @return type
     * 
     * @Route("/delete/{id}", name="app_employee_delete")
     */
    public function deleteAction(\AppBundle\Entity\Employee $employee)
    {
        $ogcEmployeeManager = $this->get(\AppBundle\Manager\EmployeeManager::EMPLOYEE_MANAGER);
        $ogcEmployeeManager->delete($employee);

        $flashMessage = $this->get('translator')->trans('message.success.delete.employee', array(), 'messages');
        $this->addFlash('success', $flashMessage);

        return $this->redirect($this->generateUrl('app_employee'));
    }
}

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
        $employeeForm = $this->createForm(\AppBundle\Form\Type\EmployeeType::class, $employee);
        $formHandler = new \AppBundle\Form\Handler\BaseHandler($employeeForm, $request, $em);
        if ($formHandler->process()) {
            $ogcEmployeeManager = $this->get(\AppBundle\Manager\EmployeeManager::EMPLOYEE_MANAGER);
            $ogcEmployeeManager->save($employee);
            $ogcEmployeeManager->flushAndClear();
            $ogcEmployeeManager->addUSer($employee, $username, $email, $password);

            $message = $this->get('translator')->trans('message.success.addEmployee', array(), 'messages');
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
        $em       = $this->getDoctrine()->getManager();
        $user     = $employee->getUser();
        $username = $user->getUsername();
        $email    = $user->getEmail();
        $password = $user->getPassword();
        $employeeForm = $this->createForm(\AppBundle\Form\Type\EmployeeType::class, $employee);
        $formHandler = new \AppBundle\Form\Handler\BaseHandler($employeeForm, $request, $em);
        if ($formHandler->process()) {
            $ogcEmployeeManager = $this->get(\AppBundle\Manager\EmployeeManager::EMPLOYEE_MANAGER);
            $ogcEmployeeManager->save($employee);
            $ogcEmployeeManager->flushAndClear();

            $param = new \stdClass();
                    $param->username = $username;
                    $param->email    = $email;
                    $param->password = crypt($password);
                    $param->employee = $employee;
            $event = new \AppBundle\Event\VacationEmployeeEvent($param);
            $this->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_PROCESS_USER, $event, $user);

            $message = $this->get('translator')->trans('message.success.updateEmployee', array(), 'messages');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_employee');
        }

        return $this->render('admin/employee/edit.html.twig', array(
            'form'   => $employeeForm->createView(),
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

        $flashMessage = $this->get('translator')->trans('message.success.deleteEmployee', array(), 'messages');
        $this->addFlash('success', $flashMessage);

        return $this->redirect($this->generateUrl('app_employee'));
    }
}

<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Employee;
use AppBundle\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class EmployeeManager extends BaseManager
{
    const EMPLOYEE_MANAGER = 'app.employee_manager';

    private $eventDispatcher;

    /**
     * 
     * @param \AppBundle\Manager\EntityManagerInterface $entityManager
     * @param \AppBundle\Manager\Router $router
     */
    public function __construct(EntityManagerInterface $entityManager, Router $router, $eventDispatcher) 
    {
        parent::__construct($entityManager, $router);
        $this->eventDispatcher = $eventDispatcher;
    }

    public function addEmployee($lastName, $hDate, $regNumber, $mStatus, $address, $firstName = null)
    {
        $employee     = new \AppBundle\Entity\Employee();

        $hiringDate = new \DateTime($hDate); 
        $employee->setLastName($lastName);
        $employee->setFirstName($firstName);
        $employee->setRegistrationNumber($regNumber);
        $employee->setHiringDate($hiringDate);
        $employee->setMaritalStatus($mStatus);
        $employee->setAddress($address);

        $this->save($employee);
        $this->flushAndClear();
        

        return $employee;
    }

     public function editEmployee (\AppBundle\Entity\Employee $employee, $lastName, $hDate, $regNumber, $mStatus, $address, $firstName = null)
    {
        $hiringDate = new \DateTime($hDate); 
        $employee->setLastName($lastName);
        $employee->setFirstName($firstName);
        $employee->setRegistrationNumber($regNumber);
        $employee->setHiringDate($hiringDate);
        $employee->setMaritalStatus($mStatus);
        $employee->setAddress($address);

        $this->save($employee);
        $this->flushAndClear();

        return $employee;
    }

    public function addUser(\AppBundle\Entity\Employee $employee, $username, $email, $pass, $role)
    {
        $param = new \stdClass();
            $param->username = $username;
            $param->email    = $email;
            $param->password = crypt($pass);
            $param->roles     = ($role);
            $param->employee = $employee;

        $event = new \AppBundle\Event\VacationEmployeeEvent($param); 
        $this->eventDispatcher->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_PROCESS_USER, $event);
    }

    public function editUser(\AppBundle\Entity\Employee $employee)
    {
        $param = new \stdClass();
            $param->employee = $employee;

        $event = new \AppBundle\Event\VacationEmployeeEvent($param); 
        $this->eventDispatcher->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_UPDATE_USER, $event);
    }

    public function addMonthlyVacationRight($number)
    {
        $employees = $this->entityManager->getRepository('AppBundle:Employee')->findAll();
        /**
         * @var Employee $employee
         */
        foreach ($employees as $employee){
            $oldBalance = $employee->getBalance();
            $employee->setBalance($oldBalance + floatval($number));
            $this->entityManager->persist($employee);
        }

        $this->flushAndClear();
    }
}

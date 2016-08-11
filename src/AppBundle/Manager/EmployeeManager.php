<?php

namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EmployeeManager extends BaseManager
{
    const EMPLOYEE_MANAGER = 'app.employee_manager';

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

    public function addUser(\AppBundle\Entity\Employee $employee, $username, $email, $pass)
    {
        $dispatcher = new EventDispatcher();
        $param = new \stdClass();
            $param->username = $username;
            $param->email    = $email;
            $param->password = crypt($pass);
            $param->employee = $employee;

        $event = new \AppBundle\Event\VacationEmployeeEvent($param);
        $dispatcher->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_PROCESS_USER, $event);
    }

}

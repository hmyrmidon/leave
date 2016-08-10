<?php

namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;

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

}

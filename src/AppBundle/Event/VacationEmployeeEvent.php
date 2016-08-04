<?php

namespace AppBundle\Event;

class VacationEmployeeEvent extends \Symfony\Component\EventDispatcher\Event
{
    const VACATION_EMPLOYEE_EVENT_NAME = 'app.on_user_process';

    private $employee;

    public function __construct(\AppBundle\Entity\Employee $employee)
    {
        $this->employee = $employee;
    }
    /**
     * 
     * @return \AppBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}

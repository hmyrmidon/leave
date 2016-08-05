<?php

namespace AppBundle\Event;

class VacationEmployeeEvent extends \Symfony\Component\EventDispatcher\Event
{
    const VACATION_EMPLOYEE_EVENT_NAME_PROCESS_USER = 'app.on_user_process';
    const VACATION_EMPLOYEE_EVENT_NAME_UPDATE_USER = 'app.on_user_update';
    const VACATION_EMPLOYEE_EVENT_NAME_REMOVE_USER = 'app.on_user_remove';

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

<?php

namespace AppBundle\Event;

class VacationEmployeeEvent extends \Symfony\Component\EventDispatcher\Event
{
    const VACATION_EMPLOYEE_EVENT_NAME_PROCESS_USER = 'app.on_user_process';
    const VACATION_EMPLOYEE_EVENT_NAME_UPDATE_USER = 'app.on_user_update';
    const VACATION_EMPLOYEE_EVENT_NAME_REMOVE_USER = 'app.on_user_remove';

    private $option;

    public function __construct($option)
    {
        $this->option = $option;
    }
    /**
     * 
     * @return mixed
     */
    public function getOption()
    {
        return $this->option;
    }
}

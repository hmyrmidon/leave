<?php

namespace AppBundle\Manager;

use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\BaseManager;

class CalendarManager extends BaseManager
{
    const SERVICE_NAME = 'app.calendar_manager';
    public function populate($user = null)
    {
        $calendarData = array();
        if(is_null($user)){
            $vacations = $this->entityManager->getRepository('AppBundle:VacationRequest')->findAll();
        } else {
            $vacations = $this->entityManager->getRepository('AppBundle:VacationRequest')->listBy($user);
        }
        foreach($vacations as $vacation){
            $calendar = new \stdClass();
            $calendar->title = sprintf('%s %s (equipe: %s)', $vacation->getEmployee()->getFirstName(), $vacation->getEmployee()->getLastName(), $vacation->getEmployee()->getTeam()->getName());
            $calendar->allDay = true;
            $calendar->start = $vacation->getStartDate()->format('Y-m-d');
            $calendar->end = $vacation->getReturnDate()->format('Y-m-d');
            $calendar->className = ["event", $this->getClassNameByStatus($vacation->getStatus())];

            $calendarData[] = $calendar;
        }

        return json_encode($calendarData);
    }

    public function getClassNameByStatus($status)
    {
        switch ($status){
            case VacationRequest::VALIDATE_STATUS:
                $className = 'validate_event';
                break;
            case VacationRequest::DENIED_STATUS:
                $className = 'denied_event';
                break;
            case VacationRequest::PENDING_STATUS:
                $className = 'pending_event';
                break;
            default:
                $className = '';
                break;
        }

        return $className;
    }
}
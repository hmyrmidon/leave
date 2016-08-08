<?php

namespace AppBundle\Listener;


use AppBundle\Entity\VacationRequest;
use AppBundle\Event\OnSubmitVacationRequestEvent;
use Doctrine\ORM\EntityManager;

class VacationListener
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onWaiting(){}
    public function onValidate($event){
        //mail to employee
    }
    public function onDenied(){}
    public function onUserCreated(){}
    public function onUserUpdates(){}
    public function onStatusChanged(){}
    public function onSubmitRequest(OnSubmitVacationRequestEvent $event)
    {
        /**
         * @var VacationRequest $vacation
         */
        $vacation = $event->getVacation();
        dump('email send to '.$vacation->getValidator());
    }
}
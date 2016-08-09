<?php

namespace AppBundle\Listener;


use AppBundle\Entity\VacationRequest;
use AppBundle\Entity\VacationValidation;
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
        /**
         * @var VacationRequest $vacation
         */
        $vacation = $event->getVacation();
        $team = $vacation->getEmployee()->getTeam();
        $teamResult = $this->entityManager->getRepository('AppBundle:TeamValidator')->findBy(array('team'=>$team));
        $vacationValidate = $this->entityManager->getRepository('AppBundle:VacationValidation')->findBy(array(
            'vacation' => $vacation
        ));
        $status = VacationRequest::PENDING_STATUS;
        if(count($teamResult) == count($vacationValidate)) {
            $status = VacationRequest::VALIDATE_STATUS;
        }
        $vacation->setStatus($status);
        $this->entityManager->persist($vacation);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
    public function onDenied(){}
    public function onUserCreated(){}
    public function onUserUpdates(){}
    public function onStatusChanged(){}
    public function onSubmitRequest(OnSubmitVacationRequestEvent $event)
    {
        $vacation = $event->getVacation();
        $validator = $this->entityManager->createQuery('
            SELECT e, u FROM AppBundle:Employee e 
            JOIN e.team t
            JOIN AppBundle:TeamValidator v
            JOIN e.user u
            WHERE e.id = :id
        ')->setParameters(array('id'=>$vacation->getEmployee()));
        dump('email send to '. $validator->getEmail());
    }
}
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

    /**
     *
     * @var MailerManager $mailerManager
     */
    private $mailerManager;

    public function __construct(EntityManager $entityManager, \AppBundle\Manager\MailerManager $mailerManager)
    {
        $this->entityManager = $entityManager;
        $this->mailerManager = $mailerManager;
    }

    public function onWaiting(){}

    /**
     * Event listner on validated vacation
     * @param $event
     */
    public function onValidate($event){
        /**
         * @var VacationRequest $vacation
         */
        $vacation         = $event->getVacation();
        $team             = $vacation->getEmployee()->getTeam();
        $user             = $vacation->getEmployee()->getUser();
        $pass             = $user->getPlainPassword();
        $subjectMail      = 'Email de validation de congé';
        $templateMail     = 'admin/emails/emailValidateRequest.html.twig';
        $teamResult       = $this->entityManager->getRepository('AppBundle:TeamValidator')->findBy(array('team'=>$team));
        $vacationValidate = $this->entityManager->getRepository('AppBundle:VacationValidation')->findBy(array(
            'vacation'    => $vacation
        ));
        $status = VacationRequest::PENDING_STATUS;
        if(count($teamResult) == count($vacationValidate)) {
            $status = VacationRequest::VALIDATE_STATUS;
        }
        $vacation->setStatus($status);
        $this->entityManager->persist($vacation);
        $this->mailerManager->sendEmail($user, $pass, $subjectMail, $templateMail);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    /**
     * 
     * @param \AppBundle\Entity\User $user
     */
    public function sendMailOnValidateVacationRequest(\AppBundle\Entity\User $user)
    {
        $from     = self::FROM;
        $to       = $user->getEmail();
        $subject  = 'email de validation de congée';
        $template = 'admin/emails/emailValidateRequest.html.twig';
        $body     = array(
            'name'      => $user->getUsername()
        );
        $this->mailerManager->sendMessage($from, $to, $subject, $template, $body);
    }

    public function onDenied(){}
    public function onUserCreated(){}
    public function onUserUpdates(){}
    public function onStatusChanged(){}

    /**
     * Event listener on vacation request is submited
     * @param OnSubmitVacationRequestEvent $event
     */
    public function onSubmitRequest(OnSubmitVacationRequestEvent $event)
    {
        $vacation = $event->getVacation();
        $validator = $this->entityManager->getRepository('AppBundle:TeamValidator')->getByEmployee($vacation->getEmployee());
        //dump('email send to '. $validator->getEmail());
    }
}
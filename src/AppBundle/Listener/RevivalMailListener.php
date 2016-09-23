<?php

namespace AppBundle\Listener;

use AppBundle\Entity\VacationRequest;
use Doctrine\ORM\EntityManagerInterface;

class RevivalMailListener 
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     *
     * @var MailerManager $mailerManager
     */
    private $mailerManager;

    public function __construct(EntityManagerInterface $entityManager, \AppBundle\Manager\MailerManager $mailerManager)
    {
        $this->entityManager = $entityManager;
        $this->mailerManager = $mailerManager;
    }

    public function onRevivalSendEmail($event)
    {
        /**
         * @var VacationRequest $vacation
         */
        $vacation       = $event->getVacation();
        $employee       = $vacation->getEmployee();
        $subjectMail    = 'Email de relance pour les congées encore en attente.';
        $templateMail   = 'admin/emails/emailRevival.html.twig';
        $validators     = $this->entityManager->getRepository('AppBundle:TeamValidator')->getByEmployee($employee);
        $fromMail       = 'employee@bocasay.fr';
        $this->mailerManager->sendMultipleEmailToValidator($subjectMail, $templateMail, $validators, $fromMail);
    }
    
    
}

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
        $user           = $vacation->getEmployee()->getUser();
        $pass           = $user->getPlainPassword();
        $subjectMail    = 'Email de relance pour les congées encore en attente.';
        $templateMail   = 'admin/emails/emailRevival.html.twig';
        $sendMail       = $user->getEmail();
        $fromMail       = 'koloinarov@gmail.com';
        $revivalDay     = $this->entityManager->getRepository('AppBundle:VacationRequest')->getRevivalDayByStatus($vacation->getId());
        if ($revivalDay == NULL) {
            //do nothing
        } else { 
            $this->mailerManager->sendEmail($user, $pass, $subjectMail, $templateMail, $sendMail, $fromMail);
        }
    }
}

<?php

namespace AppBundle\Listener;
use Doctrine\ORM\EntityManagerInterface;

class VacationEmployeeListener 
{
    protected $entityManager;

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

    public function onCreateEmployee(\AppBundle\Event\VacationEmployeeEvent $event)
    {
        /**
         * @var AppBundle\Entity\Employee $employee
         */
        $eventOpt  = $event->getOption();
        $employee  = $eventOpt->employee;
        $lastName  = $employee->getLastName();
        $firstName = $employee->getFirstName();

        $username  = $eventOpt->username;
        $email     = $eventOpt->email;
        $password  = $eventOpt->password;
        $role      = $eventOpt->roles; 

        $user = new \AppBundle\Entity\User(); 
        $user->setUsername($username);
        $user->setEmail($email);
        $pass = $user->setPassword($password);
        if ($role === "ROLE_ADMIN") {
            $user->setRoles(['ROLE_ADMIN']);
        } elseif ($role === "ROLE_CLIENT") {
            $user->setRoles(['ROLE_CLIENT']);
        } else {
            $user->setRoles(['ROLE_VALIDATEUR']);
        }
        $user->setLastName($lastName);
        $user->setFirstName($firstName);
        $user->setEnabled(1);
        $subjectMail      = 'Email de première connexion';
        $templatingMail   = 'admin/emails/emailCreateUser.html.twig';
        $sendMail         = $user->getEmail();
        $fromMail         = 'contact@bocasay.fr';
        $this->entityManager->persist($user);
        $employee->setUser($user);
        $this->mailerManager->sendEmail($user, $pass, $subjectMail, $templatingMail, $sendMail, $fromMail);
        if ($role === "ROLE_VALIDATEUR") {
            $validator = new \AppBundle\Entity\TeamValidator();
            $validator->setValidator($employee->getUser());
            $validator->setTeam($employee->getTeam());
            $this->entityManager->persist($validator);
        }
        $this->entityManager->flush();

    }

    public function onUpdateEmployee (\AppBundle\Event\VacationEmployeeEvent $event)
    {
        // dump('test');die;
        /**
         * @var AppBundle\Entity\Employee $employee
         */
        $eventOpt = $event->getOption();
        $employee  = $eventOpt->employee;
;
        $lastName  = $employee->getLastName();
        $firstName = $employee->getFirstName();

        $user = $employee->getUser();

        $user->setLastName($lastName);
        $user->setFirstName($firstName);
        $user->setEnabled(1);

        $this->entityManager->persist($user);
        $employee->setUser($user);

        $this->entityManager->flush();
    }

    public function onRemoveEmployee (\AppBundle\Event\VacationEmployeeEvent $event)
    {
        /**
         * @var AppBundle\Entity\Employee $employee
         */
        $eventOpt = $event->getOption();
        $employee  = $eventOpt->employee;

        $user = $employee->getUser();
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}

<?php

namespace AppBundle\Listener;
use Doctrine\ORM\EntityManagerInterface;

class VacationEmployeeListener 
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onCreateEmployee(\AppBundle\Event\VacationEmployeeEvent $event)
    {
        /**
         * @var AppBundle\Entity\Employee $employee
         */
        $eventOpt = $event->getOption();
        $employee  = $eventOpt->employee;

        $lastName = $employee->getLastName();
        $firstName = $employee->getFirstName();

        $username  = $eventOpt->username;
        $email     = $eventOpt->email;
        $password  = $eventOpt->password;
        $role      = $eventOpt->roles; 

        $user = new \AppBundle\Entity\User(); 
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
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

        $this->entityManager->persist($user);
        $employee->setUser($user);

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

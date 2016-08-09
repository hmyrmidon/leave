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

        $username  = $eventOpt->username;
        $email     = $eventOpt->email;
        $password  = $eventOpt->password;

        $user = new \AppBundle\Entity\User(); 
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setEnabled(1);

        $this->entityManager->persist($user);
        $employee->setUser($user);

        $this->entityManager->flush();

    }

    public function onUpdateEmployee (\AppBundle\Event\VacationEmployeeEvent $event)
    {
        /**
         * @var AppBundle\Entity\Employee $employee
         */
        $eventOpt = $event->getOption();
        $employee  = $eventOpt->employee;

        $username  = $employee->getUsername();
        $email     = $employee->getEmail();
        $password  = $employee->getPassword();

        $user = $employee->getUser();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $employee->setUser($user);

        $this->entityManager->flush();
    }

//    public function onRemoveEmployee (\AppBundle\Event\VacationEmployeeEvent $event)
//    {
//        /**
//         * @var AppBundle\Entity\Employee $employee
//         */
//        $employee = $event->getEmployee();
//
//        $user = $employee->getUser();
//        $this->entityManager->remove($user);
//        $this->entityManager->flush();
//    }
}

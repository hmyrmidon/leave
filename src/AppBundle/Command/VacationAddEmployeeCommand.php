<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Manager\EmployeeManager;

class VacationAddEmployeeCommand extends Command
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:create-employee')
                ->setDescription('Create new employee.')
                ->setHelp("This command allows you to create an employee.")
                ->addArgument("username", InputArgument::REQUIRED, 'The username of the employee.')
                ->addArgument("email", InputArgument::REQUIRED, 'The email of the employee.')
                ->addArgument("password", InputArgument::REQUIRED, 'The password of the employee.')
                ->addArgument("lastname", InputArgument::REQUIRED, 'The lastname of the employee.')
                ->addArgument("firstname", InputArgument::REQUIRED, 'The firstname of the employee.')
                ->addArgument("registrationNumber", InputArgument::REQUIRED, 'The number of registration of the employee.')
                ->addArgument("hiringDate", InputArgument::REQUIRED, 'The hiring date of the employee.')
                ->addArgument("maritalStatus", InputArgument::REQUIRED, 'The marital status of the employee.')
                ->addArgument("address", InputArgument::REQUIRED, 'The address of the employee.')
        ;
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userEmployee = $this->getContainer()->get(EmployeeManager::EMPLOYEE_MANAGER);
        $employee     = new \AppBundle\Entity\Employee();

        $hiringDate = new \DateTime($input->getArgument('hiringDate')); 
        $password   = crypt($input->getArgument('password'));

        $employee->setUsername($input->getArgument('username'));
        $employee->setEmail($input->getArgument('email'));
        $employee->setPassword($password);
        $employee->setLastName($input->getArgument('lastname'));
        $employee->setFirstName($input->getArgument('firstname'));
        $employee->setRegistrationNumber($input->getArgument('registrationNumber'));
        $employee->setHiringDate($hiringDate);
        $employee->setMaritalStatus($input->getArgument('maritalStatus'));
        $employee->setAddress($input->getArgument('address'));
        $userEmployee->add($employee);

        $event = new \AppBundle\Event\VacationEmployeeEvent($employee);
        $this->getContainer()->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME, $event);

        $output->writeln('User successfully generated!', $employee->getUsername());
    }
}

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
        $employee = new \AppBundle\Entity\Employee();

        $hiringDate = new \DateTime($input->getArgument('hiringDate')); 
        $password = md5($input->getArgument('password'), 'salt');

        $employee->setUsername($input->getArgument('username'));
        $employee->setEmail($input->getArgument('email'));
        $employee->setPassword($password);
        $employee->setLastName($input->getArgument('lastname'));
        $employee->setFirstName($input->getArgument('firstname'));
        $employee->setRegistrationNumber($input->getArgument('registrationNumber'));
        $employee->setHiringDate($hiringDate);
        $userEmployee->add($employee);

        $output->writeln('User successfully generated!', $employee->getUsername());
    }

    
}

<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class VacationAddEmployeeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:vacation:employee-create')
            ->setDescription('Create new employee.')
            ->setHelp("This command allows you to create an employee.")
            ->addArgument("username", InputArgument::REQUIRED)
            ->addArgument("password", InputArgument::REQUIRED)
            ->addArgument("email", InputArgument::REQUIRED)
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
        $userEmployee = $this->getContainer()->get(\AppBundle\Manager\EmployeeManager::EMPLOYEE_MANAGER);
        $employee     = new \AppBundle\Entity\Employee();

        $hiringDate = new \DateTime($input->getArgument('hiringDate')); 
        $employee->setLastName($input->getArgument('lastname'));
        $employee->setFirstName($input->getArgument('firstname'));
        $employee->setRegistrationNumber($input->getArgument('registrationNumber'));
        $employee->setHiringDate($hiringDate);
        $employee->setMaritalStatus($input->getArgument('maritalStatus'));
        $employee->setAddress($input->getArgument('address'));

        $userEmployee->add($employee);

        $param = new \stdClass();
            $param->username = $input->getArgument('username');
            $param->email    = $input->getArgument('email');
            $param->password = $input->getArgument('password');
            $param->employee = $employee;

        $event = new \AppBundle\Event\VacationEmployeeEvent($param);
        $this->getContainer()->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_PROCESS_USER, $event);

        $output->writeln('Employee successfully created!');
    }
}

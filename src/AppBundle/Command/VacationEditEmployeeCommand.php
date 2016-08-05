<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Manager\EmployeeManager;

class VacationEditEmployeeCommand extends Command
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:update-employee')
                ->setDescription('Update an employee.')
                ->setHelp("This command allows you to update an employee.")
                ->addOption("id", null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
                ->addArgument("lastname", InputArgument::REQUIRED, 'The lastname of the employee.')
                ->addArgument("firstname", InputArgument::REQUIRED, 'The firstname of the employee.')
                ->addArgument("registrationNumber", InputArgument::REQUIRED, 'The number of registration of the employee.')
                ->addArgument("hiringDate", InputArgument::REQUIRED, 'The hiring date of the employee.')
                ->addArgument("maritalStatus", InputArgument::REQUIRED, 'The marital status of the employee.')
                ->addArgument("address", InputArgument::REQUIRED, 'The address of the employee.')
        ;
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $userEmployee = $this->getContainer()->get(EmployeeManager::EMPLOYEE_MANAGER);
        $idEmployee = $input->getOption("id");
        $employeeEdit = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Employee')->find($idEmployee);

        $hiringDate = new \DateTime($input->getArgument('hiringDate')); 
       
        $user = $employeeEdit->getUser();


        $employeeEdit->setLastName($input->getArgument('lastname'));
        $employeeEdit->setFirstName($input->getArgument('firstname'));
        $employeeEdit->setRegistrationNumber($input->getArgument('registrationNumber'));
        $employeeEdit->setHiringDate($hiringDate);
        $employeeEdit->setMaritalStatus($input->getArgument('maritalStatus'));
        $employeeEdit->setAddress($input->getArgument('address'));
        $userEmployee->edit($employeeEdit);

        $event = new \AppBundle\Event\VacationEmployeeEvent($employeeEdit);
        $this->getContainer()->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_UPDATE_USER, $event,$user);

        $output->writeln('Employee successfully updated!');
    }
}

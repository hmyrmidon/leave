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
                ->setName('app:vacation:employee-create')
                ->setDescription('Create new employee.')
                ->setHelp("This command allows you to create an employee.")
                ->addArgument("lastname", InputArgument::REQUIRED, 'The lastname of the employee.')
                ->addArgument("firstname", InputArgument::REQUIRED, 'The firstname of the employee.')
                ->addArgument("registrationNumber", InputArgument::REQUIRED, 'The number of registration of the employee.')
                ->addArgument("hiringDate", InputArgument::REQUIRED, 'The hiring date of the employee.')
                ->addArgument("maritalStatus", InputArgument::REQUIRED, 'The marital status of the employee.')
                ->addArgument("address", InputArgument::REQUIRED, 'The address of the employee.')
//                  ->addOption('create', 'create', \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED | \Symfony\Component\Console\Input\InputOption::VALUE_IS_ARRAY)
//                  ->addOption('update', 'update', \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED | \Symfony\Component\Console\Input\InputOption::VALUE_IS_ARRAY)
//                  ->addOption('id', 'id', \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
        ;
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userEmployee = $this->getContainer()->get(\AppBundle\Manager\BaseManager::EMPLOYEE_MANAGER);
        $employee     = new \AppBundle\Entity\Employee();

        $hiringDate = new \DateTime($input->getArgument('hiringDate')); 
        $employee->setLastName($input->getArgument('lastname'));
        $employee->setFirstName($input->getArgument('firstname'));
        $employee->setRegistrationNumber($input->getArgument('registrationNumber'));
        $employee->setHiringDate($hiringDate);
        $employee->setMaritalStatus($input->getArgument('maritalStatus'));
        $employee->setAddress($input->getArgument('address'));
        
//        if ($input->getOption('create')) {
//            $employee     = new \AppBundle\Entity\Employee();
//            $hiringDate = \DateTime::createFromFormat( implode("-", $input->getOption('create')), 'Y-m-d')[3]; 
//
//            $employee->setLastName($input->getOption('create')[0]);
//            $employee->setFirstName($input->getOption('create')[1]);
//            $employee->setRegistrationNumber($input->getOption('create')[2]);
//            $employee->setHiringDate($hiringDate);
//            $employee->setMaritalStatus($input->getOption('create')[4]);
//            $employee->setAddress($input->getOption('create')[5]);
//            $userEmployee->add($employee);
//
//            $event = new \AppBundle\Event\VacationEmployeeEvent($employee);
//            $this->getContainer()->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_PROCESS_USER, $event);
//
//            $output->writeln('Employee successfully generated!');
//
//        } elseif ($input->getOption('update')){
//            $idEmployee = $input->getOption("id");
//            $employeeEdit = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Employee')->find($idEmployee);
//            $hiringDate = \DateTime::createFromFormat( implode("-", $input->getOption('create')), 'Y-m-d')[6]; 
//            $password   = crypt(implode("-", $input->getOption('create')))[3];
//            $user = $employeeEdit->getUser();
//
//            $employeeEdit->setUsername($input->getOption('create')[2]);
//            $employeeEdit->setEmail($input->getOption('create')[3]);
//            $employeeEdit->setPassword($password);
//            $employeeEdit->setLastName($input->getOption('create')[5]);
//            $employeeEdit->setFirstName($input->getOption('create')[]);
//            $employeeEdit->setRegistrationNumber($input->getOption('create')[5]);
//            $employeeEdit->setHiringDate($hiringDate);
//            $employeeEdit->setMaritalStatus($input->getOption('create')[7]);
//            $employeeEdit->setAddress($input->getOption('create')[8]);
//            $userEmployee->edit($userEmployee);
//
//            $event = new \AppBundle\Event\VacationEmployeeEvent($employeeEdit);
//            $this->getContainer()->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_UPDATE_USER, $event,$user);
//
//            $output->writeln('Employee successfully updated!');
//        }
            $userEmployee->edit($userEmployee);
        
            $event = new \AppBundle\Event\VacationEmployeeEvent($employee);
            $this->getContainer()->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_UPDATE_USER, $event);

            $output->writeln('Employee successfully updated!');
    }
}

<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Manager\EmployeeManager;

class VacationDeleteEmployeeCommand extends Command
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:remove-employee')
                ->setDescription('Delete an employee.')
                ->setHelp("This command allows you to delete an employee.")
                ->addOption("id", null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $userEmployee = $this->getContainer()->get(EmployeeManager::EMPLOYEE_MANAGER);
        $idEmployee = $input->getOption("id");
        $employeeDelete = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Employee')->find($idEmployee);

        $user = $employeeDelete->getUser();

        $userEmployee->delete($employeeDelete);

        $event = new \AppBundle\Event\VacationEmployeeEvent($employeeDelete);
        $this->getContainer()->get('event_dispatcher')->dispatch(\AppBundle\Event\VacationEmployeeEvent::VACATION_EMPLOYEE_EVENT_NAME_REMOVE_USER, $event,$user);

        $output->writeln('Employee successfully removed!');
    }
}

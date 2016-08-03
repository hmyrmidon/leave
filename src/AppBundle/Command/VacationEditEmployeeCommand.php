<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Manager\EmployeeManager;

class VacationEditEmployeeCommand 
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:update-employee')
                ->setDescription('Update an employee.')
                ->setHelp("This command allows you to update an employee.")
                ->addArgument("username", InputArgument::REQUIRED, 'The username of the employee.')
                ->addArgument("email", InputArgument::REQUIRED, 'The email of the employee.')
                ->addArgument("password", InputArgument::REQUIRED, 'The password of the employee.')
                ->addArgument("lastname", InputArgument::REQUIRED, 'The lastname of the employee.')
                ->addArgument("firstname", InputArgument::REQUIRED, 'The firstname of the employee.')
                ->addArgument("registrationNumber", InputArgument::REQUIRED, 'The number of registration of the employee.')
                ->addArgument("hiringDate", InputArgument::REQUIRED, 'The hiring date of the employee.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $userEmployee = $this->getContainer()->get(EmployeeManager::EMPLOYEE_MANAGER);
        $employee = 
    }
}

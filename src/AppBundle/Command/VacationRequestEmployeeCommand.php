<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class VacationRequestEmployeeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:vacation:request-employee')
            ->setDescription('Create new vacation request.')
            ->setHelp("This command allows you to create a new vacation request.")
            ->addArgument('startDate', InputArgument::REQUIRED, 'The start date of the vacation request')
            ->addArgument('endDate', InputArgument::REQUIRED, 'The end date of the vacation request')
       ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        $vacationRequestEmployee = $this->getContainer()->get(\AppBundle\Manager\VacationRequestManager::SERVICE_NAME);
        
    }
}

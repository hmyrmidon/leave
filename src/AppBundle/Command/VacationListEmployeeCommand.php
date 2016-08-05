<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationListEmployeeCommand extends Command
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:list-employee')
                ->setDescription('list all employee.')
                ->setHelp("This command allows you to list all employee.")
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var \Employee
         */
        $employeeList = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Employee')->findAll();

        $output->writeln($employeeList);
    }
}

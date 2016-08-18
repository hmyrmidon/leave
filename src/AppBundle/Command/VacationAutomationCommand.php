<?php

namespace AppBundle\Command;


use AppBundle\Manager\EmployeeManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class VacationAutomationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:vacation:automation')
            ->addOption('user', 'u', InputOption::VALUE_REQUIRED)
            ->addOption('addMonthly', 'a', InputOption::VALUE_NONE)
            ->setDescription('Automatisation du nombre de congé');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if($input->getOption('addMonthly')){
            $this->addVacationRightMonthly();
        }
    }

    private function addVacationRightMonthly()
    {
        $number = $this->getContainer()->getParameter('monthly_added');
        $this->getContainer()->get(EmployeeManager::EMPLOYEE_MANAGER)->addMonthlyVacationRight($number);
    }
}
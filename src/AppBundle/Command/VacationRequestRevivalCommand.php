<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationRequestRevivalCommand extends Command
{
    protected function configure() 
    {
        $this
            ->setName('app:vacation:request-revival')
            ->setDescription('Check if there is a vacation request who does not validate on 48 hours.')
            ->setHelp("This command helps you to check if there are a vacation request not validate on 48 hours.")
            ->addOption("id", null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        /**
         * @var VacationRequestRevivalManager $revival
         */
        $revival  = $this->getContainer()->get(\AppBundle\Manager\VacationRequestRevivalManager::VACATION_REVIVAL_MANAGER);
        $idVacationR = $input->getOption('id');
        $vacation = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:VacationRequest')->find($idVacationR);
        $revival->revivalDate($vacation);
        $output->writeln('Date de relance ok');
    }
}

<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationRequestRevivalCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure() 
    {
        $this
            ->setName('app:vacation:request-revival')
            ->setDescription('Check if there is a vacation request who does not validate on 48 hours.')
            ->setHelp("This command helps you to check if there are a vacation request not validate on 48 hours.")
            //->addOption("id", null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        ini_set('max_execution_time', 36000);
        /**
         * @var VacationRequestRevivalManager $revival
         */
        $revival = $this->getContainer()
                        ->get(\AppBundle\Manager\VacationRequestRevivalManager::VACATION_REVIVAL_MANAGER);
        $revival->revivalDate();
        $output->writeln('Date de relance ok');
    }
}

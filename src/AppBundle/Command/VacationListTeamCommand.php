<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class VacationListTeamCommand extends Command 
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:list-team')
                ->setDescription('list all team.')
                ->setHelp("This command allows you to list all team.")
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
         * @var \Team
         */
        $teamList = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Team')->findAll(); dump($teamList);

        $output->writeln($teamList);
    }
}


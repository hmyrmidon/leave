<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class VacationAddTeamCommand extends Command
{
    protected function configure() 
    {
        $this
             ->setName('app:vacation:create-team')
             ->setDescription('Create a new team')
             ->setHelp('This command allows you to creat a team.')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the team')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        $team = $this->getContainer()->get(\AppBundle\Manager\TeamManager::TEAM_MANAGER);
        $newTeam = new \AppBundle\Entity\Team();

        $newTeam->setName($input->getArgument('name'));

        $team->add($newTeam);

        $output->writeln('team successfully generated!');
    }
}

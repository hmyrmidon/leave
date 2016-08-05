<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationTeamCommand extends Command
{
    protected function configure() 
    {
        $this
             ->setName('app:vacation:team')
             ->setDescription('Create a new team')
             ->setHelp('This command allows you to creat a team.')
             ->addOption('id', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
             ->addOption('create', 'create', \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
             ->addOption('update', 'update', \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        $team = $this->getContainer()->get(\AppBundle\Manager\TeamManager::TEAM_MANAGER);
        

        if ($input->getOption('create')) {
            $newTeam = new \AppBundle\Entity\Team();
            $newTeam->setName($input->getOption('create'));

            $team->add($newTeam);
            $output->writeln('team successfully generated!');

        } elseif ($input->getOption('update')) {
            $idTeam = $input->getOption("id");
            $teamEdit = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Team')->find($idTeam);
            $teamEdit->setName($input->getOption('update'));

            $team->edit($teamEdit);
            $output->writeln('team successfully updated!');

        } else {
            $idTeam = $input->getOption("id");
            $teamDelete = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Team')->find($idTeam);

            $team->delete($teamDelete);
            $output->writeln('team successfully removed!');
        }
    }
}

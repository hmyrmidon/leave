<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationDeleteUserCommand extends Command
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:remove-user')
                ->setDescription('Delete an user.')
                ->setHelp("This command allows you to delete an user.")
                ->addOption("id", null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $user = $this->getContainer()->get(\AppBundle\Manager\UserManager::USER_MANAGER);
        $idUser = $input->getOption("id");
        $userDelete = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:User')->find($idUser);

        $user->delete($userDelete);

        $output->writeln('User successfully removed!');
    }
}

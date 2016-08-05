<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationListUserCommand extends Command
{
    protected function configure()
    {
        $this
                ->setName('app:vacation:list-user')
                ->setDescription('list all user.')
                ->setHelp("This command allows you to list all user.")
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
         * @var \User
         */
        $userList = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:User')->findAll();

        $output->writeln($userList);
    }
}

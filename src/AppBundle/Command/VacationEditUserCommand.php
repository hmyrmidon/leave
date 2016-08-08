<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class VacationEditUserCommand extends Command
{
    protected function configure() 
    {
        $this
             ->setName('app:vacation:update-user')
             ->setDescription('Update an user')
             ->setHelp('This command allows you to update an user.')
             ->addOption("id", null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED)
             ->addArgument("username", InputArgument::REQUIRED, 'The username of the user.')
             ->addArgument("email", InputArgument::REQUIRED, 'The email of the user.')
             ->addArgument("password", InputArgument::REQUIRED, 'The password of the user.')
             ->addArgument("lastname", InputArgument::REQUIRED, 'The lastname of the user.')
             ->addArgument("firstname", InputArgument::REQUIRED, 'The firstname of the user.')
        ;
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) 
    {
        $user = $this->getContainer()->get(\AppBundle\Manager\UserManager::USER_MANAGER);
        $idUser = $input->getOption("id");
        $userEdit = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:User')->find($idUser);

        $userEdit->setUsername($input->getArgument('username'));
        $userEdit->setEmail($input->getArgument('email'));
        $userEdit->setPassword($input->getArgument('password'));
        $userEdit->setLastName($input->getArgument('lastname'));
        $userEdit->setFirstName($input->getArgument('firstname'));

        $user->save($userEdit);

        $output->writeln('User successfully updated!');

    }
}

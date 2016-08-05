<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class VacationAddUserCommand extends Command
{
    protected function configure() 
    {
        $this
             ->setName('app:vacation:create-user')
             ->setDescription('Create a new user')
             ->setHelp('This command allows you to creat an user.')
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
        $newUser = new \AppBundle\Entity\User();

        $newUser->setUsername($input->getArgument('username'));
        $newUser->setEmail($input->getArgument('email'));
        $newUser->setPassword($input->getArgument('password'));
        $newUser->setLastName($input->getArgument('lastname'));
        $newUser->setFirstName($input->getArgument('firstname'));

        $user->add($newUser);

        $output->writeln('User successfully generated!', $newUser->getUsername());

    }
}

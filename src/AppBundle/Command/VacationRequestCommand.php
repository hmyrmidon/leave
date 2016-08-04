<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationRequestCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:vacation:request-command')
            ->addArgument('start', InputArgument::REQUIRED, 'Vacation start date')
            ->addArgument('end', InputArgument::REQUIRED, 'Vacation end date')
            ->addArgument('reason', InputArgument::REQUIRED, 'Vacation reason')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
    }
}

<?php

namespace AppBundle\Command;


use AppBundle\Manager\VacationRequestManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationRequestValidateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:vacation:validate')
            ->addArgument('vacationId', InputArgument::REQUIRED)
            ->addArgument('validator', InputArgument::REQUIRED)
            ->setDescription('Validate vacation request');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = $input->getArguments();
        $vacationId = $params['vacationId'];
        $validator = $params['validator'];
        $this->getContainer()->get(VacationRequestManager::SERVICE_NAME)->validate($vacationId, $validator);

    }

}
<?php

namespace AppBundle\Command;


use AppBundle\Event\OnSubmitVacationRequestEvent;
use AppBundle\Event\OnValidateEvent;
use AppBundle\Event\VacationAvailableEvent;
use AppBundle\Manager\VacationRequestManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationRequestSendCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:vacation:submit')
            ->addArgument('employee', InputArgument::REQUIRED)
            ->addArgument('startDate', InputArgument::REQUIRED)
            ->addArgument('endDate', InputArgument::REQUIRED)
            ->addArgument('reason', InputArgument::OPTIONAL)
            ->setDescription('Submit vacation request');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = $input->getArguments();
        $vacation = $this->getContainer()->get(VacationRequestManager::SERVICE_NAME)->saveVacation($params);

        $event = new OnSubmitVacationRequestEvent($vacation);
        $this->getContainer()->get('event_dispatcher')->dispatch(VacationAvailableEvent::ON_SUBMIT_VACATION, $event);

    }

}
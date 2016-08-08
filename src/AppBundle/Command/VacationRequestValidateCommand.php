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
        $vacation = $this->getContainer()->get(VacationRequestManager::SERVICE_NAME)->validate($vacationId, $validator);

        $event = new OnSubmitVacationRequestEvent($vacation);
        $this->getContainer()->get('event_dispatcher')->dispatch(VacationAvailableEvent::ON_SUBMIT_VACATION, $event);

        $event = new OnValidateEvent($vacation);
        $this->getContainer()->get('event_dispatcher')->dispatch(VacationAvailableEvent::ON_VALIDATE, $event);
    }

}
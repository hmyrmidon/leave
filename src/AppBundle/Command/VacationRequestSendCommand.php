<?php

namespace AppBundle\Command;


use AppBundle\Entity\VacationRequest;
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
        $employee = $this->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Employee')->find($input->getArgument('employee'));
        $vacation = new VacationRequest();
        $vacation->setCreated(new \DateTime($input->getArgument('startDate')));
        $vacation->setEndDate(new \DateTime($input->getArgument('endDate')));
        $vacation->setReason($input->getArgument('reason'));

        $vacation = $this->getContainer()->get(VacationRequestManager::SERVICE_NAME)->saveVacation($vacation, $employee);

        $event = new OnSubmitVacationRequestEvent($vacation);
        $this->getContainer()->get('event_dispatcher')->dispatch(VacationAvailableEvent::ON_SUBMIT_VACATION, $event);

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 09/08/16
 * Time: 10:25
 */

namespace AppBundle\Command;


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
        $this->setName('app:vacation:validate')
            ->addArgument('vacation', null, InputArgument::REQUIRED)
            ->addArgument('userId', null, InputArgument::REQUIRED)
            ->setDescription('Validate vacation request');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getArgument('userId');
        $vacationId = $input->getArgument('vacation');
        $vacation = $this->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:VacationRequest')->find($vacationId);
        $submitVacation = $this->getContainer()->get(VacationRequestManager::SERVICE_NAME);
        $submitVacation->validate($vacation, $userId);

        $event = new OnValidateEvent($vacation);
        $this->getContainer()->get('event_dispatcher')
            ->dispatch(VacationAvailableEvent::ON_VALIDATE, $event);
    }

}
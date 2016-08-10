<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class VacationAddHolidayCommand extends Command
{
    protected function configure() 
    {
        $this
            ->setName('app:vacation:create-holiday')
            ->setDescription('Create new holiday')
            ->addArgument('date', InputArgument::REQUIRED)
            ->addArgument('frequency', InputArgument::OPTIONAL)
            ->addArgument('label', InputArgument::OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $holiday = $this->getContainer()->get(\AppBundle\Manager\HolidayManager::SERVICE_NAME);
        $date = $input->getArgument('date');
        $frequency = $input->getArgument('frequency');
        $label = $input->getArgument('label');
        $newHoliday = $holiday->addHoliday($date, $frequency, $label);

        $output->writeln('Holiday successfully created!', $newHoliday->getLabel());
    }
}

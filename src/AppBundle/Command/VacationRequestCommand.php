<?php

namespace AppBundle\Command;

use AppBundle\Entity\VacationRequest;
use AppBundle\Event\OnSubmitVacationRequestEvent;
use AppBundle\Event\VacationAvailableEvent;
use AppBundle\Manager\HolidayManager;
use AppBundle\Manager\VacationRequestManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class VacationRequestCommand extends ContainerAwareCommand
{
    /**
     * @var InputInterface $input
     */
    private $input;
    /**
     * @var OutputInterface $output
     */
    private $output;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:vacation:request-command')
            ->addOption('sendRequest', 's', InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY, '', [])
            ->addOption('listVacancies', null, InputOption::VALUE_OPTIONAL)
            ->addOption('validate', null, InputOption::VALUE_OPTIONAL)
            ->addOption('user', 'u', InputOption::VALUE_OPTIONAL)
            ->addOption('add', null, InputOption::VALUE_OPTIONAL)
            ->addOption('addwf', null, InputOption::VALUE_NONE)
            ->addOption('addstep', null, InputOption::VALUE_NONE)
            ->addOption('addstatus', null, InputOption::VALUE_NONE)
            ->addOption('datediff', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, '', [])
            ->addOption('vacancies', 'a', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'vacancies[startDate, days]', [])
            ->setDescription('Perform vacation request');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;
        if ($input->getOption('user')) {
            $user = $input->getOption('user');
            if ($input->getOption('add')) {
                $add = $input->getOption('add');
                if (!is_array($add)) {
                    $add = explode(',', $add);
                }
                array_push($add, $user);
                $this->save($add);
            }
        }
        if ($input->getOption('addwf')) {
            $this->addWorkflow();
        }
        if($input->getOption('datediff')) {
            $dates = $input->getOption('datediff');
            $this->dateDiff($dates[0], $dates[1]);
        }
        if($input->getOption('vacancies')){
            $params = $input->getOption('vacancies');
            $this->getVacanciesRange($params);
        }
    }

    public function save($_vacation)
    {
        $this->output->writeln('load vacation from input');
        $vacation = new VacationRequest();
        $vacation->setStartDate(\DateTime::createFromFormat('Y-m-d', $_vacation[0]));
        $vacation->setEndDate(\DateTime::createFromFormat('Y-m-d', $_vacation[1]));
        $vacation->setReason($_vacation[2]);
        $this->output->writeln('load employee from database');
        $employee = $this->getContainer()
                         ->get('doctrine.orm.entity_manager')
                         ->getRepository('AppBundle:Employee')
                         ->find($_vacation[3]);
        $vacation->setEmployee($employee);
        $this->output->writeln('save vacation request');
        /**
         * @var VacationRequestManager $srv
         */
        $srv = $this->getContainer()->get(VacationRequestManager::SERVICE_NAME);
        $vacation = $srv->save($vacation);
        $event = new OnSubmitVacationRequestEvent($vacation);
        $this->getContainer()->get('event_dispatcher')->dispatch(VacationAvailableEvent::ON_SUBMIT_VACATION, $event);

        $this->output->writeln('vacation request saved!');
        $this->output->writeln(':)');
    }

    public function addWorkflow()
    {
        
    }

    public function dateDiff($date1, $date2)
    {
        $this->output->writeln(sprintf('DateDiff(%s, %s)', $date1, $date2));
        //$begin = new \DateTime($date1);
        //$end = new \DateTime($date2);
        $interval = $this->getContainer()->get(HolidayManager::SERVICE_NAME)->getDayCount($date1, $date2);
        $this->output->writeln($interval);
        $this->output->writeln(':)');
    }

    public function getVacanciesRange($params)
    {
        $range = $this->getContainer()->get(HolidayManager::SERVICE_NAME)->getVacancies($params[0], $params[1], $params[2]);
        dump($range);
    }
    public function validateVacation()
    {
        
    }
}

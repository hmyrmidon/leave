<?php

namespace AppBundle\Command;


use AppBundle\Manager\StatusManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends ContainerAwareCommand
{
    private $input;
    private $output;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:vacation:status')
            ->addOption('add', null, InputOption::VALUE_OPTIONAL)
            ->addOption('delete', null, InputOption::VALUE_OPTIONAL)
            ->setDescription('All status operations');
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        if($input->getOption('add')){
            $this->add($input->getOption('add'));
        }
        if($input->getOption('delete')){
            $this->delete($input->getOption('delete'));
        }
    }

    /**
     * @param string $name
     */
    public function add($name)
    {
        $this->getContainer()->get(StatusManager::SERVICE_NAME)
            ->addNewStatus($name);
    }

    /**
     * @param int $statusId
     */
    public function delete($statusId)
    {
        $status = $this->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Status')->find($statusId);
        $this->getContainer()->get(StatusManager::SERVICE_NAME)
             ->delete($status);
    }

}
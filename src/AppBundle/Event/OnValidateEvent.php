<?php

namespace AppBundle\Event;


use AppBundle\Entity\VacationRequest;
use Symfony\Component\EventDispatcher\Event;

class OnValidateEvent extends Event
{
    /**
     * @var VacationRequest $vacation
     */
    private $vacation;
    public function __construct($option)
    {
        $this->vacation = $option;
    }

    public function getVacation()
    {
        return $this->vacation;
    }
}
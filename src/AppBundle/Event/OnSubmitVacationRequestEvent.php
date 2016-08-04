<?php

namespace AppBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class OnSubmitVacationRequestEvent extends Event
{
    /**
     * @var VacationRequest $vacation
     */
    private $vacation;
    public function __construct($option)
    {
        $this->vacation = $option;
    }

    /**
     * @return VacationRequest
     */
    public function getVacation()
    {
        return $this->vacation;
    }
}
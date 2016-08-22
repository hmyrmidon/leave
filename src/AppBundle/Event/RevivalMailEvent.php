<?php

namespace AppBundle\Event;

use AppBundle\Entity\VacationRequest;
use Symfony\Component\EventDispatcher\Event;

class RevivalMailEvent extends Event
{
    /**
     * @var VacationRequest $vacation
     */
    private $vacation;
    public function __construct($vacation)
    {
        $this->vacation = $vacation;
    }

    public function getVacation()
    {
        return $this->vacation;
    }
}
<?php

namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;

class VacationRequestRevivalManager extends BaseManager
{
    const VACATION_REVIVAL_MANAGER = 'app.vacation_request_revival_manager';

    /**
     * 
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Bundle\FrameworkBundle\Routing\Router $router
     * @param type $eventDispatcher
     */
    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager, \Symfony\Bundle\FrameworkBundle\Routing\Router $router, $eventDispatcher) 
    {
        parent::__construct($entityManager, $router);
        $this->eventDispatcher = $eventDispatcher;
    }
    public function revivalDate(\AppBundle\Entity\VacationRequest $vacation)
    {
        
        $date2          = new \DateTime();
        $dateNewRevival = $date2->format('Y-m-d H:i:s');
        $date1 = $vacation->getRevival();
        $withHoliday = 0;
        $revival     = $this->getDayCount($date1, $dateNewRevival, $withHoliday);
        if ($revival > 0) {
            $event = new \AppBundle\Event\RevivalMailEvent($vacation);
            $this->eventDispatcher->dispatch(\AppBundle\Event\VacationAvailableEvent::REVIVAL_SEND_MAIL, $event);
            $vacation->setRevival($dateNewRevival);
            $this->save($vacation);
            $this->flushAndClear();
        }
    }

    /**
     * @param \DateTime $begin
     * @param \DateTime $end
     *
     * @return string
     */
    public function getDayCount($begin, $end, $withHoliday = false)
    {
        $holiday = 0;
        if ($withHoliday) {
            $holiday = $this->countHolidayBetween(new \DateTime($begin), new \DateTime($end));
        }
        $begin   = strtotime($begin);
        $end     = strtotime($end);
        $diff    = $end - $begin;
        $days    = $this->roundUp((($diff / 3600) / 24) - $holiday, 1);
        return $days;
    }

    public function countHolidayBetween(\DateTime $dateSart, \DateTime $dateEnd)
    {
        $count = 0;
        $range = new \DatePeriod($dateSart, new \DateInterval('P1D'), $dateEnd);
        $test = array();
        foreach ($range as $date) {
            array_push($test, $date->format('Y-m-d'));
            if ($this->isHoliday($date)) {
                $count++;
            }
        }

        return $count;
    }

    public function roundUp($value, $places = 0)
    {
        if ($places < 0) {
            $places = 0;
        }
        if (is_int($value)) {
            return $value;
        }
        $decimals = explode('.', $value);
        if (!isset($decimals[1]) || (strlen($decimals[1]) <= $places)) {
            return $value;
        }
        $powerUp = pow(10, $places);

        return ceil($value * $powerUp) / $powerUp;
    }
}

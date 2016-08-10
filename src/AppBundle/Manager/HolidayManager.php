<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Holiday;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\BaseManager;
use Symfony\Component\Validator\Constraints\DateTime;

class HolidayManager extends BaseManager
{
    /**
     * @var EntityManager $_em
     */
    const SERVICE_NAME = 'app.holiday_manager';

    /**
     * @param int|null $year
     *
     * @return array
     */
    public function listAll($year = null)
    {
        if (is_null($year)) {
            $currentDate = new DateTime();
            $year        = $currentDate->format('Y');
        }
        $currentDate = new \DateTime();
        $currentYear = $currentDate->format('Y');
        /**
         * @var \DateTime $easterDate
         */
        $easterDate = new \DateTime($currentYear . '-03-21');
        $easterDay  = easter_days($easterDate->format('Y'));
        $easterDate->modify('+' . $easterDay . ' day')->format('Y-m-d');

        $holidays = array();
        $list       = $this->entityManager->getRepository('AppBundle:Holiday')->getAvalaibleFromYear($year);
        foreach ($list as $lst) {
            $date = sprintf('%d-%d-%d', $lst->getYear(), $lst->getMonth(), $lst->getDay());
            $date = new \DateTime($date);
            array_push($holidays, $date->format('Y-m-d'));
        }
        array_push($holidays,
            $easterDate->format('Y-m-d'),
            $easterDate->modify('+1 day')->format('Y-m-d'),
            $easterDate->modify('+38 day')->format('Y-m-d'),
            $easterDate->modify('+10 day')->format('Y-m-d'),
            $easterDate->modify('+1 day')->format('Y-m-d')
        );
        sort($holidays);

        return $holidays;
    }

    /**
     * @param \DateTime $date
     * @param string    $modifier
     *
     * @return bool
     */
    public function isHoliday(\DateTime $date)
    {
        $year     = $date->format('Y');
        $holidays = $this->listAll($year);

        return (in_array($date->format('Y-m-d'), $holidays) || in_array($date->format('N'), array(6, 7)));
    }

    /**
     * @param        $dateBegin
     * @param string $dayCount Y for years,M for months, D for days, H for hours, i for minutes,S for seconds
     *
     * @return array
     */
    public function getVacancies($dateBegin, $dayCount = '1')
    {
        $dateBegin    = new \DateTime($dateBegin);
        $dateInterval = new \DateInterval("P{$dayCount}D");
        $dateEnd      = clone $dateBegin;
        $dateEnd->add($dateInterval);
        $DateRange = new \DatePeriod($dateBegin, new \DateInterval('P1D'), $dateEnd);
        foreach ($DateRange as $range) {
            if ($this->isHoliday($range)) {
                $dateEnd->modify('+1 day');
            }
        }

        return $dateEnd;
    }

    /**
     * @param \DateTime $begin
     * @param \DateTime $end
     *
     * @return string
     */
    public function getDayCount($begin, $end)
    {
        $holiday = $this->countHolidayBetween(new \DateTime($begin), new \DateTime($end));
        $begin   = strtotime($begin);
        $end     = strtotime($end);
        $diff    = $end - $begin;
        $days    = $this->roundUp((($diff / 3600) / 24) - $holiday, 1);
        return $days;
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

    public function addHoliday($date, $frequency = 0, $label = '') 
    {
        $holiday = new \AppBundle\Entity\Holiday();

        $date = new \DateTime($date);
        $day = $date->format('d');
        $month = $date->format('m');
        $year = $date->format('Y');

        $holiday->setDay($day);
        $holiday->setMonth($month);
        $holiday->setYear($year);
        $holiday->setFrequency($frequency);
        $holiday->setLabel($label);

        $this->save($holiday);
        $this->flushAndClear();

        return $holiday;
    }

}
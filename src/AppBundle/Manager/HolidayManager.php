<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Holiday;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;

class HolidayManager extends BaseManager
{
    /**
     * @var EntityManager $_em
     */
    protected $_em;
    const SERVICE_NAME = 'app.holiday_manager';

    /**
     * HolidayManager constructor.
     *
     * @param EntityManager $_em
     */
    public function __construct(EntityManager $_em)
    {
        $this->_em = $_em;
    }

    /**
     * @param int|null $year
     *
     * @return array
     */
    public function listAll($year = null)
    {
        $holidays = array();
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
        $list       = $this->_em->getRepository('AppBundle:Holiday')->getAvalaibleFromYear($year);
        $easterDate->modify('+' . $easterDay . ' day')->format('Y-m-d');
        foreach ($list as $lst) {
            $date = sprintf('%d-%d-%d', $lst['year'], $lst['month'], $lst['day']);
            array_push($holidays, $date);
        }
        array_push($holidays,
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

    public function add(\DateTime $date, $frequency = Holiday::EARLY)
    {
        $date = $date->format('Y-m-d');
        list($year, $month, $day) = preg_split('-', $date);
        $holiday = new Holiday();
        $holiday->setYear($year);
        $holiday->setMonth($month);
        $holiday->setDay($day);
        $holiday->setFrequency($frequency);
        $this->save($holiday);
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
        foreach ($range as $date) {
            if ($this->isHoliday($date)) {
                $count++;
            }
        }

        return $count;
    }
}
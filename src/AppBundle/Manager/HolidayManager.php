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
            $currentDate = new \DateTime();
            $year        = $currentDate->format('Y');
        }
        $currentDate = new \DateTime();
        $currentYear = $currentDate->format('Y');
        $easterDate = new \DateTime($currentYear . '-03-21');
        $easterDay  = easter_days($easterDate->format('Y'));
        $easterDate->modify('+' . $easterDay . ' day')->format('Y-m-d');

        list($holidays, $list) = $this->getArrayAvailableHolidays($year);

        $easterSunday = $easterDate;
        $easterMonday = $easterDate->modify('+1 day');
        $ascensionDay = $easterDate->modify('+38 day');
        $whitSunday = $easterDate->modify('+10 day');
        $whitMondday = $easterDate->modify('+1 day');
        array_push($holidays,
            $easterSunday,
            $easterMonday,
            $ascensionDay,
            $whitSunday,
            $whitMondday
        );
        $list['easter_sunday'] = $easterSunday;
        $list['easter_monday'] = $easterMonday;
        $list['ascension_day'] = $ascensionDay;
        $list['whit_sunday'] = $whitSunday;
        $list['whit_mondday'] = $whitMondday;

        sort($holidays);

        return array($holidays, $list);
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

        return (in_array($date, $holidays) || in_array($date->format('N'), array(6, 7)));
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

    /**
     * @param int $year
     *
     * @return array
     */
    public function getArrayAvailableHolidays($year)
    {
        $holidays = array();
        $list       = $this->entityManager->getRepository('AppBundle:Holiday')->getAvalaibleFromYear($year);
        $current = new \DateTime();
        $days = array();
        /**
         * @var Holiday $lst
         */
        foreach ($list as $lst) {
            switch ($lst->getFrequency()){
                case Holiday::F_EARLY:
                    $date = sprintf('%d-%d-%d', $current->format('Y') , $lst->getMonth(), $lst->getDay());
                    break;
                case Holiday::F_MONTHLY:
                    break;
                default:
                    $date = sprintf('%d-%d-%d', $lst->getYear(), $current->format('m'), $lst->getDay());
                    break;
            }
            $date = new \DateTime($date);
            $days[str_replace(' ', '_', $lst->getLabel())] = $date;
            array_push($holidays, $date);
        }

        return array($holidays, $days);
    }
}
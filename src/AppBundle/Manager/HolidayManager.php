<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Holiday;
use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class HolidayManager extends BaseManager
{
    const SERVICE_NAME = 'app.holiday_manager';
    /**
     * @var Translator $translator
     */
    private $translator;

    public function __construct(EntityManagerInterface $entityManager, Router $router, Translator $translator)
    {
        parent::__construct($entityManager, $router);
        $this->translator = $translator;
    }

    /**
     * @param int|null $year
     *
     * @return array
     */
    public function listAll($year = null)
    {
        if (is_null($year)) {
            $currentDate = new \DateTime();
            $currentYear        = $currentDate->format('Y');
        }else{
            $currentYear = $year;
        }
        $list       = $this->entityManager->getRepository('AppBundle:Holiday')->getAvalaibleFromYear($currentYear);
        $static     = $this->getStaticDates($currentYear);

        return array_merge($list, $static);
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
        $holidays = $this->getArrayAvailableHolidays($year);

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

        
        $date = $date instanceof \DateTime ? $date : new \DateTime($date);

        $holiday->setDate($date);
        $holiday->setFrequency($frequency);
        $holiday->setLabel($label);
        $this->saveHoliday($holiday);

        return $holiday;
    }

    public function saveHoliday($holiday)
    {
        $this->save($holiday);
        $this->flushAndClear();
    }
    /**
     * @param int $year
     *
     * @return array
     */
    public function getArrayAvailableHolidays($year)
    {
        if (is_null($year)) {
            $currentDate = new \DateTime();
            $year        = $currentDate->format('Y');
        }else{
            $currentYear = $year;
        }
        $holidays = array();
        $list       = $this->entityManager->getRepository('AppBundle:Holiday')->getAvalaibleFromYear($currentYear);
        $current = new \DateTime();
        $static     = $this->getStaticDates($currentYear);
        $holidayList = array_merge($list, $static);
        /**
         * @var Holiday $lst
         */
        foreach ($holidayList as $lst) {
            switch ($lst->getFrequency()){
                case Holiday::F_EARLY:
                    $cdate = $lst->getDate();
                    $date = $cdate->setDate(intval($currentYear),intval($cdate->format('m')),intval($cdate->format('d')));
                    break;
                default:
                    $date = $lst->getDate()->format('Y-m-d');
                    break;
            }

            array_push($holidays, $date);
        }

        return $holidays;
    }

    /**
     * @param int $year
     *
     * @return array
     */
    public function getStaticDates($year)
    {
        $holidays = [];
        if (is_null($year)) {
            $currentDate = new \DateTime();
            $year        = $currentDate->format('Y');
        }
        $currentDate  = new \DateTime();
        $currentYear  = $currentDate->format('Y');
        $easterDate   = new \DateTime($currentYear . '-03-21');
        $easterDay    = easter_days($easterDate->format('Y'));
        $easterSunday = clone $easterDate->modify('+' . $easterDay . ' day');
        $easterMonday = clone $easterDate->modify('+1 day');
        $ascencionDay = clone $easterDate->modify('+38 day');
        $whit_sunday  = clone $easterDate->modify('+10 day');
        $whit_monday  = clone $easterDate->modify('+1 day');
        $this->createVirtualHoliday($easterSunday, $this->translator->trans('label.holiday.easter_day', [], 'label'), $holidays);
        $this->createVirtualHoliday($easterMonday, $this->translator->trans('label.holiday.easter_monday', [], 'label'), $holidays);
        $this->createVirtualHoliday($ascencionDay, $this->translator->trans('label.holiday.ascension_day', [], 'label'), $holidays);
        $this->createVirtualHoliday($whit_sunday, $this->translator->trans('label.holiday.whit_sunday', [], 'label'), $holidays);
        $this->createVirtualHoliday($whit_monday, $this->translator->trans('label.holiday.whit_monday', [], 'label'), $holidays);

        return $holidays;

    }

    /**
     * @param mixed     $datetime
     * @param string    $label
     *
     * @return Holiday
     */
    private function createVirtualHoliday($datetime, $label='', &$holidays)
    {
        $date = new Holiday();
        $date->setDate($datetime);
        $date->setFrequency(Holiday::F_EARLY);
        $date->setLabel($label);
        $holidays[] = $date;
    }

    
}
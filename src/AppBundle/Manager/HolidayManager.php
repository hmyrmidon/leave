<?php

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;

class HolidayManager
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
        /**
         * @var \DateTime $easterDate
         */
        $easterDate = easter_date($year);
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
        $year = $date->format('Y');
        $holidays = $this->listAll($year);
        return (in_array($date->format('Y-m-d'), $holidays) || in_array($date->format('N'), array(6,7)));
    }

    /**
     * @param        $dateBegin
     * @param string $daysNumber Y for years,M for months, D for days, H for hours, i for minutes,S for seconds
     * @param string $dayPart All, AM, PM
     *
     * @return array
     */
    public static function getVacancies($dateBegin, $daysNumber = '1D', $dayPart = 'All')
    {
        $hour = '00:00:00';
        preg_match('#([0-9]+[.|?][0-9]+|[0-9]+)([D|d])#', $daysNumber, $datePattern);
        if(preg_match('#[.]#', $datePattern[1])){
            $parts = preg_split('#[.]#', $datePattern[1]);
            if($parts[0] > 0){
                $daysNumber = $parts[0].$datePattern[2];
            } else {
                if($dayPart === 'PM'){
                    $hour = '12:00:00';
                }
                $daysNumber = 'T'.(24*$datePattern[1]).'H';
            }
        }
        $dateBegin = new \DateTime($dateBegin.' '.$hour);
        $dateInterval = new \DateInterval('P'.$daysNumber);
        $dateRange = new \DatePeriod($dateBegin, $dateInterval, $dateBegin->add($dateInterval));
        foreach ($dateRange as $range){
            if($this->isHoliday($range)){
                $dateBegin->modify('+1 day');
            }
        }

        return $dateBegin;
    }

    /**
     * @param \DateTime $begin
     * @param \DateTime $end
     *
     * @return string
     */
    public function getDayNumber($begin, $end)
    {
        $begin = strtotime($begin);
        $end = strtotime($end);
        $diff = $end-$begin;
        return floor($diff/3600/24);
    }
}
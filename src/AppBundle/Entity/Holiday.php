<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class Holiday
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HolidayRepository")
 * @ORM\Table(name="holiday")
 * @package AppBundle\Entity
 */
class Holiday
{
    const F_EARLY = 0;
    const F_MONTHLY = 1;
    const F_WEEKLY = 2;

    use BaseTrait;
    /**
     * @var int $id
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var int $day
     * @ORM\Column(name="day", type="integer")
     */
    protected $day;
    /**
     * @var int $month
     * @ORM\Column(name="month", type="integer")
     */
    protected $month;
    /**
     * @var int $year
     * @ORM\Column(name="year", type="integer")
     */
    protected $year;
    /**
     * @var int $frequency
     * @ORM\Column(name="frequency", type="integer")
     */
    protected $frequency = self::F_EARLY;
    /**
     * @var string $label
     * @ORM\Column(name="label", type="string")
     */
    protected $label;

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param int $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

}

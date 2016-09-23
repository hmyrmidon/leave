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
     * @var int $date
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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

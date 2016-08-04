<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;
use AppBundle\Entity\BaseEntity as Base;
/**
 * Class VacationRequest
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="vacation_request")
 * @ORM\HasLifecycleCallbacks()
 */
class VacationRequest extends Base
{
    use BaseTrait;
    /**
     * @var int $id
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var \DateTime $startDate
     * @ORM\Column(name="start_date", type="datetime", nullable=false)
     */
    protected $startDate;
    /**
     * @var \DateTime $endDate
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    protected $endDate;
    /**
     * @var string $reason
     * @ORM\Column(name="reason", type="text", nullable=true)
     */
    protected $reason;
    /**
     * @var Employe $employee
     *
     */
    protected $employee;

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

}
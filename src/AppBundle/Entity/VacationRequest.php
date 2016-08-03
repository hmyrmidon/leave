<?php

namespace AppBundle\Entity;

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
     * @var Collection $validator
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\VacationValidator", mappedBy="vacationRequest")
     */
    protected $validator;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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

    /**
     * @return Collection
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param VacationValidator $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

}
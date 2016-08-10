<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;
/**
 * Class VacationRequest
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VacationRequestRepository")
 * @ORM\Table(name="vacation_request")
 * @ORM\HasLifecycleCallbacks()
 */
class VacationRequest
{
    const PENDING_STATUS = 0;
    const VALIDATE_STATUS = 1;
    const DENIED_STATUS = 2;
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
     * @var Employee $employee
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="vacation", cascade={"persist"})
     */
    protected $employee;

    /**
     * @var int $status
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
     * @var int $recovery
     * @ORM\Column(name="recovery", type="integer")
     */
    protected $recovery;
    /**
     * @ORM\OneToMany(targetEntity="VacationValidation", mappedBy="vacation")
     */
    protected $validation;

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
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }

    /**
     * @return WorkflowStep
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param WorkflowStep $step
     */
    public function setStep($step)
    {
        $this->step = $step;
    }

    /**
     * @return WorkflowStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param WorkflowStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    

    /**
     * Set recovery
     *
     * @param integer $recovery
     *
     * @return VacationRequest
     */
    public function setRecovery($recovery)
    {
        $this->recovery = $recovery;

        return $this;
    }

    /**
     * Get recovery
     *
     * @return integer
     */
    public function getRecovery()
    {
        return $this->recovery;
    }
}
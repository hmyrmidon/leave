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
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="vacation")
     */
    protected $employee;
    /**
     * @var User $validator
     * @ORM\ManyToOne(targetEntity="User", inversedBy="validation")
     */
    protected $validator;
    /**
     * @var WorkflowStep $step
     * @ORM\ManyToOne(targetEntity="WorkflowStep", inversedBy="validation")
     */
    protected $step;
    /**
     * @var WorkflowStatus $status
     * @ORM\ManyToOne(targetEntity="WorkflowStatus", inversedBy="validation")
     */
    protected $status;

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
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param mixed $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
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
    
}

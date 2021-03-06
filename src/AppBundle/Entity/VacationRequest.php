<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;
use AppBundle\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class VacationRequest
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VacationRequestRepository")
 * @ORM\Table(name="vacation_request")
 * @ORM\HasLifecycleCallbacks()
 * @AppAssert\ConstraintsVacationDate()
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
     * @Assert\NotBlank(message="messages.error.date_not_empty")
     */
    protected $startDate;

    /**
     * @var \DateTime $returnDate
     * @ORM\Column(name="end_date", type="datetime", nullable=false)
     * @Assert\NotBlank(message="messages.error.date_not_empty")
     */
    protected $returnDate;

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
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="vacation")
     */
    protected $type;

    /**
     *
     * @var \DateTime $returnDate
     * @ORM\Column(name="revival", type="text", nullable=true)
     */
    protected $revival;

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
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * @param \DateTime $returnDate
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;
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

    /**
     * @return mixed
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param mixed $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->validation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set revival
     *
     * @param string $revival
     *
     * @return VacationRequest
     */
    public function setRevival($revival)
    {
        $this->revival = $revival;

        return $this;
    }

    /**
     * Get revival
     *
     * @return string
     */
    public function getRevival()
    {
        return $this->revival;
    }

    /**
     * Add validation
     *
     * @param \AppBundle\Entity\VacationValidation $validation
     *
     * @return VacationRequest
     */
    public function addValidation(\AppBundle\Entity\VacationValidation $validation)
    {
        $this->validation[] = $validation;

        return $this;
    }

    /**
     * Remove validation
     *
     * @param \AppBundle\Entity\VacationValidation $validation
     */
    public function removeValidation(\AppBundle\Entity\VacationValidation $validation)
    {
        $this->validation->removeElement($validation);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}

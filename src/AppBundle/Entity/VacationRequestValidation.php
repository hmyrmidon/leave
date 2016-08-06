<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class VacationRequestStatus
 * @ORM\Entity()
 * @ORM\Table(name="vacation_request_validation")
 * @package AppBundle\Entity
 */
class VacationRequestValidation
{
    use BaseTrait;
    /**
     * @var int $id
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var VacationRequest $vacation
     * @ORM\ManyToOne(targetEntity="VacationRequest", inversedBy="")
     */
    protected $vacation;
    /**
     * @var User $validator
     * @ORM\ManyToOne(targetEntity="User", inversedBy="")
     */
    protected $validator;
    /**
     * @var WorkflowStep $step
     * @ORM\ManyToOne(targetEntity="WorkflowStep", inversedBy="")
     */
    protected $step;

    /**
     * @return VacationRequest
     */
    public function getVacation()
    {
        return $this->vacation;
    }

    /**
     * @param VacationRequest $vacation
     */
    public function setVacation($vacation)
    {
        $this->vacation = $vacation;
    }

    /**
     * @return User
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param User $validator
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

}
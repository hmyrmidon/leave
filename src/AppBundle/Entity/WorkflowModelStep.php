<?php

namespace AppBundle\Entity;
use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;
/**
 * Class WorkflowModel
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkflowModelRepository")
 * @ORM\Table(name="workflow_model_step")
 * @package AppBundle\Entity
 */
class WorkflowModelStep
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
     * @ORM\ManyToOne(targetEntity="WorkflowModel", inversedBy="wfModelStep")
     */
    protected $wfModel;
    /**
     * @ORM\ManyToOne(targetEntity="WorkflowStep", inversedBy="wfModelStep")
     */
    protected $wfStep;
    /**
     * @ORM\ManyToOne(targetEntity="WorkflowStatus", inversedBy="wfModelStep")
     */
    protected $wfStatus;
    /**
     * @var User $validator
     * @ORM\ManyToOne(targetEntity="User", inversedBy="wfModelStep")
     */
    protected $validator;

    /**
     * @return mixed
     */
    public function getWfModel()
    {
        return $this->wfModel;
    }

    /**
     * @param mixed $wfModel
     */
    public function setWfModel($wfModel)
    {
        $this->wfModel = $wfModel;
    }

    /**
     * @return mixed
     */
    public function getWfStep()
    {
        return $this->wfStep;
    }

    /**
     * @param mixed $wfStep
     */
    public function setWfStep($wfStep)
    {
        $this->wfStep = $wfStep;
    }

    /**
     * @return mixed
     */
    public function getWfStatus()
    {
        return $this->wfStatus;
    }

    /**
     * @param mixed $wfStatus
     */
    public function setWfStatus($wfStatus)
    {
        $this->wfStatus = $wfStatus;
    }


    /**
     * Set validator
     *
     * @param \AppBundle\Entity\User $validator
     *
     * @return WorkflowModelStep
     */
    public function setValidator(\AppBundle\Entity\User $validator = null)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get validator
     *
     * @return \AppBundle\Entity\User
     */
    public function getValidator()
    {
        return $this->validator;
    }
}

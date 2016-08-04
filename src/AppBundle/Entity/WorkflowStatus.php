<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class WorkflowStatus
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkflowStatusRepository")
 * @ORM\Table(name="workflow_status")
 */
class WorkflowStatus
{
    use BaseTrait;
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string $label
     * @ORM\Column(name="label", type="string", length=50)
     */
    protected $label;
    /**
     * @var WorkflowModel $workflow
     * @ORM\OneToMany(targetEntity="WorkflowModel", mappedBy="wfStatus")
     */
    protected $workflow;
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workflow = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add workflow
     *
     * @param \AppBundle\Entity\WorkflowModel $workflow
     *
     * @return WorkflowStatus
     */
    public function addWorkflow(\AppBundle\Entity\WorkflowModel $workflow)
    {
        $this->workflow[] = $workflow;

        return $this;
    }

    /**
     * Remove workflow
     *
     * @param \AppBundle\Entity\WorkflowModel $workflow
     */
    public function removeWorkflow(\AppBundle\Entity\WorkflowModel $workflow)
    {
        $this->workflow->removeElement($workflow);
    }

    /**
     * Get workflow
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }
}

<?php

namespace AppBundle\Entity;


use AppBundle\Traits\BaseTrait;
use AppBundle\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class WorkflowModel
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkflowModelRepository")
 * @ORM\Table(name="workflow_model")
 * @package AppBundle\Entity
 */
class WorkflowModel
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
     * @var string $label
     * @ORM\Column(name="label", type="string")
     */
    protected $label;
    /**
     * @var string $description
     * @ORM\Column(name="description", type="string")
     */
    protected $description;
    /**
     * @var WorkflowStatus $wfStatus
     * @ORM\ManyToOne(targetEntity="WorkflowStatus", inversedBy="workflow")
     */
    protected $wfStatus;
    /**
     * @var WorkflowStep $wfStep
     * @ORM\ManyToOne(targetEntity="WorkflowStep", inversedBy="workflow")
     */
    protected $wfStep;
    /**
     * @var TeamWorkflowModel $teamWf
     * @ORM\OneToMany(targetEntity="TeamWorkflowModel", mappedBy="workflow")
     */
    protected $teamWf;

    /**
     * WorkflowModel constructor.
     */
    public function __construct()
    {
        $this->teamWf = new ArrayCollection();
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return WorkflowStatus
     */
    public function getWfStatus()
    {
        return $this->wfStatus;
    }

    /**
     * @param WorkflowStatus $wfStatus
     */
    public function setWfStatus($wfStatus)
    {
        $this->wfStatus = $wfStatus;
    }

    /**
     * @return \AppBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param \AppBundle\Entity\Team $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }


    /**
     * Set wfStep
     *
     * @param \AppBundle\Entity\WorkflowStep $wfStep
     *
     * @return WorkflowModel
     */
    public function setWfStep(\AppBundle\Entity\WorkflowStep $wfStep = null)
    {
        $this->wfStep = $wfStep;

        return $this;
    }

    /**
     * Get wfStep
     *
     * @return \AppBundle\Entity\WorkflowStep
     */
    public function getWfStep()
    {
        return $this->wfStep;
    }

    /**
     * Add teamWf
     *
     * @param \AppBundle\Entity\TeamWorkflowModel $teamWf
     *
     * @return WorkflowModel
     */
    public function addTeamWf(\AppBundle\Entity\TeamWorkflowModel $teamWf)
    {
        $this->teamWf[] = $teamWf;

        return $this;
    }

    /**
     * Remove teamWf
     *
     * @param \AppBundle\Entity\TeamWorkflowModel $teamWf
     */
    public function removeTeamWf(\AppBundle\Entity\TeamWorkflowModel $teamWf)
    {
        $this->teamWf->removeElement($teamWf);
    }

    /**
     * Get teamWf
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamWf()
    {
        return $this->teamWf;
    }
}

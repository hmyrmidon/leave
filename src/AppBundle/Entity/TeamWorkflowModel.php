<?php

namespace AppBundle\Entity;
use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class WorkflowModel
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamWorkflowModelRepository")
 * @ORM\Table(name="team_workflow_model")
 * @package AppBundle\Entity
 */
class TeamWorkflowModel
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
     * @var WorkflowModel $workflow
     * @ORM\ManyToOne(targetEntity="WorkflowModel", inversedBy="teamWf")
     */
    protected $workflow;
    /**
     * @var Team $team
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="teamWf")
     */
    protected $team;

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
     * @return WorkflowModel
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param WorkflowModel $workflow
     */
    public function setWorkflow($workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 04/08/16
 * Time: 11:55
 */

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class Team
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 * @ORM\Table(name="team")
 * @package AppBundle\Entity
 */
class Team
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
     * @var string $description
     * @ORM\Column(name="name", type="string")
     */
    protected $name;
    /**
     * @var TeamWorkflowModel $teamWf
     * @ORM\OneToMany(targetEntity="WorkflowModelStep", mappedBy="team")
     */
    protected $wfModelStep;
    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="team")
     */
    protected $employee;

    /**
     * Team constructor.
     */
    public function __construct()
    {
        $this->teamWf = new ArrayCollection();
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return TeamWorkflowModel
     */
    public function getTeamWf()
    {
        return $this->teamWf;
    }

    /**
     * @param TeamWorkflowModel $teamWf
     */
    public function setTeamWf($teamWf)
    {
        $this->teamWf = $teamWf;
    }


    /**
     * Add teamWf
     *
     * @param \AppBundle\Entity\TeamWorkflowModel $teamWf
     *
     * @return Team
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
     * Add wfModelStep
     *
     * @param \AppBundle\Entity\WorkflowModelStep $wfModelStep
     *
     * @return Team
     */
    public function addWfModelStep(\AppBundle\Entity\WorkflowModelStep $wfModelStep)
    {
        $this->wfModelStep[] = $wfModelStep;

        return $this;
    }

    /**
     * Remove wfModelStep
     *
     * @param \AppBundle\Entity\WorkflowModelStep $wfModelStep
     */
    public function removeWfModelStep(\AppBundle\Entity\WorkflowModelStep $wfModelStep)
    {
        $this->wfModelStep->removeElement($wfModelStep);
    }

    /**
     * Get wfModelStep
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWfModelStep()
    {
        return $this->wfModelStep;
    }

    /**
     * Add employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return Team
     */
    public function addEmployee(\AppBundle\Entity\Employee $employee)
    {
        $this->employee[] = $employee;

        return $this;
    }

    /**
     * Remove employee
     *
     * @param \AppBundle\Entity\Employee $employee
     */
    public function removeEmployee(\AppBundle\Entity\Employee $employee)
    {
        $this->employee->removeElement($employee);
    }

    /**
     * Get employee
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}

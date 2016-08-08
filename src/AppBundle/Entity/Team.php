<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Team
 * Class Team
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 * @ORM\Table(name="team")
 * @package AppBundle\Entity
 */
class Team
{
    use BaseTrait;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var TeamWorkflowModel $teamWf
     * @ORM\OneToMany(targetEntity="WorkflowModelStep", mappedBy="team")
     */
    protected $wfModelStep;

    /**
     *
     * @var \Team
     * 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee", mappedBy="team")
     * 
     */
    private $employee;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return Team
     */
    public function setEmployee(\AppBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Team
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Team
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
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
}

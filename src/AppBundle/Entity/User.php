<?php

namespace AppBundle\Entity;


use AppBundle\Traits\BaseTrait;
use AppBundle\Entity\Employee;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 *
 */
class User extends BaseUser
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
     * @var Employee $employee
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $employee;

    /**
     * @var TeamWorkflowModel $teamWf
     * @ORM\OneToMany(targetEntity="TeamWorkflowModel", mappedBy="validator")
     */
    protected $teamWf;
    /**
     * @ORM\OneToMany(targetEntity="VacationRequestValidation", mappedBy="validator")
     */
    protected $validation;

    /**
     * @return \AppBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param \AppBundle\Entity\Employee $employee
     */
    public function setEmployee($employee=null)
    {
        $this->employee = $employee;
    }

    /**
     * Add teamWf
     *
     * @param \AppBundle\Entity\TeamWorkflowModel $teamWf
     *
     * @return User
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
    
}

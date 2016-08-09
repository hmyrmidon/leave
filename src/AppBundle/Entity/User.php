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
     * @ORM\OneToMany(targetEntity="VacationRequest", mappedBy="validator")
     */
    protected $vacation;

    /**
     * @ORM\OneToMany(targetEntity="TeamValidator", mappedBy="validator")
     */
    protected $teamValidator;

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
     * @return mixed
     */
    public function getVacation()
    {
        return $this->vacation;
    }

    /**
     * @param mixed $vacation
     */
    public function setVacation($vacation)
    {
        $this->vacation = $vacation;
    }

    /**
     * @return mixed
     */
    public function getTeamValidator()
    {
        return $this->teamValidator;
    }

    /**
     * @param mixed $teamValidator
     */
    public function setTeamValidator($teamValidator)
    {
        $this->teamValidator = $teamValidator;
    }
    

    /**
     * Add vacation
     *
     * @param \AppBundle\Entity\VacationRequest $vacation
     *
     * @return User
     */
    public function addVacation(\AppBundle\Entity\VacationRequest $vacation)
    {
        $this->vacation[] = $vacation;

        return $this;
    }

    /**
     * Remove vacation
     *
     * @param \AppBundle\Entity\VacationRequest $vacation
     */
    public function removeVacation(\AppBundle\Entity\VacationRequest $vacation)
    {
        $this->vacation->removeElement($vacation);
    }

    /**
     * Add teamValidator
     *
     * @param \AppBundle\Entity\TeamValidator $teamValidator
     *
     * @return User
     */
    public function addTeamValidator(\AppBundle\Entity\TeamValidator $teamValidator)
    {
        $this->teamValidator[] = $teamValidator;

        return $this;
    }

    /**
     * Remove teamValidator
     *
     * @param \AppBundle\Entity\TeamValidator $teamValidator
     */
    public function removeTeamValidator(\AppBundle\Entity\TeamValidator $teamValidator)
    {
        $this->teamValidator->removeElement($teamValidator);
    }
}

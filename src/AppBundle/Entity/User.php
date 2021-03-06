<?php

namespace AppBundle\Entity;


use AppBundle\Traits\BaseTrait;
use AppBundle\Entity\Employee;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="username", message="Ce nom d'utilisateur existe déjà.")
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
     *
     * @var string $last_name
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\NotBlank(message="Remplissez le nom de l'utilisateur.")
     * 
     */
    protected $lastName;

    /**
     *
     * @var string $last_name
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\NotBlank(message="Remplissez le prénom de l'utilisateur.")
     * 
     */
    protected $firstName;

    /**
     * @var Employee $employee
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $employee;

    /**
     * @ORM\OneToMany(targetEntity="TeamValidator", mappedBy="validator")
     */
    protected $teamValidator;

    /**
     * @Assert\Length(min=8, minMessage="message.form.length.password", groups={"admin_user_create"})
     * @Assert\NotBlank(message="message.form.notblank.password", groups={"admin_user_create"})
     * @var string
     */
    protected $plainPassword;

    /**
     * 
     * @Assert\NotBlank(message="message.form.notblank.email")
     * @Assert\Email(
     *      message = "message.form.email.notvalid",
     *      checkMX = true
     * )
     * 
     */
    protected $email;

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

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
}

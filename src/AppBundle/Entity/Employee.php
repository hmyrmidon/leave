<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\User;
use AppBundle\Traits\BaseTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Employee
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 * @ORM\Table(name="employee")
 * @UniqueEntity(fields="registrationNumber", message="Ce numero matricule existe déjà.")
 * 
 */
class Employee
{
    const MS_DIVORCED = 0;
    const MS_CELIBATARY = 1;
    const MS_MARRIED = 2;

    use BaseTrait;

    /**
     * @var int $id
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $lastName
     * @ORM\Column(name="last_name", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Remplissez le nom de l'employé.")
     */
    protected $lastName;

    /**
     * @var string $firstName
     * @ORM\Column(name="first_name", type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Remplissez le prénoms de l'employé.")
     */
    protected $firstName;

    /**
     * @var string $registrationNumber
     * @ORM\Column(name="registration_number", type="string", length=10, nullable=false)
     * @Assert\Type("digit", message="Valeur invalide, veuillez saisir des chiffres.")
     * @Assert\NotBlank(message="Remplissez le numero de matricule de l'employé.")
     */
    protected $registrationNumber;

    /**
     * @var \DateTime
     * @ORM\Column(name="hiring_date", type="datetime", nullable=false)
     * @Assert\NotBlank(message="Remplissez la date d'embauche de l'employé.")
     */
    protected $hiringDate;

    /**
     *
     * @var string $maritalStatus
     * @ORM\Column(name="marital_status", type="string", length=25, nullable=false)
     */
    protected $maritalStatus;

    /**
     *
     * @var string $address
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Remplissez l'adresse de l'employé.")
     */
    protected $address;

    /**
     *
     * @var integer
     * @ORM\Column(name="number_children", type="integer", nullable=true)
     * 
     */
    protected $nbChildren;

    /**
     *
     * @var \Datetime
     * @ORM\Column(name="birth_date", type="datetime", nullable=true)
     * 
     */
    protected $birthDate;

    /**
     *
     * @var \User
     * @ORM\OneToOne(targetEntity="User", inversedBy="employee", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    private $user;


    /**
     *
     * @var \Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="employee")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     *
     */
    private $team;

    /**
     * @var VacationRequest $vacation
     * @ORM\OneToMany(targetEntity="VacationRequest", mappedBy="employee")
     */
    protected $vacation;

    /**
     * @var float
     * @ORM\Column(name="balance", type="decimal", precision=5, scale=2, nullable=true)
     */
    protected $balance;

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
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }

    /**
     * @param string $registrationNumber
     */
    public function setRegistrationNumber($registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;
    }

    /**
     * @return \DateTime
     */
    public function getHiringDate()
    {
        return $this->hiringDate;
    }

    /**
     * @param \DateTime $hiringDate
     */
    public function setHiringDate($hiringDate)
    {
        $this->hiringDate = $hiringDate;
    }


    /**
     * Add team
     *
     * @param \AppBundle\Entity\Team $team
     *
     * @return Employee
     */
    public function addTeam(\AppBundle\Entity\Team $team)
    {
        $this->team[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \AppBundle\Entity\Team $team
     */
    public function removeTeam(\AppBundle\Entity\Team $team)
    {
        $this->team->removeElement($team);
    }

    /**
     * Get team
     *
     * @return \AppBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Employee
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set maritalStatus
     *
     * @param string $maritalStatus
     *
     * @return Employee
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    /**
     * Get maritalStatus
     *
     * @return string
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Employee
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set nbChildren
     *
     * @param integer $nbChildren
     *
     * @return Employee
     */
    public function setNbChildren($nbChildren)
    {
        $this->nbChildren = $nbChildren;

        return $this;
    }

    /**
     * Get nbChildren
     *
     * @return integer
     */
    public function getNbChildren()
    {
        return $this->nbChildren;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Employee
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Employee
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
     * @return Employee
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
     * Add vacation
     *
     * @param \AppBundle\Entity\VacationRequest $vacation
     *
     * @return Employee
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
     * Get vacation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVacation()
    {
        return $this->vacation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vacation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set team
     *
     * @param \AppBundle\Entity\Team $team
     *
     * @return Employee
     */
    public function setTeam(\AppBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

}

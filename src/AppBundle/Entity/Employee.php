<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Employee
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="employee")
 */
class Employee extends BaseUser
{
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
     */
    protected $lastName;
    /**
     * @var string $firstName
     * @ORM\Column(name="first_name", type="string", length=100, nullable=true)
     */
    protected $firstName;
    /**
     * @var string $registrationNumber
     * @ORM\Column(name="registration_number", type="string", length=10, nullable=false)
     */
    protected $registrationNumber;
    /**
     * @var \DateTime
     * @ORM\Column(name="hiring_date", type="datetime", nullable=false)
     */
    protected $hiringDate;

    /**
     *
     * @var \Team
     * 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Team", mappedBy="employee")
     * 
     */
    private $team;

    public function __construct()
    {
        parent::__construct();
    }

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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeam()
    {
        return $this->team;
    }
}

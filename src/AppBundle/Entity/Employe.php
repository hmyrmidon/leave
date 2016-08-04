<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;
/**
 * Class Employe
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="employe")
 */
class Employe
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
     * @var User $user
     * @ORM\OneToOne(targetEntity="User", mappedBy="employee")
     */
    protected $user;

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
     * @paramint $id
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

}
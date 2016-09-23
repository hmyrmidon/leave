<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Team
 * Class Team
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 * @ORM\Table(name="team")
 * @package AppBundle\Entity
 *  @UniqueEntity(fields="name", message="Ce nom d'équipe existe déjà.")
 * 
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
     * @Assert\NotBlank(message="Remplissez le nom de l'équipe.")
     */
    private $name;

    /**
     *
     * @var \Team
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee", mappedBy="team")
     *
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="TeamValidator", mappedBy="team")
     */
    protected $validator;

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
     * Constructor
     */
    public function __construct()
    {
        $this->wfModelStep = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employee = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add validator
     *
     * @param \AppBundle\Entity\TeamValidator $validator
     *
     * @return Team
     */
    public function addValidator(\AppBundle\Entity\TeamValidator $validator)
    {
        $this->validator[] = $validator;

        return $this;
    }

    /**
     * Remove validator
     *
     * @param \AppBundle\Entity\TeamValidator $validator
     */
    public function removeValidator(\AppBundle\Entity\TeamValidator $validator)
    {
        $this->validator->removeElement($validator);
    }

    /**
     * Get validator
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValidator()
    {
        return $this->validator;
    }
}

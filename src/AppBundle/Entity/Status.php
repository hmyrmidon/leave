<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class WorkflowStatus
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatusRepository")
 * @ORM\Table(name="status")
 */
class Status
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
     * @var string $label
     * @ORM\Column(name="label", type="string", length=50)
     */
    protected $label;
    /**
     * @ORM\OneToMany(targetEntity="VacationRequest", mappedBy="status")
     */
    protected $validation;
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
     * Add validation
     *
     * @param \AppBundle\Entity\VacationRequest $validation
     *
     * @return Status
     */
    public function addValidation(\AppBundle\Entity\VacationRequest $validation)
    {
        $this->validation[] = $validation;

        return $this;
    }

    /**
     * Remove validation
     *
     * @param \AppBundle\Entity\VacationRequest $validation
     */
    public function removeValidation(\AppBundle\Entity\VacationRequest $validation)
    {
        $this->validation->removeElement($validation);
    }

    /**
     * Get validation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValidation()
    {
        return $this->validation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->validation = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

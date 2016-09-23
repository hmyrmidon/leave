<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;
/**
 * Class Type
 * @ORM\Entity()
 * @ORM\Table(name="type")
 * @package AppBundle\Entity
 */
class Type
{
    use BaseTrait;
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    protected $name;
    /**
     * @var bool
     * @ORM\Column(type="boolean", name="deductable")
     */
    protected $deductable;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VacationRequest", mappedBy="type")
     */
    protected $vacation;

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
     * @return boolean
     */
    public function isDeductable()
    {
        return $this->deductable;
    }

    /**
     * @param boolean $deductable
     */
    public function setDeductable($deductable)
    {
        $this->deductable = $deductable;
    }

}
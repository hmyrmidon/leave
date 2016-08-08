<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class VacationValidation
 * @ORM\Entity()
 * @ORM\Table(name="vacation_validation")
 * @package AppBundle\Entity
 */
class VacationValidation
{
    use BaseTrait;
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="VacationRequest", inversedBy="id")
     */
    protected $vacation;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     */
    protected $manager;

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
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param mixed $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }
    
}
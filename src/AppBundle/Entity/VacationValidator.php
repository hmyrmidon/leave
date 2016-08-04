<?php

namespace AppBundle\Entity;


use AppBundle\Traits\BaseTrait;
use AppBundle\Entity\BaseEntity as Base;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class VacationValidator
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="vacation_validator")
 */
class VacationValidator extends Base
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
     * @var string $lastName
     */
    protected $lastName;
    /**
     * @var string $firstName
     */
    protected $firstName;

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
     * @return Collection
     */
    public function getVacationRequest()
    {
        return $this->vacationRequest;
    }

    /**
     * @param VacationRequest $vacationRequest
     */
    public function setVacationRequest($vacationRequest)
    {
        $this->vacationRequest = $vacationRequest;
    }
}

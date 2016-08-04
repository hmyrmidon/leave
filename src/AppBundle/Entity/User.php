<?php

namespace AppBundle\Entity;


use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Employe;
use \FOS\UserBundle\Model\User as BaseUser;
/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity()
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
     * @var Employe $employee
     * @ORM\OneToOne(targetEntity="Employe", inversedBy="user", orphanRemoval=false)
     */
    protected $employee;

    /**
     * @return \AppBundle\Entity\Employe
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param \AppBundle\Entity\Employe $employee
     */
    public function setEmployee($employee=null)
    {
        $this->employee = $employee;
    }
}
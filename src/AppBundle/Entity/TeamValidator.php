<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TeamValidator
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ValidatorRepository")
 * @ORM\Table(name="team_manager")
 * @package AppBundle\Entity
 */
class TeamValidator
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="teamValidator")
     */
    protected $validator;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="validator")
     */
    protected $team;

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param mixed $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }
}
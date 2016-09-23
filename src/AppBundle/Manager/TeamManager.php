<?php

namespace AppBundle\Manager;

use AppBundle\Manager\BaseManager;

class TeamManager extends BaseManager
{
    const TEAM_MANAGER = 'app.team_manager';

    public function addTeam($name)
    {
        $team = new \AppBundle\Entity\Team();

        $team->setName($name);

        $this->save($team);
        $this->flushAndClear();

        return $team;
    }

    public function editTeam(\AppBundle\Entity\Team $team)
    {
        $name = $team->getName();
        $team->setName($name);

        $this->save($team);
        $this->flushAndClear();

        return $team;
    }
}

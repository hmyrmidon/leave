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
}

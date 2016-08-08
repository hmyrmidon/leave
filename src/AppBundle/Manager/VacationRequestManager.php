<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\BaseManager;

/**
 * Class VacationRequestManager
 * @package AppBundle\Manager
 */
class VacationRequestManager extends BaseManager
{
    const SERVICE_NAME = 'app.vacation_request_manager';

    /**
     * @param int $vacation
     * @param int $validator
     *
     * @return void
     */
    public function validate($vacation, $validator)
    {
        $validator = $this->entityManager->getRepository('AppBundle:User')->find($validator);
        $vacc = $this->entityManager->getRepository('AppBundle:VacationRequest')->find($vacation);
        $this->entityManager->getRepository('AppBundle:VacationRequest')->validate($vacc, $validator);
    }
}
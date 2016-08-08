<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Event\OnSubmitVacationRequestEvent;
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
        $vacation = $this->entityManager->getRepository('AppBundle:VacationRequest')->find($vacation);
        $employee = $vacation->getEmployee();
        $team = $employee->getTeam();

        $status = $this->performStatus($team, $vacation);
        
        $vacation->setStatus($status);
        $vacation->setValidator($validator);

        $this->save($vacation);

        return $vacation;
    }

    /**
     * @param Team            $team
     * @param VacationRequest $vacation
     *
     * @return int
     */
    public function performStatus(Team $team, VacationRequest $vacation)
    {
        $teamResult = $this->entityManager->getRepository('AppBundle:TeamValidator')->findBy(array('team'=>$team));
        $vacationValidate = $this->entityManager->getRepository('AppBundle:VacationValidation')->findBy(array(
            'vacation' => $vacation
        ));

        $status = VacationRequest::PENDING_STATUS;
        if(count($teamResult) == count($vacationValidate)) {
            $status = VacationRequest::VALIDATE_STATUS;
        }

        return $status;
    }
}
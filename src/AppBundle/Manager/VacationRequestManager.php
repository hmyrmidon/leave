<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Entity\VacationValidation;
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
     * @param $params
     *
     * @return VacationRequest
     */
    public function saveVacation($params)
    {
        $employee = $this->entityManager->getRepository('AppBundle:Employee')->find($params['employee']);
        $startDate = new \DateTime($params['startDate']);
        $endDate = new \DateTime($params['endDate']);

        $vacation = new VacationRequest();
        $vacation->setEmployee($employee);
        $vacation->setStartDate($startDate);
        $vacation->setEndDate($endDate);
        $vacation->setStatus(VacationRequest::PENDING_STATUS);
        $vacation->setReason($params['reason']);
        $vacation->setRecovery(0);

        $this->save($vacation);

        return $vacation;
    }

    /**
     * @param $vacation
     * @param $validator
     */
    public function validate($vacation, $validator)
    {
        $validator = $this->entityManager->getRepository('AppBundle:User')->find($validator);
        $vacation  = $this->entityManager->getRepository('AppBundle:VacationRequest')->find($vacation);

        $validation = new VacationValidation();
        $validation->setManager($validator);
        $validation->setVacation($vacation);
        $this->save($validation);
        
        $employee  = $vacation->getEmployee();
        $team      = $employee->getTeam();
        $status    = $this->performStatus($team, $vacation);
        $vacation->setStatus($status);
        $this->save($vacation);

        $this->flushAndClear();

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
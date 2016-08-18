<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\Employee;
use AppBundle\Manager\BaseManager;
use AppBundle\Entity\VacationRequest;
use AppBundle\Entity\VacationValidation;
use Doctrine\DBAL\DBALException;

/**
 * Class VacationRequestManager
 * @package AppBundle\Manager
 */
class VacationRequestManager extends BaseManager
{
    const SERVICE_NAME = 'app.vacation_request_manager';

    /**
     * @param VacationRequest $vacation
     * @param Employee        $employee
     *
     * @return VacationRequest
     */
    public function saveVacation(VacationRequest $vacation, Employee $employee)
    {
        $vacation->setEmployee($employee);
        $vacation->setStatus(VacationRequest::PENDING_STATUS);
        $vacation->setRecovery(0);

        $this->save($vacation);
        $this->flushAndClear();

        return $vacation;
    }

    /**
     * @param $vacation
     * @param $validator
     */
    public function validate($vacation, $validator)
    {
        $validator = $validator instanceof User
            ? $validator
            : $this->entityManager->getRepository('AppBundle:User')->find($validator);
        $vacation  = $vacation instanceof VacationRequest
            ? $vacation
            : $this->entityManager->getRepository('AppBundle:VacationRequest')->find($vacation);

        $validation = new VacationValidation();
        $validation->setManager($validator);
        $validation->setVacation($vacation);
        $this->save($validation);

        $employee = $vacation->getEmployee();
        $team     = $employee->getTeam();
        $status   = $this->performStatus($team, $vacation);
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
        $teamResult       = $this->entityManager->getRepository('AppBundle:TeamValidator')
                                                ->findBy(array('team' => $team));
        $vacationValidate = $this->entityManager->getRepository('AppBundle:VacationValidation')->findBy(array(
            'vacation' => $vacation,
        ));

        $status = VacationRequest::PENDING_STATUS;
        if (count($teamResult) == count($vacationValidate)) {
            $status = VacationRequest::VALIDATE_STATUS;
        }

        return $status;
    }

    /**
     * @param User $validator
     */
    public function performListData(User $validator)
    {
        return $this->entityManager->getRepository('AppBundle:VacationRequest')->listBy($validator, VacationRequest::PENDING_STATUS);
    }

}
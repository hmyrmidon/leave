<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Team;
use AppBundle\Entity\Type;
use AppBundle\Entity\User;
use AppBundle\Entity\Employee;
use AppBundle\Manager\BaseManager;
use AppBundle\Entity\VacationRequest;
use AppBundle\Entity\VacationValidation;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class VacationRequestManager
 * @package AppBundle\Manager
 */
class VacationRequestManager extends BaseManager
{
    const SERVICE_NAME = 'app.vacation_request_manager';
    private $holiday;

    public function __construct(EntityManagerInterface $entityManager, Router $router, HolidayManager $holiday)
    {
        parent::__construct($entityManager, $router);
        $this->holiday = $holiday;
    }

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
        $now = new \DateTime();
        $revival = $now->format('Y-m-d H:i:s');
        $vacation->setRevival($revival);

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

        if($status == VacationRequest::VALIDATE_STATUS){
            $oldBalance = $employee->getBalance();
            $type = $vacation->getType();
            $days = 0;
            if($type->isDeductable()){
                $days = $this->holiday->getDayCount($vacation->getStartDate(), $vacation->getReturnDate());
            }
            $newBalance = floatval($oldBalance) - floatval($days);
            $employee->setBalance($newBalance);
            $this->save($employee);
        }

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
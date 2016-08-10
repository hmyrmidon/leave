<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Entity\VacationValidation;
use AppBundle\Event\OnSubmitVacationRequestEvent;
use AppBundle\Manager\BaseManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class VacationRequestManager
 * @package AppBundle\Manager
 */
class VacationRequestManager extends BaseManager implements DatatableManagerInterface
{
    const SERVICE_NAME = 'app.vacation_request_manager';

//--------------------PUBLIC FUNCTIONS-----------------------------------
    /**
     * @param $params
     *
     * @return VacationRequest
     */
    public function saveVacation($params)
    {
        $employee  = $this->entityManager->getRepository('AppBundle:Employee')->find($params['employee']);
        $startDate = new \DateTime($params['startDate']);
        $endDate   = new \DateTime($params['endDate']);

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

    public function getAvailableColumns()
    {
        return [
            [
                'label'     => '',
                'bSortable' => 0,
                'sWidth'    => "10%",
                'mData'     => '',
            ],
        ];
    }

//---------------------PRIVATE FUNCTIONS----------------------------------
    /**
     * @param Paginator $entity
     *
     * @return array
     */
    private function performDataSet($criteria, $currentPage = 0, $pageSize = 10)
    {
        $parameters   = $this->getQueryParameters();
        $orderColumns = $this->getOrderColumns();
        $orderBy      = [1, 'ASC'];
        $query        = $this->getListQuery($criteria, $orderBy, $currentPage, $pageSize);
        $queries      = [
            'query'      => $query,
            'parameters' => $parameters,
        ];
        $entity       = $this->getListPaginateBy($queries, $currentPage, $pageSize);
        $ResultSet    = array();
        $totalRecords = $entity->count();
        foreach ($entity as $item) {
            $data = array();
            array_push($ResultSet, $data);
        }

        return array(
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $ResultSet,
        );
    }

    /**
     * @return array
     */
    private function getQueryParameters()
    {
        return [];
    }

    /**
     * @return array
     */
    private function getOrderColumns()
    {
        return [];
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int   $currentPage
     * @param int   $pageSize
     */
    private function getListQuery($criteria, $orderBy, $currentPage = 0, $pageSize = 10)
    {
        $squery = "SELECT v FROM AppBundle:ValidationRequest v";

    }

}
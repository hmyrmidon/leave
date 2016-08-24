<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Status;
use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;

/**
 * VacationRequestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VacationRequestRepository extends \Doctrine\ORM\EntityRepository
{
    public function listBy(User $validator, $status = null)
    {
        $query = "SELECT v, e, t, u FROM AppBundle:VacationRequest v 
                          JOIN v.employee e 
                          JOIN e.team t
                          JOIN t.validator u
                          WHERE u.validator = :uid AND v.id NOT IN (
                            SELECT vc.id FROM AppBundle:VacationValidation vs JOIN vs.vacation vc WHERE vs.manager = :uid
                          ) ";
        if(!is_null($status)){
            $query .= ' AND v.status = :status';
            $params['status'] = $status;
        }
        $params['uid'] = $validator->getId();
        $list = $this->_em->createQuery($query)
                  ->setParameters($params)
                  ->getResult();

        return $list;
    }

    public function history($criteria)
    {
        return $this->_em->getRepository('AppBundle:VacationRequest')->findBy($criteria);
    }

    public function getVacationBy($params, $joinDql = '')
    {
        $dql = 'SELECT v FROM AppBundle:VacationRequest v '.$joinDql;

        $parameters = array();
        $conditions = array();
        foreach ($params as $key => $value) {
            $param = str_replace(".", "", $key);
            if ($value != "" && !is_null($value) && !is_array($value)) {
                $conditions[] = "$key = :$param";
                $parameters[$param] = $value;
            } elseif (is_array($value) && count($value) == 2 && $value[0]) {
                $val = $value[0];
                $ope = isset($value[1]) ? $value[1] : '=';
                $conditions[] = "$key $ope :$param";
                $parameters[$param] = ($ope == 'LIKE') ? "%$val%" : $val;
            }elseif (is_array($value) && count($value) == 3 && $value[0]){
                $val = $value[0];
                $ope = isset($value[1]) ? $value[1] : '=';
                $callback = isset($value[2]) ? $value[2] : '';
                $conditions[] = "$callback($key) $ope :$param";
                $parameters[$param] = ($ope == 'YEAR') ? "$val" : $val;
            }
        }

        if (count($conditions) > 0) {
            $dql .= ' WHERE '.implode(' AND ', $conditions);
        }
        //dump([$this->_em->createQuery($dql)->setParameters($parameters)->getSQL(), $parameters]);die;
        return $this->_em->createQuery($dql)->setParameters($parameters)->getResult();
    }

    public function getRevivalDayByStatus($vacationRequestId = array())
    {
        $query = $this->_em->createQuery('SELECT vr.revival FROM AppBundle:VacationRequest vr WHERE vr.status = 0 AND vr.id = :ids')
                ->setParameters('ids', $vacationRequestId);
        return $query->getResult();
    }

    public function findValidator()
    {
        $query = $this->_em->createQuery('SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role')
                ->setParameter('role', '%ROLE_VALIDATEUR%');
        return $query->getResult();
    }
}

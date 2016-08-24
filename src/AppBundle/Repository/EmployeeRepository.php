<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EmployeeRepository extends EntityRepository
{
    public function getEmployeeListByValidator(\AppBundle\Entity\User $user)
    {
        $query = $this->_em->createQuery('SELECT e, t, u, tm
                            FROM AppBundle:Employee e
                            JOIN e.team t
                            JOIN e.user u
                            JOIN t.validator tm
                            WHERE tm.validator = :uid
                            AND u.roles LIKE :role')
                ->setParameters(array('uid' => $user->getId(), 'role' => '%ROLE_CLIENT%'));
        return $query->getResult();
    }
}
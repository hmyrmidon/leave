<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class BaseManager 
{
    
    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * 
     * @param EntityManagerInterface $entityManager
     * @param Router $router
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, Router $router) 
    {
        $this->entityManager = $entityManager;
        $this->route         = $router;
    }

    /**
     * 
     * @param type $entity
     */
    public function save($entity)
    {
        $this->entityManager->persist($entity);
        
        return $entity;
    }

    /**
     * 
     * @param type $entity
     */
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->flushAndClear();
    }

    public function flushAndClear()
    {
        $this->entityManager->flush();
    }

    public function getListPaginateBy($queries, $currentPage, $pageSize)
    {
        $params       = $queries['parameters'];
        $squery       = $queries['squery'];

        $query     = $this->entityManager->createQuery($squery);
        $paginator = $this->paginate($query, $params, $currentPage, $pageSize);

        return $paginator;
    }

    /**
     * @param array $filter
     * <key> => <value> or
     * <alias.attribut> => <value> | array(<value>, <operation>)
     *
     * @return array
     */
    public function getQueryConditions($filter)
    {
        $parameters      = array();
        $conditionsQuery = array();
        foreach ($filter as $key => $value) {
            $keyparam = str_replace(".", "", $key);
            if ($value != "" && !is_null($value) && !is_array($value)) {
                $conditionsQuery[]     = "$key = :$keyparam";
                $parameters[$keyparam] = $value;
            } elseif (is_array($value) && count($value) == 2 && $value[0]) {
                $val                   = $value[0];
                $ope                   = isset($value[1]) ? $value[1] : '=';
                $conditionsQuery[]     = "$key $ope :$keyparam";
                $parameters[$keyparam] = ($ope == 'LIKE') ? "%$val%" : $val;
            }
        }

        return $conditionsQuery;
    }

    /**
     * @param array $orderColumns
     * <key> => <value> or
     * <alias.attribut> => <value> | array(<value>, <operation>)
     * @param array $orderBy
     * array(<index_of_item_in_$orderColumns>, ASC|DESC)
     *
     * @return string
     */
    public function getQueryOrderBy($orderColumns, $orderBy)
    {
        $squery = '';
        if (!is_null($orderBy)) {
            list($orderColumnIndex, $sortDir) = $orderBy;
            $sortCol = isset($orderColumns[$orderColumnIndex]) ? $orderColumns[$orderColumnIndex] : null;
            if (!is_null($sortCol) && in_array(strtoupper($sortDir), array('ASC', 'DESC'))) {
                $squery = " ORDER BY $sortCol $sortDir";
            }
        }

        return $squery;
    }

}

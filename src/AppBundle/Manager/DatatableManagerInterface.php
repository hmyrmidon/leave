<?php

namespace AppBundle\Manager;

interface DatatableManagerInterface
{
    /**
     * @return array
     */
    public function getAvailableColumns();
}
<?php

namespace AppBundle\Manager;


use AppBundle\Utils\Datatable;

class DatatableService
{
    public function initDatatable($manager, $prefix='', $checkboxOption = true)
    {
        if (method_exists($manager, 'getAvailableColumns')) {
            $listAllCol = $manager->getAvailableColumns();
        } else {
            throw new NotImplementedException(sprintf('Method getAvailableColumns not implemented in %s', get_class($manager)));
        }
        if (!is_null($this->request->get('listeColonnesAffichees'))) {
            $listeColonnesAffichees = $this->request->get('listeColonnesAffichees', array());
            $this->session->set($prefix.'listeColonnesAffichees', $listeColonnesAffichees);
        } else {
            $listeColonnesAffichees = (is_null($this->session->get($prefix.'listeColonnesAffichees'))) ? array_keys($listAllCol) : $this->session->get($prefix.'listeColonnesAffichees');
        }

        $datatable = new Datatable($listAllCol, $listeColonnesAffichees, $checkboxOption);

        return $datatable;
    }
}
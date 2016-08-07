<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\BaseManager;

class VacationRequestManager extends BaseManager
{
    const SERVICE_NAME = 'app.vacation_request_manager';

    public function validate($vacation, $validator)
    {
        $validator = $this->entityManager->getRepository('AppBundle:User')->find($validator);
        $params= array(
            'userid'=> $validator,
            'modelid'=>$vacation
        );
        $status = $this->entityManager->getRepository('AppBundle:WorkflowStatus')->getStatusBy($params);

        dump(array($vacation, $validator->getId(),$status));die;
    }
}
<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\VacationRequest;
use AppBundle\Manager\VacationRequestManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VacationController
 * @Route("/conge-permission")
 * @package AppBundle\Controller\Admin
 */
class VacationController extends Controller
{
    /**
     * @Route("/", name="app_vacation")
     * @param $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $validator = $this->getUser();
        $vacations = $this->get(VacationRequestManager::SERVICE_NAME)->performListData($validator);
        return $this->render(':vacation:list.html.twig', array('vacations'=>$vacations));
    }

    /**
     * @Route("/valider/{id}", name="app_vacation_validate")
     * @param VacationRequest $id
     */
    public function validateAction(VacationRequest $vacation)
    {
        $user = $this->getUser();
        if($this->get('app.vacation_request_manager')->validate($vacation, $user)){
            $this->get('session')->getFlashBag()->set('success', 'La demande a éte validé avec succès');
        }

        return $this->redirectToRoute('app_vacation');
    }
}

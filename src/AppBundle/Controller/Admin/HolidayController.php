<?php

namespace AppBundle\Controller\Admin;
use AppBundle\Entity\Holiday;
use AppBundle\Form\Handler\BaseHandler;
use AppBundle\Form\Type\HolidayType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HolidayController
 * @Route("/jours-feries")
 * @package AppBundle\Controller\Admin
 */
class HolidayController extends Controller
{
    /**
     * @Route("/{year}", name="app_holiday", defaults={"year":null}, requirements={"year":"\d+"})
     */
    public function listAction($year=null)
    {
        $list = $this->get('app.holiday_manager')->listAll($year);

        return $this->render(':admin/holiday:list.html.twig', ['list'=>$list]);
    }

    /**
     * @Route("/ajout", name="app_holiday_add")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $holiday = new Holiday();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(HolidayType::class, $holiday);
        $handler = new BaseHandler($form, $request, $entityManager);
        if($handler->process())
        return $this->render('admin/holiday/add.html.twig', ['form'=>$form->createView()]);
    }
    /**
     * @Route("/supprimer/{id}", name="app_holiday_delete", defaults={"id":0})
     */
    public function deleteAction(Holiday $holiday)
    {
        $this->get('app.holiday_manager')->delete($holiday);
    }
}
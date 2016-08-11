<?php

namespace AppBundle\Controller\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        list($holidays, $list) = $this->get('app.holiday_manager')->listAll($year);

        return $this->render(':admin/holiday:list.html.twig', ['list'=>$list]);
    }
}
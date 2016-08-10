<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TeamController
 * @package AppBundle\Controller\Admin
 * @Route("/team")
 * 
 */
class TeamController extends Controller
{
    /**
     * 
     * @return type
     * @Route("/", name="app_team")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('AppBundle:Team')->findAll();

        return $this->render('admin/team/list.html.twig', array(
            'teams' => $teams
        ));
    }

    /**
     * 
     * @param Request $request
     * @return type
     * 
     * @Route("/create", name="app_team_create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $team = new \AppBundle\Entity\Team();
        $teamForm = $this->createForm(\AppBundle\Form\Type\TeamType::class, $team);
        $formHandler = new \AppBundle\Form\Handler\BaseHandler($teamForm, $request, $em);
        if ($formHandler->process()) {
            $ogcUserManager = $this->get('app.team_manager');
            $ogcUserManager->save($team);
            $ogcUserManager->flushAndClear();

            $message = $this->get('translator')->trans('message.success.addTeam', array(), 'commun');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_team');
        }

        return $this->render('admin/team/create.html.twig', array(
            'form'   => $teamForm->createView()
        ));
    }

    /**
     * 
     * @param Request $request
     * @return type
     * 
     * @Route("/edit/{id}", name="app_team_edit")
     */
    public function editAction(Request $request, \AppBundle\Entity\Team $team)
    {
        $em = $this->getDoctrine()->getManager();
        $teamForm = $this->createForm(\AppBundle\Form\Type\TeamType::class, $team);
        $formHandler = new \AppBundle\Form\Handler\BaseHandler($teamForm, $request, $em);
        if ($formHandler->process()) {
            $ogcUserManager = $this->get('app.team_manager');
            $ogcUserManager->save($team);
            $ogcUserManager->flushAndClear();

            $message = $this->get('translator')->trans('message.success.addTeam', array(), 'commun');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_team');
        }

        return $this->render('admin/team/edit.html.twig', array(
            'form'   => $teamForm->createView(),
            'team'   => $team
        ));
    }

    /**
     * 
     * @param Request $request
     * @param \AppBundle\Controller\Admin\AppBundle\Entity\User $user
     * @return type
     * @Route("/delete/{id}", name="app_team_delete")
     */
    public function deleteAction(\AppBundle\Entity\Team $team)
    {
        $ogcUserManager = $this->get('app.team_manager');
        $ogcUserManager->delete($team);

        $flashMessage = $this->get('translator')->trans('message.success.deleteUser', array(), 'commun');
        $this->addFlash('success', $flashMessage);

        return $this->redirect($this->generateUrl('app_team'));
    }
}
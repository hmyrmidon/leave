<?php

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TypeController
 * @Route("/type")
 * @package AppBundle\Controller\Admin
 */
class TypeController extends Controller
{
    /**
     * @Route("/", name="app_type")
     */
    public function listAction()
    {
        $types = $this->getDoctrine()->getRepository('AppBundle:Type')->findAll();
        return $this->render(':admin/type:list.html.twig', ['types'=> $types]);
    }

    /**
     * @param Request $request
     * @param Type    $type
     *
     * @Route("/create", name="app_type_create")
     * @Route("/edit/{id}", name="app_type_edit", defaults={"id":null}, requirements={"id":"\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, Type $type=null)
    {
        $em = $this->getDoctrine()->getManager();
        if(is_null($type)){
            $type = new \AppBundle\Entity\Type();
        }
        $typeForm = $this->createForm(\AppBundle\Form\Type\VacationTypeType::class, $type);
        $formHandler = new \AppBundle\Form\Handler\BaseHandler($typeForm, $request, $em);
        if ($formHandler->process()) {
            $typeManager = $this->get(\AppBundle\Manager\TypeManager::SERVICE_NAME);
            $typeManager->save($type);
            $typeManager->flushAndClear();

            $message = $this->get('translator')->trans('message.success.add.type', array(), 'messages');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_type');
        }

        return $this->render(':admin/type:add.html.twig', array(
            'form'   => $typeForm->createView()
        ));
    }

    /**
     *
     * @param \AppBundle\Entity\Type $type
     * @return type
     *
     * @Route("/delete/{id}", name="app_type_delete")
     */
    public function deleteAction(Type $type)
    {
        $typeManager = $this->get(\AppBundle\Manager\TypeManager::SERVICE_NAME);
        $typeManager->delete($type);

        $flashMessage = $this->get('translator')->trans('message.success.delete.type', array(), 'messages');
        $this->addFlash('success', $flashMessage);

        return $this->redirect($this->generateUrl('app_type'));
    }
}
<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\ProfileController as BaseController;

/**
 * Class UserController
 * @package AppBundle\Controller\Admin
 * @Route("/user")
 * 
 */
class UserController extends BaseController
{
    /**
     * 
     * @return type
     * @Route("/", name="app_user")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('FOSUserBundle:user:list.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * 
     * @param Request $request
     * @return type
     * @Route("/create", name="app_user_create")
     */
    public function  createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new \AppBundle\Entity\User();

        $formUser  = $this->createForm(\AppBundle\Form\Type\CreateUserType::class, $user);
        $formHandler = new \AppBundle\Form\Handler\UserHandler($formUser, $request, $em);
        if ($user = $formHandler->process()) { 
            $pass = $user->getPlainPassword();
            $ogcUserManager = $this->get(\AppBundle\Manager\UserManager::USER_MANAGER);
            $ogcUserManager->save($user);
            $ogcUserManager->flushAndClear();
            $ogcUserManager->sendEmailOnCreateUser($user, $pass); 

            $flashMessage = $this->get('translator')->trans('message.success.add.user', array(), 'messages');
            $this->addFlash('success', $flashMessage);

            return $this->redirectToRoute('app_user');
        }

        return $this->render('FOSUserBundle:user:create.html.twig', array(
            'form'   => $formUser->createView()
        ));
    }

    /**
     * 
     * @param Request $request
     * @return type
     * @Route("/edit/{id}", name="app_user_edit")
     */
    public function editUserAction(Request $request, \AppBundle\Entity\User $user) 
    {
        $em = $this->getDoctrine()->getManager();
        $formUser  = $this->createForm(\AppBundle\Form\Type\CreateUserType::class, $user);
        $formHandler = new \AppBundle\Form\Handler\BaseHandler($formUser, $request, $em);
        if ($formHandler->process()) {
            $ogcUserManager = $this->get(\AppBundle\Manager\UserManager::USER_MANAGER);
            $ogcUserManager->save($user);
            $ogcUserManager->flushAndClear();

            $flashMessage = $this->get('translator')->trans('message.success.update.user', array(), 'messages');
            $this->addFlash('success', $flashMessage);

            return $this->redirectToRoute('app_user');
        }

        return $this->render('FOSUserBundle:user:edit.html.twig', array(
            'form'   => $formUser->createView(),
            'user'   => $user
        ));
    }

    /**
     * 
     * @param Request $request
     * @param \AppBundle\Controller\Admin\AppBundle\Entity\User $user
     * @return type
     * @Route("/delete/{id}", name="app_user_delete")
     */
    public function deleteAction(\AppBundle\Entity\User $user)
    {
        $ogcUserManager = $this->get(\AppBundle\Manager\UserManager::USER_MANAGER);
        $ogcUserManager->delete($user);

        $flashMessage = $this->get('translator')->trans('message.success.delete.user', array(), 'messages');
        $this->addFlash('success', $flashMessage);

        return $this->redirect($this->generateUrl('app_user'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     * @throws AccessDeniedException
     * 
     * @Route("/profil/edit", name="app_profil")
     */
    public function profilEditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof \AppBundle\Entity\User) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $event = new \FOS\UserBundle\Event\GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(\FOS\UserBundle\FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        $form = $this->createForm(\AppBundle\Form\Type\CreateUserType::class, $user);
        $handler = new \AppBundle\Form\Handler\BaseHandler($form, $request, $em);
        if ($handler->process()) {
            $ogcUserManager = $this->get(\AppBundle\Manager\UserManager::USER_MANAGER);
            $ogcUserManager->save($user);
            $ogcUserManager->flushAndClear();

            $flashMessage = $this->get('translator')->trans('message.success.update.user', array(), 'messages');
            $this->addFlash('success', $flashMessage);

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

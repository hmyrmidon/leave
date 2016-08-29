<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 * @Route("/profile")
 * @package AppBundle\Controller\Admin
 */
class ProfileController extends Controller
{
    /**
     *
     * @param Request $request
     * @return type
     * @throws AccessDeniedException
     *
     * @Route("/edit", name="app_profil")
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
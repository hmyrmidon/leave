<?php

namespace AppBundle\Form\Handler;


use AppBundle\Entity\User;
use AppBundle\Form\Handler\BaseHandler;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class VacationHandler extends BaseHandler
{
    /**
     * @var User $user
     */
    private $user;
    public function __construct(Form $form, Request $request, EntityManager $em, User $user)
    {
        parent::__construct($form, $request, $em);
        $this->user = $user;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function process()
    {
        $this->form->handleRequest($this->request);
        if ($this->request->isMethod('post') && $this->form->isValid() && $this->user->getEmployee()) {
            $this->entity = $this->form->getData();

            return true;
        }
        $error = $this->form->getErrors();

        return false;
    }
}
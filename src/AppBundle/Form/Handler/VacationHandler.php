<?php

namespace AppBundle\Form\Handler;

use AppBundle\Entity\User;
use AppBundle\Form\Handler\BaseHandler;

class VacationHandler extends BaseHandler
{
    public function process(User $user)
    {
        $this->form->handleRequest($this->request);
        if ($this->request->isMethod('post') && $this->form->isValid() && $user->getEmployee()) {
            $this->entity = $this->form->getData();

            return true;
        }
        $error = $this->form->getErrors();

        return false;
    }
}
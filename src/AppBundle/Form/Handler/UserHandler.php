<?php

namespace AppBundle\Form\Handler;

use AppBundle\Form\Handler\BaseHandler;

class UserHandler extends BaseHandler
{
    public function process()
    {
        $this->form->handleRequest($this->request);
        if ($this->request->isMethod('post') && $this->form->isValid()) {
            $user = $this->form->getData();

            return $user;
        }
          return false;
    }
}

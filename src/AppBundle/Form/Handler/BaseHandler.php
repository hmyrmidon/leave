<?php

namespace AppBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class BaseHandler 
{
    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Entity
     */
    protected $entity;


    /**
     * @param Form          $form
     * @param Request       $request
     * @param EntityManager $em
     */
    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }

    /**
     * @return bool
     */
    public function process()
    {
        $this->form->handleRequest($this->request);
        if ($this->request->isMethod('post') && $this->form->isValid()) {
            $this->entity = $this->form->getData();

            return true;
        }
        $error = $this->form->getErrors();
        //dump($error);die;
        
          return false;
    }

    
    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}

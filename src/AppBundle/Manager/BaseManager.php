<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class BaseManager 
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * 
     * @param EntityManagerInterface $entityManager
     * @param Router $router
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, Router $router) 
    {
        $this->entityManager = $entityManager;
        $this->route         = $router;
    }

    /**
     * 
     * @param type $entity
     */
    public function save($entity)
    {
        $this->entityManager->persist($entity);

        return $entity;
    }

    /**
     * 
     * @param type $entity
     */
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->flushAndClear();

        return true;
    }

    public function flushAndClear()
    {
        $this->entityManager->flush();
    }

    /**
     * sendMessage
     *
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array  $body
     *
     * @return boolean
     */
    public function sendMessage($from, $to, $subject, $template, $body)
    {
        try {
            $message = \Swift_Message::newInstance()
                ->setFrom($from)
                ->setTo($to)
                ->setSubject($this->translator->trans($subject, array(), 'common'))
                ->setBody($this->templating->render($template, $body))
                ->setContentType('text/html');

            return $this->mailer->send($message);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
